<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListUsers Recebe as informações dos usuários que serão listados na View
 *
 * @author Celke
 */
class ListUsers
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listUsers = new \App\adms\Models\AdmsListUsers();
        $listUsers->listUsers($this->pag);
        if ($listUsers->getResultado()) {
            $this->dados['listUsers'] = $listUsers->getResultadoBd();
            $this->dados['pagination'] = $listUsers->getResultPg();
        } else {
            $this->dados['listUsers'] = [];
            $this->dados['pagination'] = null;
        }
        
        $button = ['add_users' => ['menu_controller' => 'add-users', 'menu_metodo' => 'index'],
            'view_users' => ['menu_controller' => 'view-users', 'menu_metodo' => 'index'],
            'edit_users' => ['menu_controller' => 'edit-users', 'menu_metodo' => 'index'],
            'delete_users' => ['menu_controller' => 'delete-users', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        //var_dump($this->dados['button']);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-users";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/listUser", $this->dados);
        $carregarView->renderizar();
    }

}
