<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditPageFooter
 *
 * @author Celke
 */
class EditFooter
{
    
    private $dados;
    private $dadosForm;

    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (empty($this->dadosForm['EditFooter'])) {
            $viewFooter = new \App\sts\Models\StsEditFooter();
            $viewFooter->viewFooter();
            if ($viewFooter->getResultado()) {
                $this->dados['form'] = $viewFooter->getResultadoBd();
                $this->viewEditFooter();
            } else {
                $urlDestino = URLADM . "view-footer/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editFooter();
        }
    }

    private function viewEditFooter() {
        $button = ['view_footer' => ['menu_controller' => 'view-footer', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-footer";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/footer/editFooter", $this->dados);
        $carregarView->renderAdmSite();
    }

    private function editFooter() {
        if (!empty($this->dadosForm['EditFooter'])) {
            unset($this->dadosForm['EditFooter']);
            $editFooter = new \App\sts\Models\StsEditFooter();
            $editFooter->update($this->dadosForm);
            if ($editFooter->getResultado()) {
                $urlDestino = URLADM . "view-footer/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditFooter();
            }
        } else {
            $_SESSION['msg'] = "Conteúdo do rodapé não encontrado!<br>";
            $urlDestino = URLADM . "view-footer/index";
            header("Location: $urlDestino");
        }
    }

}
