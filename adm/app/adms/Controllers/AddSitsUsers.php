<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AddSitsPages cadastra uma nova situação de usuário no sistema
 *
 * @author Celke
 */
class AddSitsUsers
{
    /** @var $dados Recebe as informações que estarão na Views*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações que serão cadastradas no banco de dados através do formulário*/
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddSitsUser'])) {
            unset($this->dadosForm['AddSitsUser']);
            $addSitsUser = new \App\adms\Models\AdmsAddSitsUsers();
            $addSitsUser->create($this->dadosForm);
            if ($addSitsUser->getResultado()) {
                $urlDestino = URLADM . "list-sits-users/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddSitsUser();
            }
        } else {
            $this->viewAddSitsUser();
        }
    }

    /** Metodo para enviar os dados para a View, carregar os botões e listar opções no dropdown do formulário
     * Metodo privado, só pode ser chamado na classe
     */
    private function viewAddSitsUser() {
        $button = ['list_sits_users' => ['menu_controller' => 'list-sits-users', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsAddSitsUsers();
        $this->dados['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-sits-users";

        $carregarView = new \App\adms\core\ConfigView("adms/Views/sitsUser/addSitsUser", $this->dados);
        $carregarView->renderizar();
    }

}
