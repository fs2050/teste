<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditHomeAction
 *
 * @author Celke
 */
class EditHomeAction
{
    
    private $dados;
    private $dadosForm;

    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (empty($this->dadosForm['EditHomeAction'])) {
            $viewHomeAction = new \App\sts\Models\StsEditHomeAction();
            $viewHomeAction->viewHomeAction();
            if ($viewHomeAction->getResultado()) {
                $this->dados['form'] = $viewHomeAction->getResultadoBd();
                $this->viewEditHomeAction();
            } else {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editHomeAction();
        }
    }

    private function viewEditHomeAction() {
        $button = ['view_page_home' => ['menu_controller' => 'view-page-home', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-page-home";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/home/editHomeAction", $this->dados);
        $carregarView->renderAdmSite();
    }

    private function editHomeAction() {
        if (!empty($this->dadosForm['EditHomeAction'])) {
            unset($this->dadosForm['EditHomeAction']);
            $editHomeAction = new \App\sts\Models\StsEditHomeAction();
            $editHomeAction->update($this->dadosForm);
            if ($editHomeAction->getResultado()) {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditHomeAction();
            }
        } else {
            $_SESSION['msg'] = "Conteúdo da ação da página home não encontrado!<br>";
            $urlDestino = URLADM . "view-page-home/index";
            header("Location: $urlDestino");
        }
    }

}
