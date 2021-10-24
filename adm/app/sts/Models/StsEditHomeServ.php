<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditHomeServ 
 *
 * @author Celke
 */
class StsEditHomeServ
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
    
    public function viewHomeServ() {
        $viewHomeServ = new \App\adms\Models\helper\AdmsRead();
        $viewHomeServ->fullRead("SELECT id, title_serv, description_serv, icone_um_serv, titulo_um_serv, description_um_serv, icone_dois_serv, titulo_dois_serv, description_dois_serv, icone_tres_serv, titulo_tres_serv, description_tres_serv
                FROM sts_homes_servs
                LIMIT :limit", "limit=1");

        $this->resultadoBd = $viewHomeServ->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo do serviço da página home não encontrado!</div>";
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

        $upHomeServ = new \App\adms\Models\helper\AdmsUpdate();
        $upHomeServ->exeUpdate("sts_homes_servs", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upHomeServ->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Conteúdo do serviço da página home editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo do serviço da página home não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
