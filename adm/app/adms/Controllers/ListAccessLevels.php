<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListAccessLevels Recebe as informações do nível de acesso que serão listadas na View
 *
 * @author Celke
 */
class ListAccessLevels
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listAccessLevels = new \App\adms\Models\AdmsListAccessLevels();
        $listAccessLevels->listAccessLevels($this->pag);
        if ($listAccessLevels->getResultado()) {
            $this->dados['listAccessLevels'] = $listAccessLevels->getResultadoBd();
            $this->dados['pagination'] = $listAccessLevels->getResultPg();
        } else {
            $this->dados['listAccessLevels'] = [];
            $this->dados['pagination'] = null;
        }

        $button = ['add_access_levels' => ['menu_controller' => 'add-access-levels', 'menu_metodo' => 'index'],
            'sync_pages_levels' => ['menu_controller' => 'sync-pages-levels', 'menu_metodo' => 'index'],
            'order_access_levels' => ['menu_controller' => 'order-access-levels', 'menu_metodo' => 'index'],
            'list_permission' => ['menu_controller' => 'list-permission', 'menu_metodo' => 'index'],
            'view_access_levels' => ['menu_controller' => 'view-access-levels', 'menu_metodo' => 'index'],
            'edit_access_levels' => ['menu_controller' => 'edit-access-levels', 'menu_metodo' => 'index'],
            'delete_access_levels' => ['menu_controller' => 'delete-access-levels', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $this->dados['pag'] = $this->pag;
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-access-levels";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/accessLevels/listAccessLevels", $this->dados);
        $carregarView->renderizar();
    }

}
