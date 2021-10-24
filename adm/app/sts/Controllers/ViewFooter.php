<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewFooter
 *
 * @author Celke
 */
class ViewFooter {

    private $dados;

    public function index() {

        $viewFooter = new \App\sts\Models\StsViewFooter();
        $viewFooter->viewFooter();
        $this->dados['viewFooter'] = $viewFooter->getResultadoBd();
        
        $this->viewFooter();
        
    }

    private function viewFooter() {
        $button = ['edit_footer' => ['menu_controller' => 'edit-footer', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();

        $this->dados['sidebarActive'] = "view-footer";

        $carregarView = new \App\sts\core\ConfigView("sts/Views/footer/viewFooter", $this->dados);
        $carregarView->renderAdmSite();
    }

}
