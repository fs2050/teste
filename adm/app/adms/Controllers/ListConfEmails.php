<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListConfEmails Recebe as informações das configurações de e-mails que serão listadas na View
 *
 * @author Celke
 */
class ListConfEmails
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listConfEmails = new \App\adms\Models\AdmsListConfEmails();
        $listConfEmails->listConfEmails($this->pag);
        if ($listConfEmails->getResultado()) {
            $this->dados['listConfEmails'] = $listConfEmails->getResultadoBd();
            $this->dados['pagination'] = $listConfEmails->getResultPg();
        } else {
            $this->dados['listConfEmails'] = [];
            $this->dados['pagination'] = null;
        }
        $button = ['add_conf_emails' => ['menu_controller' => 'add-conf-emails', 'menu_metodo' => 'index'],
            'view_conf_emails' => ['menu_controller' => 'view-conf-emails', 'menu_metodo' => 'index'],
            'edit_conf_emails' => ['menu_controller' => 'edit-conf-emails', 'menu_metodo' => 'index'],
            'delete_conf_emails' => ['menu_controller' => 'delete-conf-emails', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-conf-emails";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/confEmails/listConfEmails", $this->dados);
        $carregarView->renderizar();
    }

}
