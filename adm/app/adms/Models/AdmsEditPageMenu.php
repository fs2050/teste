<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditPageMenu
 *
 * @author Celke
 */
class AdmsEditPageMenu
{
    
    private $resultDb;
    private bool $result;
    private int $id;
    private array $data;
    private $listRegistryEdit;

    function getResult(): bool {
        return $this->result;
    }

    function getResultDb() {
        return $this->resultDb;
    }
    
    public function viewPageMenu($id) {
        $this->id = (int) $id;
        $viewPageMenu = new \App\adms\Models\helper\AdmsRead();
        $viewPageMenu->fullRead("SELECT id, adms_items_menu_id 
                FROM adms_levels_pages
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultDb = $viewPageMenu->getResult();
        if ($this->resultDb) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu da página não encontrado!</div>";
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

        $upPageMenu = new \App\adms\Models\helper\AdmsUpdate();
        $upPageMenu->exeUpdate("adms_levels_pages", $this->data, "WHERE id =:id", "id={$this->data['id']}");

        if ($upPageMenu->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Item de menu da página editado com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu de página não editado com sucesso!</div>";
            $this->result = false;
        }
    }
    
    /** Metodo usado para listar informações no dropdown do formulário*/
    public function listSelect() {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_itm, name name_itm FROM adms_items_menus ORDER BY name ASC");
        $registry['itm'] = $list->getResult();
        
        $this->listRegistryEdit = ['itm' => $registry['itm']];
        
        return $this->listRegistryEdit;
    }

}
