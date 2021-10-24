<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewPages Recebe as informações para visualizar os detalhes da página do sistema
 *
 * @author Celke
 */
class ViewPages
{
    /** @var int $id Recebe o Id da página a ser visualizada */
    private int $id;
    
    /** @var $data Recebe os dados que serão enviados para a View */
    private $data;

    /**
     * Metodo para receber os dados da View e enviar para Models
     * @param int $id Recebe o Id da página
     */
    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewPages = new \App\adms\Models\AdmsViewPages();
            $viewPages->viewPages($this->id);
            if ($viewPages->getResult()) {
                $this->data['viewPages'] = $viewPages->getResultDb();
                $this->viewPages();
            } else {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não encontrada</div>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar os dados para a View e carregar a View
     */
    private function viewPages() {
        $button = ['list_pages' => ['menu_controller' => 'list-pages', 'menu_metodo' => 'index'],
            'edit_pages' => ['menu_controller' => 'edit-pages', 'menu_metodo' => 'index'],
            'delete_pages' => ['menu_controller' => 'delete-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/pages/viewPages", $this->data);
        $loadView->renderizar();
    }

}
