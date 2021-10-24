<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 *  * A classe AddAboutsComp
 *
 * @author Celke
 */
class AddAboutsComp {

    private $dados;
    private $dadosForm;

    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddAboutsComp'])) {
            unset($this->dadosForm['AddAboutsComp']);            
            $this->dadosForm['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            $addAboutsComp = new \App\sts\Models\StsAddAboutsComp();
            $addAboutsComp->create($this->dadosForm);
            if ($addAboutsComp->getResultado()) {
                $urlDestino = URLADM . "list-abouts-comp/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddAboutsComp();
            }
        } else {
            $this->viewAddAboutsComp();
        }
    }

    private function viewAddAboutsComp() {
        $button = ['list_abouts_comp' => ['menu_controller' => 'list-abouts-comp', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-abouts-comp";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/aboutsComp/addAboutsComp", $this->dados);
        $carregarView->renderAdmSite();
    }

}
