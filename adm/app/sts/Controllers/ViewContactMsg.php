<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewContactMsg
 *
 * @author Celke
 */
class ViewContactMsg
{
    
    private int $id;
    private $dados;

    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewContactMsg = new \App\sts\Models\StsViewContactMsg();
            $viewContactMsg->viewContactMsg($this->id);
            if ($viewContactMsg->getResultado()) {
                $this->dados['viewContactMsg'] = $viewContactMsg->getResultadoBd();
                $this->viewContactMsg();
            } else {
                $urlDestino = URLADM . "list-contact-msg/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não encontrada</div>";
            $urlDestino = URLADM . "list-contact-msg/index";
            header("Location: $urlDestino");
        }
    }

    private function viewContactMsg() {
        $button = ['list_contact_msg' => ['menu_controller' => 'list-contact-msg', 'menu_metodo' => 'index'],
            'edit_contact_msg' => ['menu_controller' => 'edit-contact-msg', 'menu_metodo' => 'index'],
            'delete_contact_msg' => ['menu_controller' => 'delete-contact-msg', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-contact-msg";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/contact/viewContactMsg", $this->dados);
        $carregarView->renderAdmSite();
    }

}
