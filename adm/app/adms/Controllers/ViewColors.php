<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewColors Recebe as informações para visualizar os detalhes da cor
 *
 * @author Celke
 */
class ViewColors
{
    /** @var int $id Recebe o Id da cor a ser visualizado */
    private int $id;
    
    /** @var $dados Recebe os dados que serão enviados para a View */
    private $dados;

    /**
     * Metodo para receber os dados da View e enviar para Models
     * @param int $id Recebe o Id da cor
     */
    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewColors = new \App\adms\Models\AdmsViewColors();
            $viewColors->viewColors($this->id);
            if ($viewColors->getResultado()) {
                $this->dados['viewColors'] = $viewColors->getResultadoBd();
                $this->viewColors();
            } else {
                $urlDestino = URLADM . "list-colors/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
            $urlDestino = URLADM . "list-colors/index";
            header("Location: $urlDestino");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar os dados para a View e carregar a View
     */
    private function viewColors() {
        $button = ['list_colors' => ['menu_controller' => 'list-colors', 'menu_metodo' => 'index'],
            'edit_colors' => ['menu_controller' => 'edit-colors', 'menu_metodo' => 'index'],
            'delete_colors' => ['menu_controller' => 'delete-colors', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-colors";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/colors/viewColors", $this->dados);
        $carregarView->renderizar();
    }

}
