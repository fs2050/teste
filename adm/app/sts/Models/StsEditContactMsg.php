<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditContactMsg
 *
 * @author Celke
 */
class StsEditContactMsg
{
    private $resultadoBd;
    private bool $resultado;
    private int $id;
    private array $dados;
    
    function getResultado(): bool {
        return $this->resultado;
    }

    function getResultadoBd() {
        return $this->resultadoBd;
    }
    
    public function viewContactMsg($id) {
        $this->id = (int) $id;
        $viewContactMsg = new \App\adms\Models\helper\AdmsRead();
        $viewContactMsg->fullRead("SELECT id, name, email, subject, content
                FROM sts_contacts_msgs
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewContactMsg->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não encontrada!</div>";
            $this->resultado = false;
        }
    }
    
    public function update(array $dados) {
        $this->dados = $dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->edit();
        } else {
            $this->resultado = false;
        }
    }

    private function edit() {
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upContactMsg = new \App\adms\Models\helper\AdmsUpdate();
        $upContactMsg->exeUpdate("sts_contacts_msgs", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upContactMsg->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Mensagem de contato editada com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não editada com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
