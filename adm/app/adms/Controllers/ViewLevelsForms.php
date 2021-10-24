<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewLevelsForms Recebe as informações para visualizar os detalhes do Levels Forms
 *
 * @author Celke
 */
class ViewLevelsForms
{
    /** @var $dados Recebe os dados que serão enviados para a View */
    private $dados;

    /**
     * Metodo para instanciar a Models AdmsViewLevelsForms e buscar as informações do Levels Forms
     */
    public function index() {
        $viewLevelsForms = new \App\adms\Models\AdmsViewLevelsForms();
        $viewLevelsForms->viewLevelsForms();
        if ($viewLevelsForms->getResultado()) {
            $this->dados['viewLevelsForms'] = $viewLevelsForms->getResultadoBd();
            $this->viewLevelsForms();
        } else {
            $urlDestino = URLADM . "dashboard/index";
            header("Location: $urlDestino");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar os dados para a View e carregar a View
     */
    private function viewLevelsForms() {
        $button = ['edit_levels_forms' => ['menu_controller' => 'edit-levels-forms', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-levels-forms";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/levelsForms/viewLevelsForms", $this->dados);
        $carregarView->renderizar();
    }

}
