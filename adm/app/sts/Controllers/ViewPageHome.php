<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewPageHome
 *
 * @author Celke
 */
class ViewPageHome {

    private $dados;

    public function index() {
        //echo "Acessou a página home do site<br>";

        $viewHome = new \App\sts\Models\StsViewHome();
        $viewHome->viewHomeTop();
        $this->dados['viewHomeTop'] = $viewHome->getResultadoBdTop();
        
        $viewHome->viewHomeServ();
        $this->dados['viewHomeServ'] = $viewHome->getResultadoBdServ();
        
        $viewHome->viewHomeAction();
        $this->dados['viewHomeAction'] = $viewHome->getResultadoBdAction();
        
        $viewHome->viewHomeDet();
        $this->dados['viewHomeDet'] = $viewHome->getResultadoBdDet();
        
        $this->viewHome();
        
    }

    private function viewHome() {
        $button = ['edit_home_top' => ['menu_controller' => 'edit-home-top', 'menu_metodo' => 'index'],
            'edit_home_serv' => ['menu_controller' => 'edit-home-serv', 'menu_metodo' => 'index'],
            'edit_home_action' => ['menu_controller' => 'edit-home-action', 'menu_metodo' => 'index'],
            'edit_home_det' => ['menu_controller' => 'edit-home-det', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();

        $this->dados['sidebarActive'] = "view-page-home";

        $carregarView = new \App\sts\core\ConfigView("sts/Views/home/viewHome", $this->dados);
        $carregarView->renderAdmSite();
    }

}
