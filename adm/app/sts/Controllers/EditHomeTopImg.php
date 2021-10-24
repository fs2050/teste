<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditHomeTopImg 
 *
 * @author Celke
 */
class EditHomeTopImg
{
    private $dados;
    private $dadosForm;
    
    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['EditHomeTopImg'])) {
            $this->editHomeTopImg();
        } else {
            $viewHomeTopImg = new \App\sts\Models\StsEditHomeTopImg();
            $viewHomeTopImg->viewHomeTopImg();
            if ($viewHomeTopImg->getResultado()) {
                $this->dados['form'] = $viewHomeTopImg->getResultadoBd();
                $this->viewEditHomeTopImg();
            } else {
                $urlDestino = URLADM . "dashboard/index";
                header("Location: $urlDestino");
            }
        }
    }
    
    private function viewEditHomeTopImg() {
        $button = ['view_page_home' => ['menu_controller' => 'view-page-home', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-page-home";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/home/editHomeTopImg", $this->dados);
        $carregarView->renderAdmSite();
    }
    
    private function editHomeTopImg() {
        if (!empty($this->dadosForm['EditHomeTopImg'])) {
            unset($this->dadosForm['EditHomeTopImg']);
            $this->dadosForm['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            $editHomeTopImg = new \App\sts\Models\StsEditHomeTopImg();
            $editHomeTopImg->update($this->dadosForm);
            if ($editHomeTopImg->getResultado()) {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditHomeTopImg();
            }
        } else {
            $_SESSION['msg'] = "Imagem do topo da página home não encontrado!<br>";
            $urlDestino = URLADM . "dashboard/index";
            header("Location: $urlDestino");
        }
    }

}
