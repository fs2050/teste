<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditConfEmails Recebe as informações que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditConfEmails
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dadosForm;
    
    /** @var $id Recebe o ID da cor que será editada*/
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditConfEmails']))) {
            $viewConfEmails = new \App\adms\Models\AdmsEditConfEmails();
            $viewConfEmails->viewConfEmails($this->id);
            if ($viewConfEmails->getResultado()) {
                $this->dados['form'] = $viewConfEmails->getResultadoBd();
                $this->viewEditConfEmails();
            } else {
                $urlDestino = URLADM . "list-conf-emails/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editConfEmails();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões e enviar as informações para a View
     */
    private function viewEditConfEmails() {
        $button = ['list_conf_emails' => ['menu_controller' => 'list-conf-emails', 'menu_metodo' => 'index'],
            'view_conf_emails' => ['menu_controller' => 'view-conf-emails', 'menu_metodo' => 'index'],
            'edit_conf_emails_password' => ['menu_controller' => 'edit-conf-emails-password', 'menu_metodo' => 'index'],
            'delete_conf_emails' => ['menu_controller' => 'delete-conf-emails', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-conf-emails";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/confEmails/editConfEmails", $this->dados);
        $carregarView->renderizar();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editConfEmails() {
        if (!empty($this->dadosForm['EditConfEmails'])) {
            unset($this->dadosForm['EditConfEmails']);
            $editConfEmails = new \App\adms\Models\AdmsEditConfEmails();
            $editConfEmails->update($this->dadosForm);
            if ($editConfEmails->getResultado()) {
                $urlDestino = URLADM . "view-conf-emails/index/" . $this->dadosForm['id'];
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditConfEmails();
            }
        } else {
            $_SESSION['msg'] = "E-mail não encontrado!<br>";
            $urlDestino = URLADM . "list-conf-emails/index";
            header("Location: $urlDestino");
        }
    }

}
