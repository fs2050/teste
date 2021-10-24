<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsAddSitsPages recebe as informações que serão enviadas para o banco de dados
 *
 * @author Celke
 */
class AdmsAddSitsPages
{
    /** @var array $data Recebe as informações que serão enviadas para o banco de dados*/
    private array $data;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas*/
    private bool $result;
    
    /** @var $listRegistryAdd Recebe informações que serão usadas no dropdown do formulário*/
    private $listRegistryAdd;

    /** @return Retorna o resultado verdadeiro ou falso*/
    function getResult() {
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
        $this->data['created'] = date("Y-m-d H:i:s");
        
        $createSitPages = new \App\adms\Models\helper\AdmsCreate();
        $createSitPages->exeCreate("adms_sits_pgs", $this->data);

        if ($createSitPages->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação de página cadastrada com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação de página não foi cadastrada com sucesso. Tente mais tarde!</div>";
            $this->result = false;
        }
    }
    
    /** Metodo para listar informações que serão utilizadas no dropdown do formulário */
    public function listSelect() {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_cor, name name_cor FROM adms_colors ORDER BY name ASC");
        $registry['cor'] = $list->getResult();
        
        $this->listRegistryAdd = ['cor' => $registry['cor']];
        
        return $this->listRegistryAdd;
    }

}
