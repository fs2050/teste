<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 *  * A classe AddContactMsg
 *
 * @author Celke
 */
class AddContactMsg {

    private $dados;
    private $dadosForm;

    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddContactMsg'])) {
            unset($this->dadosForm['AddContactMsg']);            
            $addContactMsg = new \App\sts\Models\StsAddContactMsg();
            $addContactMsg->create($this->dadosForm);
            if ($addContactMsg->getResultado()) {
                $urlDestino = URLADM . "list-contact-msg/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddContactMsg();
            }
        } else {
            $this->viewAddContactMsg();
        }
    }

    private function viewAddContactMsg() {
        $button = ['list_contact_msg' => ['menu_controller' => 'list-contact-msg', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-contact-msg";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/contact/addContactMsg", $this->dados);
        $carregarView->renderAdmSite();
    }

}
