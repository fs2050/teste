<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteSitsPages Recebe as informações que serão deletadas do banco de dados
 *
 * @author Celke
 */
class DeleteSitsPages
{
    /** @var $id Recebe o ID da situação de página que será deletada do sistema*/
    private $id;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteSitsPages = new \App\adms\Models\AdmsDeleteSitsPages();
            $deleteSitsPages->deleteSitsPages($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar uma situação de página!";
        }
        
        $urlRedirect = URLADM . "list-sits-pages/index";
        header("Location: $urlRedirect");
    }

}
