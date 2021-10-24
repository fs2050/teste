<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditHomeDetImg 
 *
 * @author Celke
 */
class EditHomeDetImg
{
    private $dados;
    private $dadosForm;
    
    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['EditHomeDetImg'])) {
            $this->editHomeDetImg();
        } else {
            $viewHomeDetImg = new \App\sts\Models\StsEditHomeDetImg();
            $viewHomeDetImg->viewHomeDetImg();
            if ($viewHomeDetImg->getResultado()) {
                $this->dados['form'] = $viewHomeDetImg->getResultadoBd();
                $this->viewEditHomeDetImg();
            } else {
                $urlDestino = URLADM . "dashboard/index";
                header("Location: $urlDestino");
            }
        }
    }
    
    private function viewEditHomeDetImg() {
        $button = ['view_page_home' => ['menu_controller' => 'view-page-home', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-page-home";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/home/editHomeDetImg", $this->dados);
        $carregarView->renderAdmSite();
    }
    
    private function editHomeDetImg() {
        if (!empty($this->dadosForm['EditHomeDetImg'])) {
            unset($this->dadosForm['EditHomeDetImg']);
            $this->dadosForm['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            $editHomeDetImg = new \App\sts\Models\StsEditHomeDetImg();
            $editHomeDetImg->update($this->dadosForm);
            if ($editHomeDetImg->getResultado()) {
                $urlDestino = URLADM . "view-page-home/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditHomeDetImg();
            }
        } else {
            $_SESSION['msg'] = "Imagem dos detalhes da página home não encontrado!<br>";
            $urlDestino = URLADM . "dashboard/index";
            header("Location: $urlDestino");
        }
    }

}
