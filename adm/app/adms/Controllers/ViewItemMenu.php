<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ViewItemMenu
 *
 * @author Celke
 */
class ViewItemMenu
{
    
    private int $id;
    private $data;

    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewItemMenu = new \App\adms\Models\AdmsViewItemMenus();
            $viewItemMenu->viewItemMenu($this->id);
            if ($viewItemMenu->getResult()) {
                $this->data['viewItemMenu'] = $viewItemMenu->getResultDb();
                $this->viewItemMenu();
            } else {
                $urlRedirect = URLADM . "list-item-menu/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não encontrado!</div>";
            $urlRedirect = URLADM . "list-item-menu/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewItemMenu() {
        $button = ['list_item_menu' => ['menu_controller' => 'list-item-menu', 'menu_metodo' => 'index'],
            'edit_item_menu' => ['menu_controller' => 'edit-item-menu', 'menu_metodo' => 'index'],
            'delete_item_menu' => ['menu_controller' => 'delete-item-menu', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-item-menu";
        $loadView = new \App\adms\core\ConfigView("adms/Views/itemMenu/viewItemMenu", $this->data);
        $loadView->renderizar();
    }

}
