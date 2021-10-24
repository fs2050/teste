<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditHomeDet 
 *
 * @author Celke
 */
class StsEditHomeDet
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
    
    public function viewHomeDet() {
        $viewHomeDet = new \App\adms\Models\helper\AdmsRead();
        $viewHomeDet->fullRead("SELECT id, title_det, subtitle_det, description_det
                FROM sts_homes_dets
                LIMIT :limit", "limit=1");

        $this->resultadoBd = $viewHomeDet->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo dos detalhes da página home não encontrado!</div>";
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

        $upHomeDet = new \App\adms\Models\helper\AdmsUpdate();
        $upHomeDet->exeUpdate("sts_homes_dets", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upHomeDet->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Conteúdo dos detalhes da página home editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo dos detalhes da página home não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
