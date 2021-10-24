<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditConfEmailsPass recebe as informações que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditConfEmailsPass
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var int $id Contem a Id da senha de configuração de e-mail que será editada no sistema */
    private int $id;
    
    /** @var array $dados Recebe as informações que serão editadas */
    private array $dados;
    
    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    /** @return Retorna o resultado do banco de dados*/
    function getResultadoBd() {
        return $this->resultadoBd;
    }

    /**
     * Método para fazer busca do Id na tabela adms_confs_emails e validar o mesmo
     * @param array $id Recebe a informação que será validada e editada no banco de dados */
    public function viewConfEmailsPass($id) {
        $this->id = (int) $id;
        $viewConfEmailsPass = new \App\adms\Models\helper\AdmsRead();
        $viewConfEmailsPass->fullRead("SELECT id
                FROM adms_confs_emails
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewConfEmailsPass->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não encontrado!</div>";
            $this->resultado = false;
        }
    }

    /**
     * Método para validar os dados antes que a edição seja feita
     * @param array $dados Recebe a informação que será validada*/
    public function update(array $dados) {
        $this->dados = $dados;
        //var_dump($this->dados);

        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->edit();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para fazer a atualização das informações no banco de dados
     */
    private function edit() {
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upConfEmailsPass = new \App\adms\Models\helper\AdmsUpdate();
        $upConfEmailsPass->exeUpdate("adms_confs_emails", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upConfEmailsPass->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Senha do e-mail editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Senha do e-mail não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
