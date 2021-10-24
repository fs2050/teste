<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditHomeDet
 *
 * @author Celke
 */
class EditHomeDet
{
    
    private $dados;
    private $dadosForm;

    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (empty($this->dadosForm['EditHomeDet'])) {
            $viewHomeDet = new \App\sts\Models\StsEditHomeDet();
            $viewHomeDet->viewHomeDet();
            if ($viewHomeDet->getResultado()) {
                $this->dados['form'] = $viewHomeDet->getResultadoBd();
                $this->viewEditHomeDet();
            } else {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editHomeDet();
        }
    }

    private function viewEditHomeDet() {
        $button = ['view_page_home' => ['menu_controller' => 'view-page-home', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-page-home";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/home/editHomeDet", $this->dados);
        $carregarView->renderAdmSite();
    }

    private function editHomeDet() {
        if (!empty($this->dadosForm['EditHomeDet'])) {
            unset($this->dadosForm['EditHomeDet']);
            $editHomeDet = new \App\sts\Models\StsEditHomeDet();
            $editHomeDet->update($this->dadosForm);
            if ($editHomeDet->getResultado()) {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditHomeDet();
            }
        } else {
            $_SESSION['msg'] = "Conteúdo dos detalhes da página home não encontrado!<br>";
            $urlDestino = URLADM . "view-page-home/index";
            header("Location: $urlDestino");
        }
    }

}
