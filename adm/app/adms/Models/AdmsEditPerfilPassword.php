<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditPerfilPassword recebe as informações da senha do perfil do usuário que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditPerfilPassword
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
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
     * Método para fazer busca na tabela adms_users e validar as informações existentes sobre o perfil do usuário antes de editar
     */
    public function viewPerfilPassword() {
        $viewPerfil = new \App\adms\Models\helper\AdmsRead();
        $viewPerfil->fullRead("SELECT id
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
     * Método para validar os dados antes que a edição seja feita
     * @param array $dados Recebe a informação que será validada*/
    public function update(array $dados) {
        $this->dados = $dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->valInput();
        } else {
            $this->resultado = false;
        }
    }    
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para validar a senha
     */
    private function valInput() {
        $valPassword = new \App\adms\Models\helper\AdmsValPassword();
        $valPassword->validarPassword($this->dados['password']);

        if ($valPassword->getResultado()) {
            $this->edit();
        } else {
            $this->resultado = false;
        }
    }    
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para salvar a senha no banco de dados
     */
    private function edit() {
        $this->dados['password'] = password_hash($this->dados['password'], PASSWORD_DEFAULT);
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->dados, "WHERE id =:id", "id={$_SESSION['user_id']}");

        if ($upUser->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Senha editada com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Senha não editada com sucesso!</div>";
            $this->resultado = false;
        }
    }
}
