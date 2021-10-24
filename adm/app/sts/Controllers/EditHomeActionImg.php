<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditHomeActionImg 
 *
 * @author Celke
 */
class EditHomeActionImg
{
    private $dados;
    private $dadosForm;
    
    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['EditHomeActionImg'])) {
            $this->editHomeActionImg();
        } else {
            $viewHomeActionImg = new \App\sts\Models\StsEditHomeActionImg();
            $viewHomeActionImg->viewHomeActionImg();
            if ($viewHomeActionImg->getResultado()) {
                $this->dados['form'] = $viewHomeActionImg->getResultadoBd();
                $this->viewEditHomeActionImg();
            } else {
                $urlDestino = URLADM . "dashboard/index";
                header("Location: $urlDestino");
            }
        }
    }
    
    private function viewEditHomeActionImg() {
        $button = ['view_page_home' => ['menu_controller' => 'view-page-home', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-page-home";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/home/editHomeActionImg", $this->dados);
        $carregarView->renderAdmSite();
    }
    
    private function editHomeActionImg() {
        if (!empty($this->dadosForm['EditHomeActionImg'])) {
            unset($this->dadosForm['EditHomeActionImg']);
            $this->dadosForm['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            $editHomeActionImg = new \App\sts\Models\StsEditHomeActionImg();
            $editHomeActionImg->update($this->dadosForm);
            if ($editHomeActionImg->getResultado()) {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditHomeActionImg();
            }
        } else {
            $_SESSION['msg'] = "Imagem da ação da página home não encontrado!<br>";
            $urlDestino = URLADM . "dashboard/index";
            header("Location: $urlDestino");
        }
    }

}
