<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsViewTypesPages Recebe as informações para visualizar os detalhes do tipo de página
 *
 * @author robson
 */
class AdmsViewTypesPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Recebe o Id do tipo de página a ser visualizada*/
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
     * Metodo para pesquisar as informações no banco de dados na tabela adms_types_pgs
     * @param int $id Recebe o Id do tipo de página
     */
    public function viewTypesPages($id) {
        $this->id = (int) $id;
        $viewTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPages->fullRead("SELECT id, type, name, order_type_pg, obs
                FROM adms_types_pgs
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");
        $this->resultDb = $viewTypesPages->getResult();
        if($this->resultDb){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não encontrado!</div>";
            $this->result = false;
        }
    }
}
