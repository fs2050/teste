<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewPerfil Recebe as informações para visualizar os detalhes do perfil do usuário
 *
 * @author Celke
 */
class ViewPerfil
{
    /** @var $dados Recebe os dados que serão enviados para a View */
    private $dados;

    /**
     * Metodo para instanciar a Models AdmsViewPerfil e buscar as informações do perfil do usuário
     */
    public function index() {
        $viewPerfil = new \App\adms\Models\AdmsViewPerfil();
        $viewPerfil->viewPerfil();
        if ($viewPerfil->getResultado()) {
            $this->dados['perfil'] = $viewPerfil->getResultadoBd();
            $this->viewPerfil();
        } else {
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar os dados para a View e carregar a View
     */
    private function viewPerfil() {
        $button = ['edit_perfil' => ['menu_controller' => 'edit-perfil', 'menu_metodo' => 'index'],
            'edit_perfil_password' => ['menu_controller' => 'edit-perfil-password', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-perfil";

        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/viewPerfil", $this->dados);
        $carregarView->renderizar();
    }

}
