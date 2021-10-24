<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsViewGroupsPages Recebe as informações para visualizar os detalhes do grupo de página
 *
 * @author robson
 */
class AdmsViewGroupsPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Recebe o Id do grupo de página a ser visualizada*/
    private int $id;
    
    /** @return Retorna o resultado que veio do banco de dados */
    function getResultDb()
    {
        return $this->resultDb;
    }

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Metodo para pesquisar as informações no banco de dados na tabela adms_groups_pgs
     * @param int $id Recebe o Id do grupo de página
     */
    public function viewGroupsPages($id) {
        $this->id = (int) $id;
        $viewGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $viewGroupsPages->fullRead("SELECT id, name, order_group_pg
                FROM adms_groups_pgs
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");
        $this->resultDb = $viewGroupsPages->getResult();
        if($this->resultDb){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Grupo de página não encontrado!</div>";
            $this->result = false;
        }
    }
}
