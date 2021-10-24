<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditItemMenu
 *
 * @author Celke
 */
class EditItemMenu
{
    
    private $data;
    private $dataForm;
    private $id;

    public function index($id) {
        $this->id = (int) $id;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dataForm['EditItemMenu']))) {
            $viewItemMenu = new \App\adms\Models\AdmsEditItemMenu();
            $viewItemMenu->viewItemMenu($this->id);
            if ($viewItemMenu->getResult()) {
                $this->data['form'] = $viewItemMenu->getResultDb();
                $this->viewEditItemMenu();
            } else {
                $urlRedirect = URLADM . "list-item-menu/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editItemMenu();
        }
    }

    private function viewEditItemMenu() {
        $button = ['list_item_menu' => ['menu_controller' => 'list-item-menu', 'menu_metodo' => 'index'],
            'view_item_menu' => ['menu_controller' => 'view-item-menu', 'menu_metodo' => 'index'],
            'delete_item_menu' => ['menu_controller' => 'delete-item-menu', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-item-menu";
        $loadView = new \App\adms\core\ConfigView("adms/Views/itemMenu/editItemMenu", $this->data);
        $loadView->renderizar();
    }

    private function editItemMenu() {
        if (!empty($this->dataForm['EditItemMenu'])) {
            unset($this->dataForm['EditItemMenu']);
            $editItemMenu = new \App\adms\Models\AdmsEditItemMenu();
            $editItemMenu->update($this->dataForm);
            if ($editItemMenu->getResult()) {
                $urlRedirect = URLADM . "list-item-menu/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditGroupsPages();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Item de menu não encontrado!</div>";
            $urlRedirect = URLADM . "list-item-menu/index";
            header("Location: $urlRedirect");
        }
    }

}
