<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsOrderTypesPages Recebe as informações para listar a ordem do tipo de página
 *
 * @author robson
 */
class AdmsOrderTypesPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Recebe o Id da ordem do tipo de página */
    private int $id;
    
    /** @var array $data Recebe as informações que serão salvas no banco de dados */
    private array $data;
    
    /** @var $resultDbPrev Recebe a informação sobre a ultima ordem do tipo de página cadastrada*/
    private $resultDbPrev;

    /** @return Retorna o resultado que retornou do banco de dados */
    function getResultDb() {
        return $this->resultDb;
    }

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }

    /** Metodo verificar a ordem do tipo de página cadastrada no banco de dados na tabela adms_types_pgs
     * 
     * @param array $id Recebe a Id da ordem do tipo de página
     */
    public function orderTypesPages($id = null) {
        $this->id = (int) $id;
        $viewOrderTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewOrderTypesPages->fullRead("SELECT id, order_type_pg
                    FROM adms_types_pgs
                    WHERE id=:id
                    LIMIT :limit", "id={$this->id}&limit=1");
        $this->resultDb = $viewOrderTypesPages->getResult();
        if ($this->resultDb) {
            $this->viewPrevTypesPages();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem do tipo de página não encontrado!</div>";
            $this->result = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para verificar a ordem do tipo de página menor
     */
    private function viewPrevTypesPages() {
        $prevOrderTypesPages = new \App\adms\Models\helper\AdmsRead();
        $prevOrderTypesPages->fullRead("SELECT id, order_type_pg
                    FROM adms_types_pgs
                    WHERE order_type_pg <:order_type_pg
                    ORDER BY order_type_pg DESC
                    LIMIT :limit", "order_type_pg={$this->resultDb[0]['order_type_pg']}&limit=1");
        $this->resultDbPrev = $prevOrderTypesPages->getResult();
        if ($this->resultDbPrev) {
            $this->editMoveDown();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem do tipo de página não encontrado!</div>";
            $this->result = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para editar a ordem do tipo de página, movendo a ordem para baixo
     */
    private function editMoveDown() {
        $this->data['order_type_pg'] = $this->resultDb[0]['order_type_pg'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_types_pgs", $this->data, "WHERE id=:id", "id={$this->resultDbPrev[0]['id']}");

        if ($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem do tipo de página não editado com sucesso!</div>";
            $this->result = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para editar a ordem do tipo de página, movendo a ordem para cima
     */
    private function editMoveUp() {
        $this->data['order_type_pg'] = $this->resultDbPrev[0]['order_type_pg'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_types_pgs", $this->data, "WHERE id=:id", "id={$this->resultDb[0]['id']}");

        if ($moveDown->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Ordem do tipo de página editado com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem do tipo de página não editado com sucesso!</div>";
            $this->result = false;
        }
    }

}
