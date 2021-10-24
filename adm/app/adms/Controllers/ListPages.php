<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListPages Recebe as informações das páginas do sistema que serão listadas na View
 *
 * @author Celke
 */
class ListPages
{
    /** @var $data Recebe as informações que serão enviadas para a View*/
    private $data;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listPages = new \App\adms\Models\AdmsListPages();
        $listPages->listPages($this->pag);
        if ($listPages->getResult()) {
            $this->data['listPages'] = $listPages->getResultDb();
            $this->data['pagination'] = $listPages->getResultPg();
        } else {
            $this->data['listPages'] = [];
            $this->data['pagination'] = null;
        }
        $button = ['add_pages' => ['menu_controller' => 'add-pages', 'menu_metodo' => 'index'],
            'view_pages' => ['menu_controller' => 'view-pages', 'menu_metodo' => 'index'],
            'edit_pages' => ['menu_controller' => 'edit-pages', 'menu_metodo' => 'index'],
            'delete_pages' => ['menu_controller' => 'delete-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/pages/listPages", $this->data);
        $loadView->renderizar();
    }

}
