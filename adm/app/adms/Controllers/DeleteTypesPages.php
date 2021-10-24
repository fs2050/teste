<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteTypesPages Recebe as informações que serão deletadas do banco de dados
 *
 * @author robson
 */
class DeleteTypesPages
{
    /** @var $id Recebe o ID do tipo de página que será deletado do sistema*/
    private $id;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteTypesPages = new \App\adms\Models\AdmsDeleteTypesPages();
            $deleteTypesPages->deleteTypesPages($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um tipo de página!";
        }
        
        $urlRedirect = URLADM . "list-types-pages/index";
        header("Location: $urlRedirect");
    }
}
