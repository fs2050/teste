<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AddItemMenu
 *
 * @author Celke
 */
class AddItemMenu
{
    
    private $data;
    private $dataForm;

    public function index() {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dataForm['AddItemMenu'])) {
            unset($this->dataForm['AddItemMenu']);
            $addItemMenu = new \App\adms\Models\AdmsAddItemMenu();
            $addItemMenu->create($this->dataForm);
            if ($addItemMenu->getResult()) {
                $urlRedirect = URLADM . "list-item-menu/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddItemMenu();
            }
        } else {
            $this->viewAddItemMenu();
        }
    }
    
    private function viewAddItemMenu() {
        $button = ['list_item_menu' => ['menu_controller' => 'list-item-menu', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-item-menu";
        $loadView = new \App\adms\core\ConfigView("adms/Views/itemMenu/addItemMenu", $this->data);
        $loadView->renderizar();
    }

}
