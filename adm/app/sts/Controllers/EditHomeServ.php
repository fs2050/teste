<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditHomeServ
 *
 * @author Celke
 */
class EditHomeServ
{
    
    private $dados;
    private $dadosForm;

    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (empty($this->dadosForm['EditHomeServ'])) {
            $viewHomeServ = new \App\sts\Models\StsEditHomeServ();
            $viewHomeServ->viewHomeServ();
            if ($viewHomeServ->getResultado()) {
                $this->dados['form'] = $viewHomeServ->getResultadoBd();
                $this->viewEditHomeServ();
            } else {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editHomeServ();
        }
    }

    private function viewEditHomeServ() {
        $button = ['view_page_home' => ['menu_controller' => 'view-page-home', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-page-home";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/home/editHomeServ", $this->dados);
        $carregarView->renderAdmSite();
    }

    private function editHomeServ() {
        if (!empty($this->dadosForm['EditHomeServ'])) {
            unset($this->dadosForm['EditHomeServ']);
            $editHomeServ = new \App\sts\Models\StsEditHomeServ();
            $editHomeServ->update($this->dadosForm);
            if ($editHomeServ->getResultado()) {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditHomeServ();
            }
        } else {
            $_SESSION['msg'] = "Conteúdo do serviço da página home não encontrado!<br>";
            $urlDestino = URLADM . "view-page-home/index";
            header("Location: $urlDestino");
        }
    }

}
