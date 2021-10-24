<?php

namespace App\sts\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteContactMsg
 *
 * @author Celke
 */
class DeleteContactMsg
{
    private $id;
    
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteContactMsg = new \App\sts\Models\StsDeleteContactMsg();
            $deleteContactMsg->deleteContactMsg($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um registro!";
        }
        
        $urlDestino = URLADM . "list-contact-msg/index";
        header("Location: $urlDestino");
    }

}
