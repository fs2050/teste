<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsOrderItemMenu
 *
 * @author Celke
 */
class AdmsOrderItemMenu
{
    private $resultDb;
    private bool $result;
    private int $id;
    private array $data;
    private $resultDbPrev;
    
    function getResultDb() {
        return $this->resultDb;
    }

    function getResult(): bool {
        return $this->result;
    }

    
    public function orderItemMenu($id = null) {
        $this->id = (int) $id;
        $viewOrderItemMenu = new \App\adms\Models\helper\AdmsRead();
        $viewOrderItemMenu->fullRead("SELECT id, order_item_menu
                    FROM adms_items_menus
                    WHERE id=:id
                    LIMIT :limit", "id={$this->id}&limit=1");
        $this->resultDb = $viewOrderItemMenu->getResult();
        if ($this->resultDb) {
            $this->viewPrevItemMenu();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não encontrado!</div>";
            $this->result = false;
        }
    }

    private function viewPrevItemMenu() {
        $prevOrderItemMenu = new \App\adms\Models\helper\AdmsRead();
        $prevOrderItemMenu->fullRead("SELECT id, order_item_menu
                    FROM adms_items_menus
                    WHERE order_item_menu <:order_item_menu
                    ORDER BY order_item_menu DESC
                    LIMIT :limit", "order_item_menu={$this->resultDb[0]['order_item_menu']}&limit=1");
        $this->resultDbPrev = $prevOrderItemMenu->getResult();
        if ($this->resultDbPrev) {
            $this->editMoveDown();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não encontrado!</div>";
            $this->result = false;
        }
    }

    private function editMoveDown() {
        $this->data['order_item_menu'] = $this->resultDb[0]['order_item_menu'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_items_menus", $this->data, "WHERE id=:id", "id={$this->resultDbPrev[0]['id']}");

        if ($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem do item de menu não editado com sucesso!</div>";
            $this->result = false;
        }
    }

    private function editMoveUp() {
        $this->data['order_item_menu'] = $this->resultDbPrev[0]['order_item_menu'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_items_menus", $this->data, "WHERE id=:id", "id={$this->resultDb[0]['id']}");

        if ($moveDown->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Ordem do item de menu editado com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem do item de menu não editado com sucesso!</div>";
            $this->result = false;
        }
    }

}
