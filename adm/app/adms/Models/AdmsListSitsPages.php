<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsListSitsPages Recebe as informações das situações de páginas que serão listadas na View
 *
 * @author robson
 */
class AdmsListSitsPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;
    
    /** @var $limitResult Recebe o limite de resultados da páginação a serem exibidos na View*/
    private $limitResult = 40;
    
    /** @var $resultPg Recebe o resultado da páginação */
    private $resultPg;
    
    /** @return Retorna o resultado do banco de dados*/
    function getResultDb() {
        return $this->resultDb;
    }

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }

    /** @return Retorna o resultado da páginação a ser exibida na View*/
    function getResultPg() {
        return $this->resultPg;
    }

    /** Metodo buscar as informações na tabela adms_sits_pgs e fazer a paginação do resultado que será mostrado na View listar situações de páginas
     * 
     * @param $pag Retorna a páginação
     */
    public function listSitsPages($pag = null) {
        $this->pag = (int) $pag;
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-sits-pages/index');
        $pagination->condition($this->pag, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_sits_pgs");
        $this->resultPg = $pagination->getResult();
        
        $listSitsPages = new \App\adms\Models\helper\AdmsRead();
        $listSitsPages->fullRead("SELECT sit.id, sit.name,
                    cor.color
                    FROM adms_sits_pgs sit
                    LEFT JOIN adms_colors AS cor ON cor.id=sit.adms_color_id
                    LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");
        $this->resultDb = $listSitsPages->getResult();
        if($this->resultDb){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhuma situação de página encontrada!</div>";
            $this->result = false;
        }
    }
}
