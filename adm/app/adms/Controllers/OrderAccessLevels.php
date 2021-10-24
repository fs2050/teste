<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe OrderAccessLevels Recebe as informações para listar a ordem do nível de acesso
 *
 * @author Celke
 */
class OrderAccessLevels
{
    /** @var $pag Recebe o número da página da ordem do nível de acesso */
    private $pag;
    
    /** @var $id Recebe Id da ordem de nível de acesso */
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;

        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        if (!empty($this->id) AND (!empty($this->pag))) {
            $orderAccessLevels = new \App\adms\Models\AdmsOrderAccessLevels();
            $orderAccessLevels->orderAccessLevels($this->id);
            $urlDestino = URLADM . 'list-access-levels/index/' . $this->pag;
            header("Location: $urlDestino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso encontrado!</div>";
            $urlDestino = URLADM . 'list-access-levels/index';
            header("Location: $urlDestino");
        }
    }

}
