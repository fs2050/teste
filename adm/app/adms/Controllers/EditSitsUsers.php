<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditSitsUsers Recebe as informações da situação de usuário que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditSitsUsers
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dadosForm;
    
    /** @var $id Recebe a Id da situação de usuário */
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditSitsUser']))) {
            $viewSitsUser = new \App\adms\Models\AdmsEditSitsUsers();
            $viewSitsUser->viewSitsUser($this->id);
            if ($viewSitsUser->getResultado()) {
                $this->dados['form'] = $viewSitsUser->getResultadoBd();
                $this->viewEditSitsUser();
            } else {
                $urlDestino = URLADM . "list-sits-users/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editSitsUser();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões, enviar as informações para a View e listar informações no dropdown do formulário
     */
    private function viewEditSitsUser() {
        $button = ['list_sits_users' => ['menu_controller' => 'list-sits-users', 'menu_metodo' => 'index'],
            'view_sits_users' => ['menu_controller' => 'view-sits-users', 'menu_metodo' => 'index'],
            'delete_sits_users' => ['menu_controller' => 'delete-sits-users', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsEditSitsUsers();
        $this->dados['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-sits-users";

        $carregarView = new \App\adms\core\ConfigView("adms/Views/sitsUser/editSitsUser", $this->dados);
        $carregarView->renderizar();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editSitsUser() {
        if (!empty($this->dadosForm['EditSitsUser'])) {
            unset($this->dadosForm['EditSitsUser']);
            $editSitsUser = new \App\adms\Models\AdmsEditSitsUsers();
            $editSitsUser->update($this->dadosForm);
            if ($editSitsUser->getResultado()) {
                $urlDestino = URLADM . "list-sits-users/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditSitsUser();
            }
        } else {
            $_SESSION['msg'] = "Situação para usuário não encontrado!<br>";
            $urlDestino = URLADM . "list-sits-users/index";
            header("Location: $urlDestino");
        }
    }

}
