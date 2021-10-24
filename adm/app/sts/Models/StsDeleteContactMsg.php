<?php

namespace App\sts\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsDeleteContactMsg
 *
 * @author Celke
 */
class StsDeleteContactMsg
{

    private bool $resultado;
    private int $id;
    private $resultadoBd;

    function getResultado(): bool {
        return $this->resultado;
    }

    public function deleteContactMsg($id) {
        $this->id = (int) $id;

        if ($this->viewContactMsg()) {
            $deleteContactMsg = new \App\adms\Models\helper\AdmsDelete();
            $deleteContactMsg->exeDelete("sts_contacts_msgs", "WHERE id =:id", "id={$this->id}");

            if ($deleteContactMsg->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Mensagem de contato apagada com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não apagada com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    private function viewContactMsg() {
        $viewContactMsg = new \App\adms\Models\helper\AdmsRead();
        $viewContactMsg->fullRead("SELECT id FROM sts_contacts_msgs
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewContactMsg->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não encontrada!</div>";
            return false;
        }
    }

}
