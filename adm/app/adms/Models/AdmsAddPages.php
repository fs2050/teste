<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsAddPages recebe as informações que serão enviadas para o banco de dados
 *
 * @author Celke
 */
class AdmsAddPages
{
    /** @var array $data Recebe as informações que serão enviadas para o banco de dados*/
    private array $data;
    
    /** @var array $dataExitVal Recebe as informações que serão retiradas da validação*/
    private array $dataExitVal;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas*/
    private bool $result;
    
    /** @var $listRegistryAdd Recebe informações que serão usadas no dropdown do formulário*/
    private $listRegistryAdd;
    
    /** @return Retorna o resultado verdadeiro ou falso*/
    function getResult() {
        return $this->result;
    }

    /** 
     * Método para validar os campos a serem preenchidos e retirar campos especificos da validação
     * @param array $data Recebe as informações que serão cadastradas no banco de dados*/
    public function create(array $data = null) {
        $this->data = $data;

        $this->dataExitVal['icon'] = $this->data['icon'];
        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['obs'], $this->data['icon']);

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
        $this->data['icon'] = $this->dataExitVal['icon'];
        $this->data['obs'] = $this->dataExitVal['obs'];
        $this->data['created'] = date("Y-m-d H:i:s");

        $createPage = new \App\adms\Models\helper\AdmsCreate();
        $createPage->exeCreate("adms_pages", $this->data);

        if ($createPage->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Página cadastrada com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não cadastrada com sucesso. Tente mais tarde!</div>";
            $this->result = false;
        }
    }
    
    /** Metodo para listar informações que serão utilizadas no dropdown do formulário */
    public function listSelect() {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_pgs ORDER BY name ASC");
        $registry['sit_page'] = $list->getResult();

        $list->fullRead("SELECT id id_type, type, name name_type FROM adms_types_pgs ORDER BY name ASC");
        $registry['type_page'] = $list->getResult();
        
        $list->fullRead("SELECT id id_group, name name_group FROM adms_groups_pgs ORDER BY name ASC");
        $registry['group_page'] = $list->getResult();

        $this->listRegistryAdd = ['sit_page' => $registry['sit_page'], 'type_page' => $registry['type_page'], 'group_page' => $registry['group_page']];

        return $this->listRegistryAdd;
    }

}
