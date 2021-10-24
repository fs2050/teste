<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditPerfil recebe as informações do perfil do usuário que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditPerfil
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var array $dadosExitVal Recebe campos especificos do formulário que serão retirados da validação */
    private $dadosExitVal;
    
    /** @var array $dados Recebe as informações que serão editadas */
    private array $dados;
    
    /** @return Retorna o resultado do banco de dados*/
    function getResultadoBd() {
        return $this->resultadoBd;
    }
    
    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Método para fazer busca na tabela adms_users e validar as informações existentes antes de editar
     */
    public function viewPerfil() {
        $viewPerfil = new \App\adms\Models\helper\AdmsRead();
        $viewPerfil->fullRead("SELECT id, name, nickname, email, username
                FROM adms_users
                WHERE id=:id
                LIMIT :limit ", 
                "id={$_SESSION['user_id']}&limit=1");
        $this->resultadoBd = $viewPerfil->getResult();
        if($this->resultadoBd){
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
            $this->resultado = false;
        }
    }
    
    /**
     * Método para validar os dados antes que a edição seja feita e retirar campos especificos da validação
     * @param array $dados Recebe a informação que será validada*/
    public function update(array $dados) {
        $this->dados = $dados;
        
        $this->dadosExitVal['nickname'] = $this->dados['nickname'];
        unset($this->dados['nickname']);
        
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if($valCampoVazio->getResultado()){            
            $this->valInput();
        }else{
            $this->resultado = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para validar campos em que os dados devem ser unicos no banco de dados
     */
    private function valInput() {
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validarEmail($this->dados['email']);
        
        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validarEmailSingle($this->dados['email'], true, $_SESSION['user_id']);
        
        $valUserSingle = new \App\adms\Models\helper\AdmsValUserSingle();
        $valUserSingle->validarUserSingle($this->dados['username'], true, $_SESSION['user_id']);
        
        if($valEmail->getResultado() AND $valEmailSingle->getResultado() AND $valUserSingle->getResultado()){
            //$_SESSION['msg'] = "Continuar up";
            //$this->resultado = false;
            $this->edit();
        }else{
            $this->resultado = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para fazer a atualização das informações no banco de dados
     */
    private function edit() {
        $this->dados['nickname'] = $this->dadosExitVal['nickname'];
        $this->dados['modified'] = date("Y-m-d H:i:s");
        
        $upPerfil = new \App\adms\Models\helper\AdmsUpdate();
        $upPerfil->exeUpdate("adms_users", $this->dados, "WHERE id=:id", "id={$_SESSION['user_id']}");
        
        if($upPerfil->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Perfil editado com sucesso!</div>";
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Perfil não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }
           
}
