<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditAboutsComp
 *
 * @author Celke
 */
class StsEditAboutsComp
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
    
    public function viewAboutsComp($id) {
        $this->id = (int) $id;
        $viewAboutsComp = new \App\adms\Models\helper\AdmsRead();
        $viewAboutsComp->fullRead("SELECT id, title, description, sts_situation_id
                FROM sts_abouts_companies
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewAboutsComp->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não encontrado!</div>";
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

        $upAboutsComp = new \App\adms\Models\helper\AdmsUpdate();
        $upAboutsComp->exeUpdate("sts_abouts_companies", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upAboutsComp->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Sobre empresa editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
