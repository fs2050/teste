<?php

namespace App\sts\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditAboutsCompSit 
 *
 * @author Celke
 */
class StsEditAboutsCompSit
{
    private bool $resultado;
    private $resultadoBd;
    private $id;
    private $dados;

    function getResultado(): bool {
        return $this->resultado;
    }

    public function editAboutsCompSit($id = null) {

        $this->id = (int) $id;
        $viewAboutsCompSit = new \App\adms\Models\helper\AdmsRead();
        $viewAboutsCompSit->fullRead("SELECT id, sts_situation_id
                        FROM sts_abouts_companies
                        WHERE id =:id
                        LIMIT :limit",
                "id={$this->id}&limit=1");
        $this->resultadoBd = $viewAboutsCompSit->getResult();

        if ($this->resultadoBd) {
            $this->edit();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Registro não encontrado!</div>";
            $this->resultado = false;
        }
    }

    private function edit() {
        if ($this->resultadoBd[0]['sts_situation_id'] == 1) {
            $this->dados['sts_situation_id'] = 2;
        } else {
            $this->dados['sts_situation_id'] = 1;
        }
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upAboutsCompSit = new \App\adms\Models\helper\AdmsUpdate();
        $upAboutsCompSit->exeUpdate("sts_abouts_companies", $this->dados, "WHERE id=:id", "id={$this->id}");
        if ($upAboutsCompSit->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação sobre empresa editado com sucesso!</div>";
            $this->resultado = false;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação sobre empresa não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
