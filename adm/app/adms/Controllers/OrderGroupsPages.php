<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe OrderGroupsPages Recebe as informações para listar a ordem do grupo de página
 *
 * @author robson
 */
class OrderGroupsPages
{
    /** @var $pag Recebe o número da página da ordem do grupo de página */
    private $pag;
    
    /** @var $id Recebe Id da ordem de nível de acesso */
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->id) AND (!empty($this->pag))) {
            $orderGroupsPages = new \App\adms\Models\AdmsOrderGroupsPages();
            $orderGroupsPages->orderGroupsPages($this->id);
            $urlRedirect = URLADM . 'list-groups-pages/index/' . $this->pag;
            header("Location: $urlRedirect");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Grupo de página não encontrado!</div>";
            $urlRedirect = URLADM . 'list-groups-pages/index';
            header("Location: $urlRedirect");
        }
    }

}
