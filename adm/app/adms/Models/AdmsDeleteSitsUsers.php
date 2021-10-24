<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsDeleteSitsUsers recebe a informação que será deletada do banco de dados
 *
 * @author Celke
 */
class AdmsDeleteSitsUsers
{
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var int $id Contem a Id da situação de usuário que será deletada do sistema */
    private int $id;
    
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }
    
    /**
     * Método para fazer busca do Id na tabela adms_sits_users e validar o mesmo
     * @param array $id Recebe a informação que será validada e deletada do banco de dados */
    public function deleteSitsUser($id) {
        $this->id = (int) $id;

        if ($this->viewSitsUsers() AND $this->verfUserCad()) {
            $deleteSitsUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteSitsUser->exeDelete("adms_sits_users", "WHERE id =:id", "id={$this->id}");

            if ($deleteSitsUser->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação para usuário apagado com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não apagado com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se a situação de usuário está cadastrada no sistema, caso esteja o resultado é enviado para o metodo deleteSitsUser
     */
    private function viewSitsUsers() {
        $viewSitsUser = new \App\adms\Models\helper\AdmsRead();
        $viewSitsUser->fullRead("SELECT id FROM adms_sits_users
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewSitsUser->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
            return false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se tem usuários cadastrados no sistema usando a situação de usuário a ser deletada, caso esteja, o resultado é enviado para o metodo deleteSitsUser e a exclusão não é permitida
     */
    private function verfUserCad() {
        $viewUserCad = new \App\adms\Models\helper\AdmsRead();
        $viewUserCad->fullRead("SELECT id FROM adms_users WHERE adms_sits_user_id=:adms_sits_user_id LIMIT :limit", "adms_sits_user_id={$this->id}&limit=1");
        if($viewUserCad->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não pode ser apagada, há usuários cadastrados com essa situação!</div>";
            return false;
        }else{
            return true;
        }
    }

}
