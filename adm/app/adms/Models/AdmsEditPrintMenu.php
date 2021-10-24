<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditPrintMenu 
 *
 * @author Celke
 */
class AdmsEditPrintMenu
{
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var $id Recebe a ID do nível de acesso que será editado */
    private $id;
    
    /** @var $dados Recebe os dados do nível de acesso que será editado */
    private $dados;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    public function editPrintMenu($id = null) {

        $this->id = (int) $id;
        $viewPrintMenu = new \App\adms\Models\helper\AdmsRead();
        $viewPrintMenu->fullRead("SELECT lev_pag.id, lev_pag.print_menu
                        FROM adms_levels_pages lev_pag
                        INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id
                        WHERE lev_pag.id =:id
                        AND lev.order_levels >=:order_levels
                        LIMIT :limit",
                "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");
        $this->resultadoBd = $viewPrintMenu->getResult();

        if ($this->resultadoBd) {
            $this->edit();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Registro não encontrado!</div>";
            $this->resultado = false;
        }
    }

    private function edit() {
        if ($this->resultadoBd[0]['print_menu'] == 1) {
            $this->dados['print_menu'] = 2;
        } else {
            $this->dados['print_menu'] = 1;
        }
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upPrintMenu = new \App\adms\Models\helper\AdmsUpdate();
        $upPrintMenu->exeUpdate("adms_levels_pages", $this->dados, "WHERE id=:id", "id={$this->id}");
        if ($upPrintMenu->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Apresentar ou ocultar item de menu editado com sucesso!</div>";
            $this->resultado = false;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Apresentar ou ocultar item de menu não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
