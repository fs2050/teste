<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsAddItemMenu
 *
 * @author Celke
 */
class AdmsAddItemMenu
{
    
    private array $data;
    private bool $result;
    private $resultDb;
    
    function getResult(): bool {
        return $this->result;
    }
    
    public function create(array $data = null) {
        $this->data = $data;
        
        $valEmptyField = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valEmptyField->validarDados($this->data);
        if ($valEmptyField->getResultado()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }
    
    private function add() {
        if ($this->viewLastItemMenu()) {
            $this->data['created'] = date("Y-m-d H:i:s");

            $createItemMenu = new \App\adms\Models\helper\AdmsCreate();
            $createItemMenu->exeCreate("adms_items_menus", $this->data);

            if ($createItemMenu->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Item de menu cadastrado com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não cadastrado com sucesso. Tente mais tarde!</div>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
    
    private function viewLastItemMenu() {
        $viewLastItemMenu = new \App\adms\Models\helper\AdmsRead();
        $viewLastItemMenu->fullRead("SELECT order_item_menu FROM adms_items_menus ORDER BY order_item_menu DESC");
        $this->resultDb = $viewLastItemMenu->getResult();
        if ($this->resultDb) {
            $this->data['order_item_menu'] = $this->resultDb[0]['order_item_menu'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não cadastrado com sucesso. Tente mais tarde!</div>";
            return false;
        }
    }

}
