<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsViewLevelsForms Recebe as informações para visualizar os detalhes do Levels Forms
 *
 * @author Celke
 */
class AdmsViewLevelsForms
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    /** @return Retorna o resultado que veio do banco de dados */
    function getResultadoBd() {
        return $this->resultadoBd;
    }

    /**
     * Metodo para pesquisar as informações no banco de dados na tabela adms_levels_forms
     */
    public function viewLevelsForms() {
        $viewLevelsForms = new \App\adms\Models\helper\AdmsRead();
        $viewLevelsForms->fullRead("SELECT form.id, form.adms_access_level_id,
                lev.name name_lev
                FROM adms_levels_forms form
                INNER JOIN adms_access_levels AS lev ON lev.id=form.adms_access_level_id
                LIMIT :limit", "limit=1");

        $this->resultadoBd = $viewLevelsForms->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso para formulário novo usuário não encontrado!</div>";
            $this->resultado = false;
        }
    }

}
