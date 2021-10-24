<?php

namespace App\sts\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditAboutsCompImage
 *
 * @author Celke
 */
class EditAboutsCompImage
{
    private $dados;
    private $dadosForm;
    private $id;

    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditAboutsCompImage']))) {
            $viewAboutsComp = new \App\sts\Models\StsEditAboutsCompImage();
            $viewAboutsComp->viewAboutsComp($this->id);
            if ($viewAboutsComp->getResultado()) {
                $this->dados['form'] = $viewAboutsComp->getResultadoBd();
                $this->viewEditAboutsCompImage();
            } else {
                $urlDestino = URLADM . "list-abouts-comp/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editAboutsComp();
        }
    }
    private function viewEditAboutsCompImage() {
        $button = ['list_abouts_comp' => ['menu_controller' => 'list-abouts-comp', 'menu_metodo' => 'index'],
            'view_abouts_comp' => ['menu_controller' => 'view-abouts-comp', 'menu_metodo' => 'index'],
            'edit_abouts_comp' => ['menu_controller' => 'edit-abouts-comp', 'menu_metodo' => 'index'],
            'delete_abouts_comp' => ['menu_controller' => 'delete-abouts-comp', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-abouts-comp";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/aboutsComp/editAboutsCompImage", $this->dados);
        $carregarView->renderAdmSite();
    }

    private function editAboutsComp() {
        if (!empty($this->dadosForm['EditAboutsCompImage'])) {
            unset($this->dadosForm['EditAboutsCompImage']);
            $this->dadosForm['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            //var_dump($this->dadosForm);
            $editAboutsComp = new \App\sts\Models\StsEditAboutsCompImage();
            $editAboutsComp->update($this->dadosForm);
            if ($editAboutsComp->getResultado()) {
                $urlDestino = URLADM . "view-abouts-comp/index/" . $this->dadosForm['id'];
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditAboutsCompImage();
            }
        } else {
            $_SESSION['msg'] = "Sobre empresa não encontrado!<br>";
            $urlDestino = URLADM . "list-abouts-comp/index";
            header("Location: $urlDestino");
        }
    }

}
