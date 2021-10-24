<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListPermission Recebe as informações das permissões que serão listadas na View
 *
 * @author Celke
 */
class ListPermission
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;
    
    /** @var $level Recebe o nível de acesso referente as permissões*/
    private $level;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null) {

        $this->level = filter_input(INPUT_GET, 'level', FILTER_SANITIZE_NUMBER_INT);
        //var_dump($this->level);
        $this->pag = (int) $pag ? $pag : 1;

        $listPermission = new \App\adms\Models\AdmsListPermission();
        $listPermission->listPermission($this->pag, $this->level);
        if ($listPermission->getResultado()) {
            $this->dados['listPermission'] = $listPermission->getResultadoBd();
            $this->dados['pagination'] = $listPermission->getResultPg();
            $this->dados['pag'] = $this->pag;
        } else {
            $this->dados['listPermission'] = [];
            $this->dados['pagination'] = null;
            $this->dados['pag'] = $this->pag;
        }
        
        $button = ['list_access_levels' => ['menu_controller' => 'list-access-levels', 'menu_metodo' => 'index'],
            'edit_permission' => ['menu_controller' => 'edit-permission', 'menu_metodo' => 'index'],
            'edit_print_menu' => ['menu_controller' => 'edit-print-menu', 'menu_metodo' => 'index'],
            'order_page_menu' => ['menu_controller' => 'order-page-menu', 'menu_metodo' => 'index'],
            'edit_dropdown_menu' => ['menu_controller' => 'edit-dropdown-menu', 'menu_metodo' => 'index'],
            'edit_page_menu' => ['menu_controller' => 'edit-page-menu', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-access-levels";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/permission/listPermission", $this->dados);
        $carregarView->renderizar();
    }

}
