<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditHomeTop 
 *
 * @author Celke
 */
class StsEditHomeTop
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
    
    public function viewHomeTop() {
        $viewHomeTop = new \App\adms\Models\helper\AdmsRead();
        $viewHomeTop->fullRead("SELECT id, title_top, description_top, link_btn_top, txt_btn_top
                FROM sts_homes_tops
                LIMIT :limit", "limit=1");

        $this->resultadoBd = $viewHomeTop->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo do topo da página home não encontrado!</div>";
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

        $upHomeTop = new \App\adms\Models\helper\AdmsUpdate();
        $upHomeTop->exeUpdate("sts_homes_tops", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upHomeTop->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Conteúdo do topo da página home editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo do topo da página home não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
