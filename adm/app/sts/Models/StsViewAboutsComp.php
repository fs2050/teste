<?php

namespace App\sts\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsViewAboutsComp
 *
 * @author Celke
 */
class StsViewAboutsComp
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

    public function viewAboutsComp($id) {
        $this->id = (int) $id;
        $viewAboutsComp = new \App\adms\Models\helper\AdmsRead();
        $viewAboutsComp->fullRead("SELECT comp.id, comp.title, comp.description, comp.image, comp.sts_situation_id, comp.created, comp.modified
                FROM sts_abouts_companies comp
                WHERE comp.id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewAboutsComp->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não encontrado</div>";
            $this->resultado = false;
        }
    }

}
