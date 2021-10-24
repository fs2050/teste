<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsListContactMsg
 *
 * @author Celke
 */
class StsListContactMsg 
{
    
    private $resultadoBd;
    private bool $resultado;
    private $pag;
    private $limitResult = 40;
    private $resultPg;

    function getResultado() {
        return $this->resultado;
    }
    
    function getResultadoBd() {
        return $this->resultadoBd;
    }
    
    function getResultPg() {
        return $this->resultPg;
    }
    
    public function listContactMsg($pag = null) {
        
        $this->pag = (int) $pag;
        $paginacao = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-contact-msg/index');
        $paginacao->condition($this->pag, $this->limitResult);
        $paginacao->pagination("SELECT COUNT(msg.id) AS num_result FROM sts_contacts_msgs msg");
        $this->resultPg = $paginacao->getResult();

        $listContactMsg = new \App\adms\Models\helper\AdmsRead();
        $listContactMsg->fullRead("SELECT id, name, email, subject
                FROM sts_contacts_msgs
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$paginacao->getOffset()}");

        $this->resultadoBd = $listContactMsg->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhuma mensagem de contato encontrada!</div>";
            $this->resultado = false;
        }
    }
}
