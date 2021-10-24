<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListAboutsComp
 *
 * @author Celke
 */
class ListAboutsComp
{
    private $dados;
    private $pag;
    
    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listAboutsComp = new \App\sts\Models\StsListAboutsComp();
        $listAboutsComp->listAboutsComp($this->pag);
        if ($listAboutsComp->getResultado()) {
            $this->dados['listAboutsComp'] = $listAboutsComp->getResultadoBd();
            $this->dados['pagination'] = $listAboutsComp->getResultPg();
            $this->dados['pag'] = $this->pag;
        } else {
            $this->dados['listAboutsComp'] = [];
            $this->dados['pagination'] = null;
            $this->dados['pag'] = $this->pag;
        }

        $button = ['add_abouts_comp' => ['menu_controller' => 'add-abouts-comp', 'menu_metodo' => 'index'],
            'view_abouts_comp' => ['menu_controller' => 'view-abouts-comp', 'menu_metodo' => 'index'],
            'edit_abouts_comp' => ['menu_controller' => 'edit-abouts-comp', 'menu_metodo' => 'index'],
            'edit_abouts_comp_sit' => ['menu_controller' => 'edit-abouts-comp-sit', 'menu_metodo' => 'index'],
            'delete_abouts_comp' => ['menu_controller' => 'delete-abouts-comp', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-abouts-comp";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/aboutsComp/listAboutsComp", $this->dados);
        $carregarView->renderAdmSite();
    }

}
