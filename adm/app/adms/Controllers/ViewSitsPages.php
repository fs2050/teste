<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewSitsPages Recebe as informações para visualizar os detalhes da situação de página
 *
 * @author Celke
 */
class ViewSitsPages
{
    /** @var int $id Recebe o Id da situação de página a ser visualizada */
    private int $id;
    
    /** @var $data Recebe os dados que serão enviados para a View */
    private $data;

    /**
     * Metodo para receber os dados da View e enviar para Models
     * @param int $id Recebe o Id da situação de página
     */
    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewSitsPages = new \App\adms\Models\AdmsViewSitsPages();
            $viewSitsPages->viewSitsPages($this->id);
            if ($viewSitsPages->getResult()) {
                $this->data['viewSitsPages'] = $viewSitsPages->getResultBd();
                $this->viewSitsPages();
            } else {
                $urlRedirect = URLADM . "list-sits-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
            $urlRedirect = URLADM . "list-sits-pages/index";
            header("Location: $urlRedirect");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar os dados para a View e carregar a View
     */
    private function viewSitsPages() {
        $button = ['list_sits_pages' => ['menu_controller' => 'list-sits-pages', 'menu_metodo' => 'index'],
            'edit_sits_pages' => ['menu_controller' => 'edit-sits-pages', 'menu_metodo' => 'index'],
            'delete_sits_pages' => ['menu_controller' => 'delete-sits-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-sits-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/sitsPages/viewSitsPages", $this->data);
        $loadView->renderizar();
    }

}
