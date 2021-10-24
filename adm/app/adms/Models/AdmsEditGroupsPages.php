<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditGroupsPages recebe as informações que serão editadas no banco de dados
 *
 * @author robson
 */
class AdmsEditGroupsPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Contem a Id do grupo de página que será editada no sistema */
    private int $id;
    
    /** @var array $data Recebe as informações que serão editadas */
    private array $data;
    
    /** @return Retorna o resultado do banco de dados*/
    function getResultDb() {
        return $this->resultDb;
    }

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }

    /**
     * Método para fazer busca do Id na tabela adms_groups_pgs e validar o mesmo
     * @param array $id Recebe a informação que será validada e editada no banco de dados */
    public function viewGroupsPages($id) {
        $this->id = (int) $id;
        $viewGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $viewGroupsPages->fullRead("SELECT id, name
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
    
    /**
     * Método para validar os dados antes que a edição seja feita
     * @param array $data Recebe a informação que será validada*/
    public function update(array $data) {
        $this->data = $data;
        
        $valEmptyField = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valEmptyField->validarDados($this->data);
        if ($valEmptyField->getResultado()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para fazer a atualização das informações no banco de dados
     */
    private function edit() {
        $this->data['modified'] = date("Y-m-d H:i:s");
        
        $upGroupsPages = new \App\adms\Models\helper\AdmsUpdate();
        $upGroupsPages->exeUpdate("adms_groups_pgs", $this->data, "WHERE id =:id", "id={$this->data['id']}");
        
        if($upGroupsPages->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Grupo de página editado com sucesso!</div>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Grupo de página não editado com sucesso!</div>";
            $this->result = false;
        }
    }
}
