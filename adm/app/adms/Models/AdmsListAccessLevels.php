<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsListAccessLevels Recebe as informações do nível de acesso que será listada na View
 *
 * @author Celke
 */
class AdmsListAccessLevels 
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;
    
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
    
    /** Metodo buscar as informações na tabela adms_access_levels e fazer a paginação do resultado que será mostrado na View listar nível de acesso
     * 
     * @param $pag Retorna a páginação
     */
    public function listAccessLevels($pag = null) {
        
        $this->pag = (int) $pag;
        $paginacao = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-access-levels/index');
        $paginacao->condition($this->pag, $this->limitResult);
        $paginacao->pagination("SELECT COUNT(id) AS num_result FROM adms_access_levels WHERE order_levels >=:order_levels", "order_levels=" . $_SESSION['order_levels']);
        $this->resultPg = $paginacao->getResult();

        $listAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $listAccessLevels->fullRead("SELECT id, name, order_levels
                FROM adms_access_levels
                WHERE order_levels >=:order_levels
                ORDER BY order_levels ASC
                LIMIT :limit OFFSET :offset", "order_levels=" . $_SESSION['order_levels']."&limit={$this->limitResult}&offset={$paginacao->getOffset()}");

        $this->resultadoBd = $listAccessLevels->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum nível de acesso encontrado!</div>";
            $this->resultado = false;
        }
    }
}
