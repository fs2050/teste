<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListContactMsg
 *
 * @author Celke
 */
class ListContactMsg
{
    private $dados;
    private $pag;
    
    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listContactMsg = new \App\sts\Models\StsListContactMsg();
        $listContactMsg->listContactMsg($this->pag);
        if ($listContactMsg->getResultado()) {
            $this->dados['listContactMsg'] = $listContactMsg->getResultadoBd();
            $this->dados['pagination'] = $listContactMsg->getResultPg();
            $this->dados['pag'] = $this->pag;
        } else {
            $this->dados['listContactMsg'] = [];
            $this->dados['pagination'] = null;
            $this->dados['pag'] = $this->pag;
        }

        $button = ['add_contact_msg' => ['menu_controller' => 'add-contact-msg', 'menu_metodo' => 'index'],
            'view_contact_msg' => ['menu_controller' => 'view-contact-msg', 'menu_metodo' => 'index'],
            'edit_contact_msg' => ['menu_controller' => 'edit-contact-msg', 'menu_metodo' => 'index'],
            'delete_contact_msg' => ['menu_controller' => 'delete-contact-msg', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-contact-msg";
        $carregarView = new \App\sts\core\ConfigView("sts/Views/contact/listContactMsg", $this->dados);
        $carregarView->renderAdmSite();
    }

}
