<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListGroupsPages Recebe as informações do grupos de página que serão listadas na View
 *
 * @author robson
 */
class ListGroupsPages
{
    /** @var $data Recebe as informações que serão enviadas para a View*/
    private $data;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null)
    {
        $this->pag = (int) $pag ? $pag : 1;

        $listGroupsPages = new \App\adms\Models\AdmsListGroupsPages();
        $listGroupsPages->listGroupsPages($this->pag);
        if ($listGroupsPages->getResult()) {
            $this->data['listGroupsPages'] = $listGroupsPages->getResultDb();
            $this->data['pagination'] = $listGroupsPages->getResultPg();
        } else {
            $this->data['listGroupsPages'] = [];
            $this->data['pagination'] = null;
        }
        
        $button = ['add_groups_pages' => ['menu_controller' => 'add-groups-pages', 'menu_metodo' => 'index'],
            'order_groups_pages' => ['menu_controller' => 'order-groups-pages', 'menu_metodo' => 'index'],
            'view_groups_pages' => ['menu_controller' => 'view-groups-pages', 'menu_metodo' => 'index'],
            'edit_groups_pages' => ['menu_controller' => 'edit-groups-pages', 'menu_metodo' => 'index'],
            'delete_groups_pages' => ['menu_controller' => 'delete-groups-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $this->data['pag'] = $this->pag;
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-groups-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/groupsPages/listGroupsPages", $this->data);
        $loadView->renderizar();
    }

}
