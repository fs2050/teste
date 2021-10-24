<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditTypesPages Recebe as informações do tipo de página que serão editadas no banco de dados
 *
 * @author robson
 */
class AdmsEditTypesPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Recebe o ID do tipo de página que será editado */
    private int $id;
    
    /** @var array $data Recebe os dados serão enviados para a View */
    private array $data;
    
    /** @var array $dataExitVal Recebe os dados serão retirados da validação */
    private array $dataExitVal;
    
    /** @return Retorna o resultado do banco de dados*/
    function getResultDb() {
        return $this->resultDb;
    }
    
    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }

    /**
     * Método para fazer busca na tabela adms_types_pgs e validar as informações existentes sobre tipo de página antes de editar
     */
    public function viewTypesPages($id) {
        $this->id = (int) $id;
        $viewTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPages->fullRead("SELECT id, type, name, obs
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
    
    /**
     * Método para validar os dados antes que a edição seja feita e retirar campos especificos da validação
     * @param array $data Recebe a informação que será validada*/
    public function update(array $data) {
        $this->data = $data;
        
        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['obs']);
        
        $valEmptyField = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valEmptyField->validarDados($this->data);
        if ($valEmptyField->getResultado()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para salvar as informações editadas no banco de dados
     */
    private function edit() {
        $this->data['obs'] = $this->dataExitVal['obs'];
        $this->data['modified'] = date("Y-m-d H:i:s");
        
        $upTypesPages = new \App\adms\Models\helper\AdmsUpdate();
        $upTypesPages->exeUpdate("adms_types_pgs", $this->data, "WHERE id =:id", "id={$this->data['id']}");
        
        if($upTypesPages->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Tipo de página editado com sucesso!</div>";
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não editado com sucesso!</div>";
            $this->result = false;
        }
    }
}
