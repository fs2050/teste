<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsListUsers Recebe as informações dos usuários que serão listados na View
 *
 * @author Celke
 */
class AdmsListUsers
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

    /** Metodo buscar as informações na tabela adms_users e fazer a paginação do resultado que será mostrado na View listar usuários
     * 
     * @param $pag Retorna a páginação
     */
    public function listUsers($pag = null) {

        $this->pag = (int) $pag;
        $paginacao = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index');
        $paginacao->condition($this->pag, $this->limitResult);
        $paginacao->pagination("SELECT COUNT(usu.id) AS num_result
                FROM adms_users usu
                INNER JOIN adms_access_levels AS lev ON lev.id=usu.adms_access_level_id
                WHERE lev.order_levels >:order_levels", "order_levels=" . $_SESSION['order_levels']);
        $this->resultPg = $paginacao->getResult();

        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("SELECT usu.id, usu.name, usu.email,
                sit.name name_sit,
                cor.color
                FROM adms_users usu
                LEFT JOIN adms_sits_users AS sit ON sit.id=usu.adms_sits_user_id
                LEFT JOIN adms_colors AS cor ON cor.id=sit.adms_color_id
                INNER JOIN adms_access_levels AS lev ON lev.id=usu.adms_access_level_id
                WHERE lev.order_levels >:order_levels
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset", "order_levels=" . $_SESSION['order_levels'] . "&limit={$this->limitResult}&offset={$paginacao->getOffset()}");

        $this->resultadoBd = $listUsers->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum usuário encontrado!</div>";
            $this->resultado = false;
        }
    }

}
