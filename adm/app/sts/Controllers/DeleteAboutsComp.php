<?php

namespace App\sts\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe DeleteAboutsComp
 *
 * @author Celke
 */
class DeleteAboutsComp
{
    private $id;
    
    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteAboutsComp = new \App\sts\Models\StsDeleteAboutsComp();
            $deleteAboutsComp->deleteAboutsComp($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um registro!";
        }
        
        $urlDestino = URLADM . "list-abouts-comp/index";
        header("Location: $urlDestino");
    }

}
