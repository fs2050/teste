<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteGroupsPages Recebe as informações que serão deletadas do banco de dados
 *
 * @author robson
 */
class DeleteGroupsPages
{
    /** @var $id Recebe o ID do grupo de página que será deletado do sistema*/
    private $id;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteGroupsPages = new \App\adms\Models\AdmsDeleteGroupsPages();
            $deleteGroupsPages->deleteGroupsPages($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um grupo de página!";
        }
        
        $urlRedirect = URLADM . "list-groups-pages/index";
        header("Location: $urlRedirect");
    }
}
