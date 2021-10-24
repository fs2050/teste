<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsViewSitsPages Recebe as informações para visualizar os detalhes da situação de página
 *
 * @author Celke
 */
class AdmsViewSitsPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Recebe o Id da situação de página a ser visualizada*/
    private int $id;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }
    
    /** @return Retorna o resultado que veio do banco de dados */
    function getResultBd() {
        return $this->resultDb;
    }

    /**
     * Metodo para pesquisar as informações no banco de dados na tabela adms_sits_pgs
     * @param int $id Recebe o Id da situação de página
     */
    public function viewSitsPages($id) {
        $this->id = (int) $id;
        $viewSitsPages = new \App\adms\Models\helper\AdmsRead();
        $viewSitsPages->fullRead("SELECT sit.id, sit.name,
                cor.color
                FROM adms_sits_pgs sit
                LEFT JOIN adms_colors AS cor ON cor.id=sit.adms_color_id
                WHERE sit.id=:id
                LIMIT :limit", "id={$this->id}&limit=1");
                
        $this->resultDb = $viewSitsPages->getResult();
        if($this->resultDb){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação de página não encontrada!</div>";
            $this->result = false;
        }
    }

}
