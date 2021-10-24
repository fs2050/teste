<?php

namespace App\adms\Models\helper;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsPagination faz a paginação dos registros que foram pesquisados no banco de dados
 *
 * @author Celke
 */
class AdmsPagination
{
    /** @var $pag Recebe o número da página */
    private $pag;
    
    /** @var $limitResult Recebe o limite de resultado */
    private $limitResult;
    
    /** @var $offset Recebe o offset*/
    private $offset;
    
    /** @var $query Recebe a Query que faz a pesquisa no banco de dados*/
    private $query;
    
    /** @var $parseString Recebe a parseString*/
    private $parseString;
    
    /** @var $resultBd Recebe o resultado do que foi pesquisado no banco de dados*/
    private $resultBd;
    
    /** @var $result Recebe o resultado das informações que estão sendo manipuladas*/
    private $result;
    
    /** @var $totalPages Recebe o total de páginas*/
    private $totalPages;
    
    /** @var $maxLinks Recebe o numero máximo de links a serem exibidos na View*/
    private $maxLinks = 2;
    
    /** @var $link Recebe o link*/
    private $link;
    
    /** @var $var Recebe a variavel*/
    private $var;

    /**
     * Retorna o Offset
     * @return type Recebe o Offset
     */
    function getOffset() {
        return $this->offset;
    }

    /**
     * Retorna o resultado da páginação
     * @return type Recebe o resultado
     */
    function getResult() {
        return $this->result;
    }

    /**
     * Função para construir a paginação
     * @param type $link Recebe o link
     * @param type $var Recebe a variavel
     */
    function __construct($link, $var = null) {
        $this->link = $link;
        $this->var = $var;
    }

    /**
     * Metodo para criar a condição da paginação
     * @param type $pag Recebe a paginação
     * @param type $limitResult Recebe o limite do resultado
     */
    public function condition($pag, $limitResult) {
        $this->pag = (int) $pag ? $pag : 1;
        $this->limitResult = (int) $limitResult;

        $this->offset = ($this->pag * $this->limitResult) - $this->limitResult;
    }

    /**
     * Metodo recebe a Query e a ParseString
     * @param type $query Recebe a query que faz a pesquisa no banco de dados
     * @param type $parseString Recebe a parseString
     */
    public function pagination($query, $parseString = null) {
        $this->query = (string) $query;
        $this->parseString = (string) $parseString;
        $count = new \App\adms\Models\helper\AdmsRead();
        $count->fullRead($this->query, $this->parseString);
        $this->resultBd = $count->getResult();
        $this->pagInstruction();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo faz o calculo para que a páginação seja exibida corretamente na View
     */
    private function pagInstruction() {
        $this->totalPages = ceil($this->resultBd[0]['num_result'] / $this->limitResult);
        if ($this->totalPages >= $this->pag) {
            $this->layoutPagination();
        } else {
            header("Location: {$this->link}");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo criar o layout da paginação
     */
    private function layoutPagination() {
        $this->result = "<nav aria-label='paginacao'>";
        $this->result .= "<ul class='pagination pagination-sm justify-content-center'>";

        $firstDis = "";
        if($this->pag == 1){
            $firstDis = " disabled";
        }
        $this->result .= "<li class='page-item $firstDis'><a href='" . $this->link . $this->var . "' class='page-link'>Primeira</a></li>";
        
        for($beforePag = $this->pag - $this->maxLinks; $beforePag <= $this->pag - 1; $beforePag++){
            if($beforePag >= 1){
                $this->result .= "<li class='page-item'><a href='" . $this->link ."/". $beforePag . $this->var . "' class='page-link'>$beforePag</a></li>";
            }
        }             
                
        $this->result .= "<li class='page-item active'><a href='#' class='page-link'>" . $this->pag . "</a></li>";
        
        for($afterPag = $this->pag + 1; $afterPag <= $this->pag + $this->maxLinks; $afterPag++){
            if($afterPag <= $this->totalPages){
                $this->result .= "<li class='page-item'><a href='" . $this->link ."/". $afterPag . $this->var . "' class='page-link'>$afterPag</a></li>";
            }
        }
        
        
        $lastDis = "";
        if($this->pag == $this->totalPages){
            $lastDis = " disabled";
        }
        
        $this->result .= "<li class='page-item $lastDis'><a href='" . $this->link ."/". $this->totalPages . $this->var . "' class='page-link'>Última</a></li>";

        $this->result .= "</ul>";
        
        $this->result .= "</nav>";
    }

}
