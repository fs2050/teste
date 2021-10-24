<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteConfEmails Recebe as informações que serão deletadas do banco de dados
 *
 * @author Celke
 */
class DeleteConfEmails
{
    /** @var $id Recebe o ID da confirmação de e-mail que será deletada do sistema*/
    private $id;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteConfEmails = new \App\adms\Models\AdmsDeleteConfEmails();
            $deleteConfEmails->deleteConfEmails($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um E-mail!";
        }
        
        $urlDestino = URLADM . "list-conf-emails/index";
        header("Location: $urlDestino");
    }

}
