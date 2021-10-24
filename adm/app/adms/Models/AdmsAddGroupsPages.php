<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsAddGroupsPages recebe as informações que serão enviadas para o banco de dados
 *
 * @author robson
 */
class AdmsAddGroupsPages
{
    /** @var array $data Recebe as informações que serão enviadas para o banco de dados*/
    private array $data;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas*/
    private bool $result;
    
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados*/
    private $resultDb;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }
    
    /** 
     * Método para validar os campos a serem preenchidos
     * @param array $data Recebe as informações que serão cadastradas no banco de dados*/
    public function create(array $data = null) {
        $this->data = $data;
        
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
        if ($this->viewLastGroupsPages()) {
            $this->data['created'] = date("Y-m-d H:i:s");

            $createGroupPage = new \App\adms\Models\helper\AdmsCreate();
            $createGroupPage->exeCreate("adms_groups_pgs", $this->data);

            if ($createGroupPage->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Grupo de página cadastrado com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Grupo de página não cadastrado com sucesso. Tente mais tarde!</div>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo para verificar qual é a última ordem do grupo de página que esta cadastrada no banco de dados
     */
    private function viewLastGroupsPages() {
        $viewLastGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $viewLastGroupsPages->fullRead("SELECT order_group_pg FROM adms_groups_pgs ORDER BY order_group_pg DESC");
        $this->resultDb = $viewLastGroupsPages->getResult();
        if ($this->resultDb) {
            $this->data['order_group_pg'] = $this->resultDb[0]['order_group_pg'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Grupo de página não cadastrado com sucesso. Tente mais tarde!</div>";
            return false;
        }
    }

}
