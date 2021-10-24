<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteItemMenu
 *
 * @author Celke
 */
class DeleteItemMenu
{
    
    private $id;
    
    
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteItemMenu = new \App\adms\Models\AdmsDeleteItemMenu();
            $deleteItemMenu->deleteItemMenu($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um item de menu!";
        }
        
        $urlRedirect = URLADM . "list-item-menu/index";
        header("Location: $urlRedirect");
    }
}
