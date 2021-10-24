<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteSitsUsers Recebe as informações que serão deletadas do banco de dados
 *
 * @author Celke
 */
class DeleteSitsUsers
{
    /** @var $id Recebe o ID da situação de usuário que será deletada do sistema*/
    private $id;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteSitsUser = new \App\adms\Models\AdmsDeleteSitsUsers();
            $deleteSitsUser->deleteSitsUser($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar uma situação para usuário!";
        }
        
        $urlDestino = URLADM . "list-sits-users/index";
        header("Location: $urlDestino");
    }

}
