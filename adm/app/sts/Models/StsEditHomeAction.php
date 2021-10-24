<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditHomeAction 
 *
 * @author Celke
 */
class StsEditHomeAction
{
    private $resultadoBd;
    private bool $resultado;
    private array $dados;
    
    function getResultado(): bool {
        return $this->resultado;
    }

    function getResultadoBd() {
        return $this->resultadoBd;
    }
    
    public function viewHomeAction() {
        $viewHomeAction = new \App\adms\Models\helper\AdmsRead();
        $viewHomeAction->fullRead("SELECT id, title_action, subtitle_action, description_action, link_btn_action, txt_btn_action
                FROM sts_homes_actions
                LIMIT :limit", "limit=1");

        $this->resultadoBd = $viewHomeAction->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo da ação da página home não encontrado!</div>";
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

        $upHomeAction = new \App\adms\Models\helper\AdmsUpdate();
        $upHomeAction->exeUpdate("sts_homes_actions", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upHomeAction->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Conteúdo da ação da página home editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo da ação da página home não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
