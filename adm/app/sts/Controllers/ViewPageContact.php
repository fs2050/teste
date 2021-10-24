<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewPageContact
 *
 * @author Celke
 */
class ViewPageContact {

    private $dados;

    public function index() {
        //echo "Acessou a página home do site<br>";

        $viewPageContact = new \App\sts\Models\StsViewPageContact();
        $viewPageContact->viewPageContact();
        $this->dados['viewPageContact'] = $viewPageContact->getResultadoBd();
        
        $this->viewPageContact();
        
    }

    private function viewPageContact() {
        $button = ['edit_page_contact' => ['menu_controller' => 'edit-page-contact', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();

        $this->dados['sidebarActive'] = "view-page-contact";

        $carregarView = new \App\sts\core\ConfigView("sts/Views/contact/viewPageContact", $this->dados);
        $carregarView->renderAdmSite();
    }

}
