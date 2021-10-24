<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewGroupsPages Recebe as informações para visualizar os detalhes do grupo de página
 *
 * @author robson
 */
class ViewGroupsPages
{
    /** @var int $id Recebe o Id do grupo de página a ser visualizado */
    private int $id;
    
    /** @var $data Recebe os dados que serão enviados para a View */
    private $data;

    /**
     * Metodo para receber os dados da View e enviar para Models
     * @param int $id Recebe o Id do grupo de página
     */
    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewGroupsPages = new \App\adms\Models\AdmsViewGroupsPages();
            $viewGroupsPages->viewGroupsPages($this->id);
            if ($viewGroupsPages->getResult()) {
                $this->data['viewGroupsPages'] = $viewGroupsPages->getResultDb();
                $this->viewGroupsPages();
            } else {
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não encontrado!</div>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar os dados para a View e carregar a View
     */
    private function viewGroupsPages() {
        $button = ['list_groups_pages' => ['menu_controller' => 'list-groups-pages', 'menu_metodo' => 'index'],
            'edit_groups_pages' => ['menu_controller' => 'edit-groups-pages', 'menu_metodo' => 'index'],
            'delete_groups_pages' => ['menu_controller' => 'delete-groups-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-groups-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/groupsPages/viewGroupsPages", $this->data);
        $loadView->renderizar();
    }

}
