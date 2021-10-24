<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteUsers Recebe as informações que serão deletadas do banco de dados
 *
 * @author Celke
 */
class DeleteUsers
{
    /** @var $id Recebe o ID do usuário que será deletado do sistema*/
    private $id;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteUser = new \App\adms\Models\AdmsDeleteUsers();
            $deleteUser->deleteUser($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um usuário!";
        }
        
        $urlDestino = URLADM . "list-users/index";
        header("Location: $urlDestino");
    }

}
