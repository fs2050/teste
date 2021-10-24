<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditUsers Recebe as informações do usuário que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditUsers
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dadosForm;
    
    /** @var $id Recebe a Id do usuário */
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditUser']))) {
            $viewUser = new \App\adms\Models\AdmsEditUsers();
            $viewUser->viewUser($this->id);
            if ($viewUser->getResultado()) {
                $this->dados['form'] = $viewUser->getResultadoBd();
                $this->viewEditUser();
            } else {
                $urlDestino = URLADM . "list-users/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editUser();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões, enviar as informações para a View e listar informações no dropdown do formulário
     */
    private function viewEditUser() {
        $button = ['list_users' => ['menu_controller' => 'list-users', 'menu_metodo' => 'index'],
            'view_users' => ['menu_controller' => 'view-users', 'menu_metodo' => 'index'],
            'edit_users_password' => ['menu_controller' => 'edit-users-password', 'menu_metodo' => 'index'],
            'delete_users' => ['menu_controller' => 'delete-users', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        //$listSelect = new \App\adms\Models\AdmsAddUsers();
        //$this->dados['select'] = $listSelect->listSelect();

        $listSelect = new \App\adms\Models\AdmsEditUsers();
        $this->dados['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-users";

        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editUser", $this->dados);
        $carregarView->renderizar();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editUser() {
        if (!empty($this->dadosForm['EditUser'])) {
            unset($this->dadosForm['EditUser']);
            $editUser = new \App\adms\Models\AdmsEditUsers();
            $editUser->update($this->dadosForm);
            if ($editUser->getResultado()) {
                $urlDestino = URLADM . "list-users/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditUser();
            }
        } else {
            $_SESSION['msg'] = "Usuário não encontrado!<br>";
            $urlDestino = URLADM . "list-users/index";
            header("Location: $urlDestino");
        }
    }

}
