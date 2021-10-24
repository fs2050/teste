<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AddConfEmails cadastra uma nova configuração de e-mail no sistema
 *
 * @author Celke
 */
class AddConfEmails
{
    /** @var $dados Recebe as informações que estarão na Views*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações que serão cadastradas no banco de dados através do formulário*/
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddConfEmails'])) {
            unset($this->dadosForm['AddConfEmails']);
            $addConfEmails = new \App\adms\Models\AdmsAddConfEmails();
            $addConfEmails->create($this->dadosForm);
            if ($addConfEmails->getResultado()) {
                $urlDestino = URLADM . "list-conf-emails/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddConfEmails();
            }
        } else {
            $this->viewAddConfEmails();
        }
    }
    
    /** Metodo para enviar os dados para a View e carregar os botões
     * Metodo privado, só pode ser chamado na classe
     */
    private function viewAddConfEmails() {
        $button = ['list_conf_emails' => ['menu_controller' => 'list-conf-emails', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-conf-emails";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/confEmails/addConfEmails", $this->dados);
        $carregarView->renderizar();
    }

}
