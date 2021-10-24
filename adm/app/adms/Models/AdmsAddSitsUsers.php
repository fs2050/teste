<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsAddSitsUsers recebe as informações que serão enviadas para o banco de dados
 *
 * @author Celke
 */
class AdmsAddSitsUsers
{
    /** @var array $dados Recebe as informações que serão enviadas para o banco de dados*/
    private array $dados;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas*/
    private bool $resultado;
    
    /** @var $listRegistryAdd Recebe informações que serão usadas no dropdown do formulário*/
    private $listRegistryAdd;

    /** @return Retorna o resultado verdadeiro ou falso*/
    function getResultado() {
        return $this->resultado;
    }

    /** 
     * Método para validar os campos a serem preenchidos
     * @param array $dados Recebe as informações que serão cadastradas no banco de dados*/
    public function create(array $dados = null) {
        $this->dados = $dados;
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->add();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo envia as informações recebidas do formulário para o banco de dados
     */
    private function add() {
        $this->dados['created'] = date("Y-m-d H:i:s");
        
        $createUser = new \App\adms\Models\helper\AdmsCreate();
        $createUser->exeCreate("adms_sits_users", $this->dados);

        if ($createUser->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação para usuário cadastrado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não cadastrado com sucesso. Tente mais tarde!</div>";
            $this->resultado = false;
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
