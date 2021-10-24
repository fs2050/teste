<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsListAboutsComp
 *
 * @author Celke
 */
class StsListAboutsComp 
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
    
    public function listAboutsComp($pag = null) {
        
        $this->pag = (int) $pag;
        $paginacao = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-abouts-comp/index');
        $paginacao->condition($this->pag, $this->limitResult);
        $paginacao->pagination("SELECT COUNT(comp.id) AS num_result FROM sts_abouts_companies comp");
        $this->resultPg = $paginacao->getResult();

        $listAboutsComp = new \App\adms\Models\helper\AdmsRead();
        $listAboutsComp->fullRead("SELECT id, title, sts_situation_id
                FROM sts_abouts_companies
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$paginacao->getOffset()}");

        $this->resultadoBd = $listAboutsComp->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum sobre empresa encontrado!</div>";
            $this->resultado = false;
        }
    }
}
