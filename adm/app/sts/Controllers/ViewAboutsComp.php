<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewAboutsComp
 *
 * @author Celke
 */
class ViewAboutsComp
{
    
    private int $id;
    private $dados;

    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewAboutsComp = new \App\sts\Models\StsViewAboutsComp();
            $viewAboutsComp->viewAboutsComp($this->id);
            if ($viewAboutsComp->getResultado()) {
                $this->dados['viewAboutsComp'] = $viewAboutsComp->getResultadoBd();
                $this->viewAboutsComp();
            } else {
                $urlDestino = URLADM . "list-abouts-comp/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não encontrado</div>";
            $urlDestino = URLADM . "list-users/index";
            header("Location: $urlDestino");
        }
    }

    private function viewAboutsComp() {
        $button = ['list_abouts_comp' => ['menu_controller' => 'list-abouts-comp', 'menu_metodo' => 'index'],
            'edit_abouts_comp' => ['menu_controller' => 'edit-abouts-comp', 'menu_metodo' => 'index'],
            'delete_abouts_comp' => ['menu_controller' => 'delete-abouts-comp', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-abouts-comp";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/aboutsComp/viewAboutsComp", $this->dados);
        $carregarView->renderAdmSite();
    }

}
