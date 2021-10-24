<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListTypesPages Recebe as informações dos tipos de páginas que serão listadas na View
 *
 * @author robson
 */
class ListTypesPages
{
    /** @var $data Recebe as informações que serão enviadas para a View*/
    private $data;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null)
    {
        $this->pag = (int) $pag ? $pag : 1;

        $listTypesPages = new \App\adms\Models\AdmsListTypesPages();
        $listTypesPages->listTypesPages($this->pag);
        if ($listTypesPages->getResult()) {
            $this->data['listTypesPages'] = $listTypesPages->getResultDb();
            $this->data['pagination'] = $listTypesPages->getResultPg();
        } else {
            $this->data['listTypesPages'] = [];
            $this->data['pagination'] = null;
        }
        
        $button = ['add_types_pages' => ['menu_controller' => 'add-types-pages', 'menu_metodo' => 'index'],
            'order_types_pages' => ['menu_controller' => 'order-types-pages', 'menu_metodo' => 'index'],
            'view_types_pages' => ['menu_controller' => 'view-types-pages', 'menu_metodo' => 'index'],
            'edit_types_pages' => ['menu_controller' => 'edit-types-pages', 'menu_metodo' => 'index'],
            'delete_types_pages' => ['menu_controller' => 'delete-types-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $this->data['pag'] = $this->pag;
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-types-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/typesPages/listTypesPages", $this->data);
        $loadView->renderizar();
    }

}
