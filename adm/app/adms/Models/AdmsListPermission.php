<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsListPermission Recebe as informações das permissões que serão listadas na View
 *
 * @author Celke
 */
class AdmsListPermission
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;
    
    /** @var int $level Recebe nível de acesso referente a permissão */
    private int $level;
    
    /** @var $limitResult Recebe o limite de resultados da páginação a serem exibidos na View*/
    private $limitResult = 40;
    
    /** @var $resultPg Recebe o resultado da páginação */
    private $resultPg;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado() {
        return $this->resultado;
    }

    /** @return Retorna o resultado do banco de dados*/
    function getResultadoBd() {
        return $this->resultadoBd;
    }

    /** @return Retorna o resultado da páginação a ser exibida na View*/
    function getResultPg() {
        return $this->resultPg;
    }

    /** Metodo buscar as informações na tabela adms_levels_pages e adms_access_levels e fazer a paginação do resultado que será mostrado na View listar permissões
     * 
     * @param $pag Retorna a páginação
     */
    public function listPermission($pag = null, $level = null) {

        $this->pag = (int) $pag;
        $this->level = (int) $level;

        $paginacao = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-permission/index', "?level={$this->level}");
        $paginacao->condition($this->pag, $this->limitResult);
        $paginacao->pagination("SELECT COUNT(lev_pag.id) AS num_result
                FROM adms_levels_pages lev_pag
                LEFT JOIN adms_pages AS pag ON pag.id=lev_pag.adms_page_id
                WHERE lev_pag.adms_access_level_id =:adms_access_level_id
                AND (((SELECT permission FROM adms_levels_pages
                WHERE adms_page_id = lev_pag.adms_page_id AND adms_access_level_id = {$_SESSION['adms_access_level_id']}) = 1) OR (pag.publish = 1))", 
                "adms_access_level_id=" . $this->level);
        $this->resultPg = $paginacao->getResult();

        $listPermission = new \App\adms\Models\helper\AdmsRead();
        $listPermission->fullRead("SELECT lev_pag.id, lev_pag.permission, lev_pag.order_level_page, lev_pag.print_menu, lev_pag.dropdown, lev_pag.adms_access_level_id, lev_pag.adms_page_id,
                pag.name_page
                FROM adms_levels_pages lev_pag
                LEFT JOIN adms_pages AS pag ON pag.id=lev_pag.adms_page_id
                INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id
                WHERE lev_pag.adms_access_level_id =:adms_access_level_id
                AND lev.order_levels >=:order_levels
                AND (((SELECT permission FROM adms_levels_pages 
                WHERE adms_page_id = lev_pag.adms_page_id 
                AND adms_access_level_id = {$_SESSION['adms_access_level_id']}) = 1) OR (pag.publish = 1))
                ORDER BY lev_pag.order_level_page ASC
                LIMIT :limit OFFSET :offset", "adms_access_level_id=" . $this->level . "&order_levels=" . $_SESSION['order_levels'] . "&limit={$this->limitResult}&offset={$paginacao->getOffset()}");

        $this->resultadoBd = $listPermission->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum permissão para o nível acesso encontrado!</div>";
            $this->resultado = false;
        }
    }

}
