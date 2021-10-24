<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewTypesPages Recebe as informações para visualizar os detalhes do tipo de página
 *
 * @author robson
 */
class ViewTypesPages
{
    /** @var int $id Recebe o Id do tipo de página a ser visualizada */
    private int $id;
    
    /** @var $data Recebe os dados que serão enviados para a View */
    private $data;

    /**
     * Metodo para receber os dados da View e enviar para Models
     * @param int $id Recebe o Id do tipo de página
     */
    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewTypesPages = new \App\adms\Models\AdmsViewTypesPages();
            $viewTypesPages->viewTypesPages($this->id);
            if ($viewTypesPages->getResult()) {
                $this->data['viewTypesPages'] = $viewTypesPages->getResultDb();
                $this->viewTypesPages();
            } else {
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não encontrado!</div>";
            $urlRedirect = URLADM . "list-types-pages/index";
            header("Location: $urlRedirect");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar os dados para a View e carregar a View
     */
    private function viewTypesPages() {
        $button = ['list_types_pages' => ['menu_controller' => 'list-types-pages', 'menu_metodo' => 'index'],
            'edit_types_pages' => ['menu_controller' => 'edit-types-pages', 'menu_metodo' => 'index'],
            'delete_types_pages' => ['menu_controller' => 'delete-types-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-types-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/typesPages/viewTypesPages", $this->data);
        $loadView->renderizar();
    }

}
