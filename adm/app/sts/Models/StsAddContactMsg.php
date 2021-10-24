<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsAddContactMsg
 *
 * @author Celke
 */
class StsAddContactMsg
{
    private array $dados;
    private bool $resultado;
    
    function getResultado() {
        return $this->resultado;
    }

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

    private function add() {
        $this->dados['created'] = date("Y-m-d H:i:s");
        
        $createContactMsg = new \App\adms\Models\helper\AdmsCreate();
        $createContactMsg->exeCreate("sts_contacts_msgs", $this->dados);

        if ($createContactMsg->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Mensagem de contato cadastrada com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não cadastrada com sucesso. Tente mais tarde!</div>";
            $this->resultado = false;
        }
    }

}
