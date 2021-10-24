<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteAccessLevels Recebe as informações que serão deletadas do banco de dados
 *
 * @author Celke
 */
class DeleteAccessLevels
{
    /** @var $id Recebe o ID do nível de acesso que será deletado do sistema*/
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteAccessLevels = new \App\adms\Models\AdmsDeleteAccessLevels();
            $deleteAccessLevels->deleteAccessLevels($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um nível de acesso!";
        }
        
        $urlDestino = URLADM . "list-access-levels/index";
        header("Location: $urlDestino");
    }

}
