<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsConfEmail recebe as informações que serão atualizadas no banco de dados
 *
 * @author Celke
 */
class AdmsConfEmail 
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados*/
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas*/
    private bool $resultado;
    
    /** @var string $chave Variavel a chave de confirmação de cadastrp do usuário*/
    private string $chave;
    
    /** @var array $saveData Variavel contendo as informações que serão salvas no banco de dados */
    private array $saveData;

    /** @return Retorna o resultado verdadeiro ou falso*/
    function getResultado() {
        return $this->resultado;
    }

    /** 
     * Método para fazer busca da chave no banco de dados na tabela de usuarios e validar a mesma
     * @param array $chave Recebe a informação que será validada e salva no banco de dados*/
    public function confEmail($chave) {
        $this->chave = $chave;

        $viewChaveConfEmail = new \App\adms\Models\helper\AdmsRead();
        $viewChaveConfEmail->fullRead("SELECT id
                FROM adms_users
                WHERE conf_email =:conf_email
                LIMIT :limit",
                "conf_email={$this->chave}&limit=1");

        $this->resultadoBd = $viewChaveConfEmail->getResult();
        if ($this->resultadoBd) {
            $this->updateSitUser();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido!</div>";
            $this->resultado = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo para atualizar a situação de usuário no banco de dados, depois que a chave foi validada
     */
    private function updateSitUser() {
        $this->saveData['conf_email'] = null;
        $this->saveData['adms_sits_user_id'] = 1;
        $this->saveData['modified'] = date("Y-m-d H:i:s");

        $up_conf_email = new \App\adms\Models\helper\AdmsUpdate();
        $up_conf_email->exeUpdate("adms_users", $this->saveData, "WHERE id=:id", "id={$this->resultadoBd[0]['id']}");

        if ($up_conf_email->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>E-mail ativado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido!</div>";
            $this->resultado = false;
        }
    }

}
