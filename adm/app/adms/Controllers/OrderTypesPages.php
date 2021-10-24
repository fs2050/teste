<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe OrderTypesPages Recebe as informações para listar a ordem do tipo de página
 *
 * @author robson
 */
class OrderTypesPages
{
    /** @var $pag Recebe o número da página da ordem do tipo de página */
    private $pag;
    
    /** @var $id Recebe Id da ordem do tipo de página */
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id = null) {
        $this->id = (int) $id;
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);
        if (!empty($this->id) AND (!empty($this->pag))) {
            $orderTypesPages = new \App\adms\Models\AdmsOrderTypesPages();
            $orderTypesPages->orderTypesPages($this->id);
            $urlRedirect = URLADM . 'list-types-pages/index/' . $this->pag;
            header("Location: $urlRedirect");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não encontrado!</div>";
            $urlRedirect = URLADM . 'list-types-pages/index';
            header("Location: $urlRedirect");
        }
    }

}
