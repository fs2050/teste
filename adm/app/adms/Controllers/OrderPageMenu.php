<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe OrderPageMenu
 *
 * @author Celke
 */
class OrderPageMenu
{
    /** @var int $id Recebe a Id do nível de acesso */
    private int $id;
    
    /** @var int $level Recebe o nível de acesso */
    private int $level;
    
    /** @var int $pag Recebe o número da página, usado na páginação */
    private int $pag;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        $this->level = filter_input(INPUT_GET, "level", FILTER_SANITIZE_NUMBER_INT);
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        
        $editOrderPagesMenu = new \App\adms\Models\AdmsOrderPagesMenu();
        $editOrderPagesMenu->orderPagesMenu($this->id);

        $urlDestino = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
        header("Location: $urlDestino");
    }

}
