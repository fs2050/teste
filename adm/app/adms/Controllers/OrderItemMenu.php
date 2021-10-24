<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe OrderItemMenu
 *
 * @author Celke
 */
class OrderItemMenu
{
    
    private $pag;
    private $id;

    public function index($id = null) {
        $this->id = (int) $id;
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->id) AND (!empty($this->pag))) {
            $orderItemMenu = new \App\adms\Models\AdmsOrderItemMenu();
            $orderItemMenu->orderItemMenu($this->id);
            $urlRedirect = URLADM . 'list-item-menu/index/' . $this->pag;
            header("Location: $urlRedirect");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não encontrado!</div>";
            $urlRedirect = URLADM . 'list-item-menu/index';
            header("Location: $urlRedirect");
        }
    }

}
