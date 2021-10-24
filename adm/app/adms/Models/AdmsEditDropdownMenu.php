<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditDropdownMenu 
 *
 * @author Celke
 */
class AdmsEditDropdownMenu
{
    
    private bool $resultado;    
    private $resultadoBd;    
    private $id;
    private $dados;

    function getResultado(): bool {
        return $this->resultado;
    }

    public function editDropdownMenu($id = null) {

        $this->id = (int) $id;
        $viewDropdownMenu = new \App\adms\Models\helper\AdmsRead();
        $viewDropdownMenu->fullRead("SELECT lev_pag.id, lev_pag.dropdown
                        FROM adms_levels_pages lev_pag
                        INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id
                        WHERE lev_pag.id =:id
                        AND lev.order_levels >=:order_levels
                        LIMIT :limit",
                "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");
        $this->resultadoBd = $viewDropdownMenu->getResult();

        if ($this->resultadoBd) {
            $this->edit();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Registro não encontrado!</div>";
            $this->resultado = false;
        }
    }

    private function edit() {
        if ($this->resultadoBd[0]['dropdown'] == 1) {
            $this->dados['dropdown'] = 2;
        } else {
            $this->dados['dropdown'] = 1;
        }
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upDropdownMenu = new \App\adms\Models\helper\AdmsUpdate();
        $upDropdownMenu->exeUpdate("adms_levels_pages", $this->dados, "WHERE id=:id", "id={$this->id}");
        if ($upDropdownMenu->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Item de menu dropdown editado com sucesso!</div>";
            $this->resultado = false;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu dropdown não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
