<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewAccessLevels Recebe as informações para visualizar os detalhes do nível de acesso
 *
 * @author Celke
 */
class ViewAccessLevels
{
    /** @var int $id Recebe o Id do nível de acesso a ser visualizado */
    private int $id;
    
    /** @var $dados Recebe os dados que serão enviados para a View */
    private $dados;

    /**
     * Metodo para receber os dados da View e enviar para Models
     * @param int $id Recebe o Id do nível de acesso
     */
    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewAccessLevels = new \App\adms\Models\AdmsViewAccessLevels();
            $viewAccessLevels->viewAccessLevels($this->id);
            if ($viewAccessLevels->getResultado()) {
                $this->dados['viewAccessLevels'] = $viewAccessLevels->getResultadoBd();
                $this->viewAccessLevels();
            } else {
                $urlDestino = URLADM . "list-access-levels/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso não encontrado!</div>";
            $urlDestino = URLADM . "list-access-levels/index";
            header("Location: $urlDestino");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar os dados para a View e carregar a View
     */
    private function viewAccessLevels() {
        $button = ['list_access_levels' => ['menu_controller' => 'list-access-levels', 'menu_metodo' => 'index'],
            'edit_access_levels' => ['menu_controller' => 'edit-access-levels', 'menu_metodo' => 'index'],
            'delete_access_levels' => ['menu_controller' => 'delete-access-levels', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-access-levels";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/accessLevels/viewAccessLevels", $this->dados);
        $carregarView->renderizar();
    }

}
