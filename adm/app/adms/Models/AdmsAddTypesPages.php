<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsAddTypesPages recebe as informações que serão enviadas para o banco de dados
 *
 * @author robson
 */
class AdmsAddTypesPages
{
    /** @var array $data Recebe as informações que serão enviadas para o banco de dados*/
    private array $data;
    
    /** @var array $dataExitVal Recebe as informações que serão retiradas da validação*/
    private array $dataExitVal;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas*/
    private bool $result;
    
    /** @var bool $resultDb Recebe o resultado das informações que vieram do banco de dados*/
    private $resultDb;

    /** @return Retorna o resultado verdadeiro ou falso*/
    function getResult(): bool {
        return $this->result;
    }

    /** 
     * Método para validar os campos a serem preenchidos e retirar campo especifico da validação
     * @param array $data Recebe as informações que serão cadastradas no banco de dados*/
    public function create(array $data = null) {
        $this->data = $data;

        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['obs']);

        $valEmptyField = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valEmptyField->validarDados($this->data);
        if ($valEmptyField->getResultado()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo envia as informações recebidas do formulário para o banco de dados
     */
    private function add() {
        if ($this->viewLastTypesPages()) {
            $this->data['obs'] = $this->dataExitVal['obs'];
            $this->data['created'] = date("Y-m-d H:i:s");

            $createTypePage = new \App\adms\Models\helper\AdmsCreate();
            $createTypePage->exeCreate("adms_types_pgs", $this->data);

            if ($createTypePage->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Tipo de página cadastrado com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não cadastrado com sucesso. Tente mais tarde!</div>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo verificar a ultima ordem do tipo de página que esta cadastrado no banco de dados 
     */
    private function viewLastTypesPages() {
        $viewLastTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewLastTypesPages->fullRead("SELECT order_type_pg FROM adms_types_pgs ORDER BY order_type_pg DESC");
        $this->resultDb = $viewLastTypesPages->getResult();
        if ($this->resultDb) {
            $this->data['order_type_pg'] = $this->resultDb[0]['order_type_pg'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não cadastrado com sucesso. Tente mais tarde!</div>";
            return false;
        }
    }

}
