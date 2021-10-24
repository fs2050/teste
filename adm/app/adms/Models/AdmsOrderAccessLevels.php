<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe OrderAccessLevels Recebe as informações para listar a ordem do nível de acesso
 *
 * @author Celke
 */
class AdmsOrderAccessLevels
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var int $id Recebe o Id da ordem de nível de acesso */
    private int $id;
    
    /** @var array $dados Recebe as informações que serão salvas no banco de dados */
    private array $dados;
    
    /** @var $resultadoBdPrev Recebe a informação sobre a ultima ordem do nivel de acesso cadastrada*/
    private $resultadoBdPrev;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    /** @return Retorna o resultado que retornou do banco de dados */
    function getResultadoBd() {
        return $this->resultadoBd;
    }

    /** Metodo verificar a ordem do nivel de acesso cadastrada no banco de dados na tabela adms_access_levels
     * 
     * @param array $id Recebe a Id da ordem do nivel de acesso
     */
    public function orderAccessLevels($id = null) {
        $this->id = (int) $id;
        $viewAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $viewAccessLevels->fullRead("SELECT id, order_levels
                FROM adms_access_levels
                WHERE id=:id 
                AND order_levels >:order_levels
                LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultadoBd = $viewAccessLevels->getResult();
        if ($this->resultadoBd) {
            $this->viewPrevAccessLevel();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso não encontrado!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para verificar a ordem do nivel de acesso maior e menor
     */
    private function viewPrevAccessLevel() {
        $prevAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $prevAccessLevels->fullRead("SELECT id, order_levels
                FROM adms_access_levels
                WHERE order_levels <:order_levels 
                AND order_levels >:order_levels_user
                ORDER BY order_levels DESC
                LIMIT :limit", "order_levels={$this->resultadoBd[0]['order_levels']}&order_levels_user=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultadoBdPrev = $prevAccessLevels->getResult();
        if ($this->resultadoBdPrev) {
            $this->editMoveDown();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso não encontrado!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para editar a ordem do nivel de acesso, movendo a ordem para baixo
     */
    private function editMoveDown() {
        $this->dados['order_levels'] = $this->resultadoBd[0]['order_levels'];
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_access_levels", $this->dados, "WHERE id=:id", "id={$this->resultadoBdPrev[0]['id']}");

        if ($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem do nível de acesso não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para editar a ordem do nivel de acesso, movendo a ordem para cima
     */
    private function editMoveUp() {
        $this->dados['order_levels'] = $this->resultadoBdPrev[0]['order_levels'];
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_access_levels", $this->dados, "WHERE id=:id", "id={$this->resultadoBd[0]['id']}");

        if ($moveDown->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Ordem do nível de acesso editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Ordem do nível de acesso não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
