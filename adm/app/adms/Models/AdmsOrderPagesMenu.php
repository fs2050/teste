<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsOrderPagesMenu 
 *
 * @author robson
 */
class AdmsOrderPagesMenu {

    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;

    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;

    /** @var int $id Recebe o Id da ordem do grupo de página */
    private int $id;

    /** @var array $data Recebe as informações que serão salvas no banco de dados */
    private array $data;

    /** @var $resultDbPrev Recebe a informação sobre a ultima ordem */
    private $resultDbPrev;

    /** @return Retorna o resultado que retornou do banco de dados */
    function getResultDb() {
        return $this->resultDb;
    }

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }

    public function orderPagesMenu($id = null) {
        $this->id = (int) $id;
        $viewOrderPagesMenu = new \App\adms\Models\helper\AdmsRead();
        $viewOrderPagesMenu->fullRead("SELECT lev_pag.id, lev_pag.order_level_page, lev_pag.adms_access_level_id 
                    FROM adms_levels_pages lev_pag
                    INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id
                    WHERE lev_pag.id=:id
                    AND lev.order_levels >=:order_levels
                    LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");
        $this->resultDb = $viewOrderPagesMenu->getResult();
        if ($this->resultDb) {
            //var_dump($this->resultDb);
            $this->viewPrevPageMenu();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não encontrada!</div>";
            $this->result = false;
        }
    }

    private function viewPrevPageMenu() {
        $prevPageMenu = new \App\adms\Models\helper\AdmsRead();
        $prevPageMenu->fullRead("SELECT id, order_level_page
                    FROM adms_levels_pages
                    WHERE (order_level_page <:order_level_page
                    AND adms_access_level_id =:adms_access_level_id) 
                    AND permission = 1
                    ORDER BY order_level_page DESC
                    LIMIT :limit", "order_level_page={$this->resultDb[0]['order_level_page']}&adms_access_level_id={$this->resultDb[0]['adms_access_level_id']}&limit=1");
        $this->resultDbPrev = $prevPageMenu->getResult();
        if ($this->resultDbPrev) {
            //var_dump($this->resultDbPrev);
            $this->editMoveDown();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem do grupo de página não encontrado!</div>";
            $this->result = false;
        }
    }
    
    private function editMoveDown() {
        $this->data['order_level_page'] = $this->resultDb[0]['order_level_page'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->resultDbPrev[0]['id']}");

        if ($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem da página não editada com sucesso!</div>";
            $this->result = false;
        }
    }
    
    private function editMoveUp() {
        $this->data['order_level_page'] = $this->resultDbPrev[0]['order_level_page'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->resultDb[0]['id']}");

        if ($moveDown->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Ordem da página editada com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem da página não editada com sucesso!</div>";
            $this->result = false;
        }
    }

}
