<?php

namespace App\sts\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsViewContactMsg
 *
 * @author Celke
 */
class StsViewContactMsg
{
    private $resultadoBd;
    private bool $resultado;
    private int $id;

    function getResultado(): bool {
        return $this->resultado;
    }

    function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function viewContactMsg($id) {
        $this->id = (int) $id;
        $viewContactMsg = new \App\adms\Models\helper\AdmsRead();
        $viewContactMsg->fullRead("SELECT id, name, email, subject, content, created, modified
                FROM sts_contacts_msgs
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewContactMsg->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não encontrada</div>";
            $this->resultado = false;
        }
    }

}
