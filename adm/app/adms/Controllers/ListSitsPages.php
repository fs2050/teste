<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListSitsPages Recebe as informações das situações de páginas que serão listadas na View
 *
 * @author robson
 */
class ListSitsPages
{
    /** @var $data Recebe as informações que serão enviadas para a View*/
    private $data;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null) {
        $this->pag = (int) $pag ? $pag : 1;

        $listSitsPages = new \App\adms\Models\AdmsListSitsPages();
        $listSitsPages->listSitsPages($this->pag);
        if ($listSitsPages->getResult()) {
            $this->data['listSitsPages'] = $listSitsPages->getResultDb();
            $this->data['pagination'] = $listSitsPages->getResultPg();
        } else {
            $this->data['listSitsPages'] = [];
            $this->data['pagiantion'] = null;
        }
        
        $button = ['add_sits_pages' => ['menu_controller' => 'add-sits-pages', 'menu_metodo' => 'index'],
            'view_sits_pages' => ['menu_controller' => 'view-sits-pages', 'menu_metodo' => 'index'],
            'edit_sits_pages' => ['menu_controller' => 'edit-sits-pages', 'menu_metodo' => 'index'],
            'delete_sits_pages' => ['menu_controller' => 'delete-sits-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-sits-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/sitsPages/listSitsPages", $this->data);
        $loadView->renderizar();
    }

}
