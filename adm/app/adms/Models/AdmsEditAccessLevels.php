<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditAccessLevels recebe as informações que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditAccessLevels
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var int $id Contem a Id do nível de acesso que será editado do sistema */
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
     * Método para fazer busca do Id na tabela adms_access_levels e validar o mesmo
     * @param array $id Recebe a informação que será validada e editada no banco de dados */
    public function viewAccessLevels($id) {
        $this->id = (int) $id;
        $viewAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $viewAccessLevels->fullRead("SELECT id, name, order_levels
                FROM adms_access_levels
                WHERE id=:id 
                AND order_levels >:order_levels
                LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultadoBd = $viewAccessLevels->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso não encontrado ou não tem permissão de acessar!</div>";
            $this->resultado = false;
        }
    }
    
    /**
     * Método para validar os dados antes que a edição seja feita
     * @param array $dados Recebe a informação que será validada*/
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
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para fazer a atualização das informações no banco de dados
     */
    private function edit() {
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upAccessLevel = new \App\adms\Models\helper\AdmsUpdate();
        $upAccessLevel->exeUpdate("adms_access_levels", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upAccessLevel->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Nível de acesso editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
