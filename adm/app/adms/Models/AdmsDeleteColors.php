<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsDeleteColors recebe a informação que será deletada do banco de dados
 *
 * @author Celke
 */
class AdmsDeleteColors
{

    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;

    /** @var int $id Contem a Id da cor que será deletado do sistema */
    private int $id;

    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Método para fazer busca do Id no banco de dados na tabela cores e validar o mesmo
     * @param array $id Recebe a informação que será validada e deletada do banco de dados */
    public function deleteColors($id) {
        $this->id = (int) $id;

        if ($this->viewColors() AND $this->verSitUserCad()) {
            $deleteColors = new \App\adms\Models\helper\AdmsDelete();
            $deleteColors->exeDelete("adms_colors", "WHERE id =:id", "id={$this->id}");

            if ($deleteColors->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cor apagada com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não apagada com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se a cor está cadastrada no sistema, caso esteja o resultado é enviado para o metodo deleteColors
     */
    private function viewColors() {
        $viewColors = new \App\adms\Models\helper\AdmsRead();
        $viewColors->fullRead("SELECT id FROM adms_colors
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewColors->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
            return false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se tem alguma situação de usuário cadastrada usando a cor a ser deletada, se tiver, a exclusão não é permitida
     */
    private function verSitUserCad() {
        $viewSitUserCad = new \App\adms\Models\helper\AdmsRead();
        $viewSitUserCad->fullRead("SELECT id FROM adms_sits_users WHERE adms_color_id=:adms_color_id LIMIT :limit", "adms_color_id={$this->id}&limit=1");
        if ($viewSitUserCad->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: A cor não pode ser apagada, há situação de usuário cadastrado com essa cor!</div>";
            return false;
        } else {
            return true;
        }
    }

}
