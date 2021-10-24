<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditHomeTop
 *
 * @author Celke
 */
class EditHomeTop
{
    
    private $dados;
    private $dadosForm;

    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (empty($this->dadosForm['EditHomeTop'])) {
            $viewHomeTop = new \App\sts\Models\StsEditHomeTop();
            $viewHomeTop->viewHomeTop();
            if ($viewHomeTop->getResultado()) {
                $this->dados['form'] = $viewHomeTop->getResultadoBd();
                $this->viewEditHomeTop();
            } else {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editHomeTop();
        }
    }

    private function viewEditHomeTop() {
        $button = ['view_page_home' => ['menu_controller' => 'view-page-home', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-page-home";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/home/editHomeTop", $this->dados);
        $carregarView->renderAdmSite();
    }

    private function editHomeTop() {
        if (!empty($this->dadosForm['EditHomeTop'])) {
            unset($this->dadosForm['EditHomeTop']);
            $editHomeTop = new \App\sts\Models\StsEditHomeTop();
            $editHomeTop->update($this->dadosForm);
            if ($editHomeTop->getResultado()) {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditHomeTop();
            }
        } else {
            $_SESSION['msg'] = "Conteúdo do topo da página home não encontrado!<br>";
            $urlDestino = URLADM . "view-page-home/index";
            header("Location: $urlDestino");
        }
    }

}
