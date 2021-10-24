<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsViewItemMenus
 *
 * @author Celke
 */
class AdmsViewItemMenus
{
    
    private $resultDb;
    private bool $result;
    private int $id;
    
    function getResultDb()
    {
        return $this->resultDb;
    }

    function getResult(): bool
    {
        return $this->result;
    }

    public function viewItemMenu($id) {
        $this->id = (int) $id;
        $viewItemMenu = new \App\adms\Models\helper\AdmsRead();
        $viewItemMenu->fullRead("SELECT id, name, icon, order_item_menu
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
}
