<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListItemMenu
 *
 * @author Celke
 */
class ListItemMenu
{
    
    private $data;
    private $pag;

    
    public function index($pag = null)
    {
        $this->pag = (int) $pag ? $pag : 1;

        $listItemMenu = new \App\adms\Models\AdmsListItemMenu();
        $listItemMenu->listItemMenu($this->pag);
        if ($listItemMenu->getResult()) {
            $this->data['listItemMenu'] = $listItemMenu->getResultDb();
            $this->data['pagination'] = $listItemMenu->getResultPg();
        } else {
            $this->data['listItemMenu'] = [];
            $this->data['pagination'] = null;
        }
        
        $button = ['add_item_menu' => ['menu_controller' => 'add-item-menu', 'menu_metodo' => 'index'],
            'order_item_menu' => ['menu_controller' => 'order-item-menu', 'menu_metodo' => 'index'],
            'view_item_menu' => ['menu_controller' => 'view-item-menu', 'menu_metodo' => 'index'],
            'edit_item_menu' => ['menu_controller' => 'edit-item-menu', 'menu_metodo' => 'index'],
            'delete_item_menu' => ['menu_controller' => 'delete-item-menu', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $this->data['pag'] = $this->pag;
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-item-menu";
        $loadView = new \App\adms\core\ConfigView("adms/Views/itemMenu/listItemMenu", $this->data);
        $loadView->renderizar();
    }

}
