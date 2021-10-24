<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeletePages Recebe as informações que serão deletadas do banco de dados
 *
 * @author Celke
 */
class DeletePages
{
    /** @var $id Recebe o ID da página que será deletada do sistema*/
    private $id;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deletePage = new \App\adms\Models\AdmsDeletePages();
            $deletePage->deletePages($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar uma página!";
        }
        
        $urlRedirect = URLADM . "list-pages/index";
        header("Location: $urlRedirect");
    }

}
