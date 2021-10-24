<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditItemMenu
 *
 * @author Celke
 */
class AdmsEditItemMenu
{
    
    private $resultDb;
    private bool $result;
    private int $id;
    private array $data;
    
    function getResultDb() {
        return $this->resultDb;
    }

    function getResult(): bool {
        return $this->result;
    }

    public function viewItemMenu($id) {
        $this->id = (int) $id;
        $viewItemMenu = new \App\adms\Models\helper\AdmsRead();
        $viewItemMenu->fullRead("SELECT id, name, icon
                    FROM adms_items_menus
                    WHERE id=:id
                    LIMIT :limit", "id={$this->id}&limit=1");
        $this->resultDb = $viewItemMenu->getResult();
        if($this->resultDb){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não encontrado!</div>";
            $this->result = false;
        }
    }
    
    public function update(array $data) {
        $this->data = $data;
        
        $valEmptyField = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valEmptyField->validarDados($this->data);
        if ($valEmptyField->getResultado()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }
    
    private function edit() {
        $this->data['modified'] = date("Y-m-d H:i:s");
        
        $upItemMenu = new \App\adms\Models\helper\AdmsUpdate();
        $upItemMenu->exeUpdate("adms_items_menus", $this->data, "WHERE id =:id", "id={$this->data['id']}");
        
        if($upItemMenu->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Item de menu editado com sucesso!</div>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não editado com sucesso!</div>";
            $this->result = false;
        }
    }
}
