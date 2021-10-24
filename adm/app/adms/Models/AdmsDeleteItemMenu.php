<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsDeleteItemMenu
 *
 * @author Celke
 */
class AdmsDeleteItemMenu
{
    
    private bool $result;
    private int $id;
    private $resultDb;
    
    function getResult(): bool {
        return $this->result;
    }
    
    public function deleteItemMenu($id) {
        $this->id = (int) $id;
        if ($this->viewItemMenu() AND $this->verifyLevelPage()) {
            $deleteItemMenu = new \App\adms\Models\helper\AdmsDelete();
            $deleteItemMenu->exeDelete("adms_items_menus", "WHERE id =:id", "id={$this->id}");
            if ($deleteItemMenu->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Item de menu apagado com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não apagado com sucesso!</div>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
    
    private function viewItemMenu() {
        $viewItemMenu = new \App\adms\Models\helper\AdmsRead();
        $viewItemMenu->fullRead("SELECT id FROM adms_items_menus
                    WHERE id=:id
                    LIMIT :limit", "id={$this->id}&limit=1");
        $this->resultDb = $viewItemMenu->getResult();
        if ($this->resultDb) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não encontrado!</div>";
            return false;
        }
    }

    private function verifyLevelPage() {
        $verifyLevelPage = new \App\adms\Models\helper\AdmsRead();
        $verifyLevelPage->fullRead("SELECT id FROM adms_levels_pages WHERE adms_items_menu_id =:adms_items_menu_id LIMIT :limit", "adms_items_menu_id={$this->id}&limit=1");
        if ($verifyLevelPage->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: O item de menu não pode ser apagado, há permissões cadastradas com esse item de menu!</div>";
            return false;
        } else {
            return true;
        }
    }

}
