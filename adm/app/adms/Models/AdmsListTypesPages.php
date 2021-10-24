<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsListTypesPages Recebe as informações dos tipos de páginas que serão listadas na View
 *
 * @author robson
 */
class AdmsListTypesPages
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
    function getResultDb()
    {
        return $this->resultDb;
    }

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool
    {
        return $this->result;
    }

    /** @return Retorna o resultado da páginação a ser exibida na View*/
    function getResultPg()
    {
        return $this->resultPg;
    }

    /** Metodo buscar as informações na tabela adms_types_pgs e fazer a paginação do resultado que será mostrado na View listar tipos de páginas
     * 
     * @param $pag Retorna a páginação
     */
    public function listTypesPages($pag = null)
    {
        $this->pag = (int) $pag;
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-types-pages/index');
        $pagination->condition($this->pag, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_types_pgs");
        $this->resultPg = $pagination->getResult();

        $listTypesPages = new \App\adms\Models\helper\AdmsRead();
        $listTypesPages->fullRead("SELECT id, type, name, order_type_pg
                    FROM adms_types_pgs
                    ORDER BY order_type_pg ASC
                    LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");
        $this->resultDb = $listTypesPages->getResult();
        if($this->resultDb){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum tipo de página encontrado!</div>";
            $this->result = false;
        }
    }

}
