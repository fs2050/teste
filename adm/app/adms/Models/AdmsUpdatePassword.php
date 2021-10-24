<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsUpdatePassword Recebe as informações para atualizar a senha do usuário
 *
 * @author Celke
 */
class AdmsUpdatePassword
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var string $chave Recebe a chave para atualizar a senha */
    private string $chave;
    
    /** @var array $saveData Recebe as informações que serão salvas no banco de dados */
    private array $saveData;
    
    /** @var array $dados Recebe as informações que serão validadas */
    private array $dados;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado() {
        return $this->resultado;
    }

    /** Metodo recebe a chave e verifica na tabela usuários
     * 
     * @param array $chave Recebe a chave para recuperar a senha
     */
    public function validarChave($chave) {
        $this->chave = $chave;

        $viewChaveUpPass = new \App\adms\Models\helper\AdmsRead();
        $viewChaveUpPass->fullRead("SELECT id
                FROM adms_users
                WHERE recover_password =:recover_password
                LIMIT :limit",
                "recover_password={$this->chave}&limit=1");

        $this->resultadoBd = $viewChaveUpPass->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</div>";
            $this->resultado = false;
            return false;
        }
    }

    /**
     * Metodo para validar o campo do formulário
     * @param array $dados
     */
    public function editPassword(array $dados) {
        $this->dados = $dados;
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if($valCampoVazio->getResultado()){            
            $this->valInput();
        }else{
            $this->resultado = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo para validar a senha
     */
    private function valInput() {
        $valPassword= new \App\adms\Models\helper\AdmsValPassword();
        $valPassword->validarPassword($this->dados['password']);
        if($valPassword->getResultado()){
            //echo "Continuar alteração da senha<br>";
            //$this->resultado = true;
            if($this->validarChave($this->dados['chave'])){
                $this->updatePassword();
            }else{
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</div>";
            $this->resultado = false;
            }            
        }else{
            $this->resultado = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo para salvar a senha atualizada no banco de dados
     */
    private function updatePassword() {
        $this->saveData['recover_password'] = null;
        $this->saveData['password'] = password_hash($this->dados['password'], PASSWORD_DEFAULT);
        $this->saveData['modified'] = date("Y-m-d H:i:s");
        
        $upPassword = new \App\adms\Models\helper\AdmsUpdate();
        $upPassword->exeUpdate("adms_users", $this->saveData, "WHERE id=:id", "id={$this->resultadoBd[0]['id']}");
        if($upPassword->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Senha atualizada com sucesso!</div>";
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Senha não atualizada, tente novamente!</div>";
            $this->resultado = false;            
        }
        
    }

}
