<?php

namespace App\sts\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsDeleteAboutsComp
 *
 * @author Celke
 */
class StsDeleteAboutsComp
{

    private bool $resultado;
    private int $id;
    private $resultadoBd;

    function getResultado(): bool {
        return $this->resultado;
    }

    public function deleteAboutsComp($id) {
        $this->id = (int) $id;

        if ($this->viewAboutsComp()) {
            $deleteAboutsComp = new \App\adms\Models\helper\AdmsDelete();
            $deleteAboutsComp->exeDelete("sts_abouts_companies", "WHERE id =:id", "id={$this->id}");

            if ($deleteAboutsComp->getResult()) {
                $this->deleteImg();
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Sobre empresa apagado com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não apagado com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    private function viewAboutsComp() {
        $viewAboutsComp = new \App\adms\Models\helper\AdmsRead();
        $viewAboutsComp->fullRead("SELECT id, image FROM sts_abouts_companies
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewAboutsComp->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não encontrado!</div>";
            return false;
        }
    }
    
    private function deleteImg() {
        if ((!empty($this->resultadoBd[0]['image'])) OR ($this->resultadoBd[0]['image'] != null)) {
            $this->delDiretorio = "app/sts/assets/image/about_company/" . $this->resultadoBd[0]['id'];
            $this->delImg = $this->delDiretorio . "/" . $this->resultadoBd[0]['image'];

            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }

            if (file_exists($this->delDiretorio)) {
                rmdir($this->delDiretorio);
            }
        }
    }

}
