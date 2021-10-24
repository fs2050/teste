<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsDeleteAccessLevels recebe a informação que será deletada do banco de dados
 *
 * @author Celke
 */
class AdmsDeleteAccessLevels
{

    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;

    /** @var int $id Contem a Id do nível de acesso que será deletado do sistema */
    private int $id;

    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Método para fazer busca do Id no banco de dados na tabela nível de acessp e validar o mesmo
     * @param array $id Recebe a informação que será validada e deletada do banco de dados */
    public function deleteAccessLevels($id) {
        $this->id = (int) $id;

        if ($this->viewAccessLevels() AND $this->verUserCad()) {
            $deleteAccessLevels = new \App\adms\Models\helper\AdmsDelete();
            $deleteAccessLevels->exeDelete("adms_access_levels", "WHERE id =:id", "id={$this->id}");

            if ($deleteAccessLevels->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Nível de acesso apagado com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso não apagado com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para validar se o usuário tem permissão ou não de deletar o nível de acesso
     */
    private function viewAccessLevels() {
        $viewAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $viewAccessLevels->fullRead("SELECT id FROM adms_access_levels
                WHERE id=:id
                AND order_levels >:order_levels 
                LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultadoBd = $viewAccessLevels->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso não encontrado ou não tem permissão de acessar!</div>";
            return false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se tem usuários cadastrados no nível de acesso a ser deletado, caso tenha a exclusão não é permitida
     */
    private function verUserCad() {
        $viewUserCad = new \App\adms\Models\helper\AdmsRead();
        $viewUserCad->fullRead("SELECT id FROM adms_users WHERE adms_access_level_id=:adms_access_level_id LIMIT :limit", "adms_access_level_id={$this->id}&limit=1");
        if ($viewUserCad->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: O nível de acesso não pode ser apagado, há usuários  cadastrado com esse nível de acesso!</div>";
            return false;
        } else {
            return true;
        }
    }

}
