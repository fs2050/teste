<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditPageContact
 *
 * @author Celke
 */
class EditPageContact
{
    
    private $dados;
    private $dadosForm;

    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (empty($this->dadosForm['EditPageContact'])) {
            $viewPageContact = new \App\sts\Models\StsEditPageContact();
            $viewPageContact->viewPageContact();
            if ($viewPageContact->getResultado()) {
                $this->dados['form'] = $viewPageContact->getResultadoBd();
                $this->viewEditPageContact();
            } else {
                $urlDestino = URLADM . "view-page-contact/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editPageContact();
        }
    }

    private function viewEditPageContact() {
        $button = ['view_page_contact' => ['menu_controller' => 'view-page-contact', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-page-contact";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/contact/editPageContact", $this->dados);
        $carregarView->renderAdmSite();
    }

    private function editPageContact() {
        if (!empty($this->dadosForm['EditPageContact'])) {
            unset($this->dadosForm['EditPageContact']);
            $editPageContact = new \App\sts\Models\StsEditPageContact();
            $editPageContact->update($this->dadosForm);
            if ($editPageContact->getResultado()) {
                $urlDestino = URLADM . "view-page-contact/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditPageContact();
            }
        } else {
            $_SESSION['msg'] = "Conteúdo da página contato não encontrado!<br>";
            $urlDestino = URLADM . "view-page-contact/index";
            header("Location: $urlDestino");
        }
    }

}
