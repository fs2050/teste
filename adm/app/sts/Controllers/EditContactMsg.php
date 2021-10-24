<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditContactMsg
 *
 * @author Celke
 */
class EditContactMsg
{
    private $dados;
    private $dadosForm;
    private $id;

    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditContactMsg']))) {
            $viewContactMsg = new \App\sts\Models\StsEditContactMsg();
            $viewContactMsg->viewContactMsg($this->id);
            if ($viewContactMsg->getResultado()) {
                $this->dados['form'] = $viewContactMsg->getResultadoBd();
                $this->viewEditContactMsg();
            } else {
                $urlDestino = URLADM . "list-contact-msg/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editContactMsg();
        }
    }

    private function viewEditContactMsg() {
        $button = ['list_contact_msg' => ['menu_controller' => 'list-contact-msg', 'menu_metodo' => 'index'],
            'view_contact_msg' => ['menu_controller' => 'view-contact-msg', 'menu_metodo' => 'index'],
            'delete_contact_msg' => ['menu_controller' => 'delete-contact-msg', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-contact-msg";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/contact/editContactMsg", $this->dados);
        $carregarView->renderAdmSite();
    }

    private function editContactMsg() {
        if (!empty($this->dadosForm['EditContactMsg'])) {
            unset($this->dadosForm['EditContactMsg']);
            $editContactMsg = new \App\sts\Models\StsEditContactMsg();
            $editContactMsg->update($this->dadosForm);
            if ($editContactMsg->getResultado()) {
                $urlDestino = URLADM . "list-contact-msg/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditContactMsg();
            }
        } else {
            $_SESSION['msg'] = "Mensagem de contato não encontrado!<br>";
            $urlDestino = URLADM . "list-contact-msg/index";
            header("Location: $urlDestino");
        }
    }

}
