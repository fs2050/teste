<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditPageContact 
 *
 * @author Celke
 */
class StsEditPageContact
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
    
    public function viewPageContact() {
        $viewPageContact = new \App\adms\Models\helper\AdmsRead();
        $viewPageContact->fullRead("SELECT id, title_opening_hours, opening_hours, title_address, address, address_two, phone
                FROM sts_contacts
                LIMIT :limit", "limit=1");

        $this->resultadoBd = $viewPageContact->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo da página contato não encontrado!</div>";
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

        $upPageContact = new \App\adms\Models\helper\AdmsUpdate();
        $upPageContact->exeUpdate("sts_contacts", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upPageContact->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Conteúdo da página contato editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Conteúdo da página contato não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
