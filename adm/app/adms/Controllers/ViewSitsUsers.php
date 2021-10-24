<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewSitsUsers Recebe as informações para visualizar os detalhes da situação de usuário
 *
 * @author Celke
 */
class ViewSitsUsers
{
    /** @var int $id Recebe o Id da situação de usuário a ser visualizada */
    private int $id;
    
    /** @var $dados Recebe os dados que serão enviados para a View */
    private $dados;

    /**
     * Metodo para receber os dados da View e enviar para Models
     * @param int $id Recebe o Id da situação de usuário
     */
    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewSitsUser = new \App\adms\Models\AdmsViewSitsUsers();
            $viewSitsUser->viewSitsUser($this->id);
            if ($viewSitsUser->getResultado()) {
                $this->dados['viewSitsUser'] = $viewSitsUser->getResultadoBd();
                $this->viewSitsUser();
            } else {
                $urlDestino = URLADM . "list-sits-users/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
            $urlDestino = URLADM . "list-sits-users/index";
            header("Location: $urlDestino");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar os dados para a View e carregar a View
     */
    private function viewSitsUser() {
        $button = ['list_sits_users' => ['menu_controller' => 'list-sits-users', 'menu_metodo' => 'index'],
            'view_sits_users' => ['menu_controller' => 'view-sits-users', 'menu_metodo' => 'index'],
            'edit_sits_users' => ['menu_controller' => 'edit-sits-users', 'menu_metodo' => 'index'],
            'delete_sits_users' => ['menu_controller' => 'delete-sits-users', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-sits-users";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/sitsUser/viewSitsUser", $this->dados);
        $carregarView->renderizar();
    }

}
