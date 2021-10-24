<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListSitsUsers Recebe as informações das situações de usuários que serão listadas na View
 *
 * @author Celke
 */
class ListSitsUsers
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listSitsUsers = new \App\adms\Models\AdmsListSitsUsers();
        $listSitsUsers->listSitsUsers($this->pag);
        if ($listSitsUsers->getResultado()) {
            $this->dados['listSitsUsers'] = $listSitsUsers->getResultadoBd();
            $this->dados['pagination'] = $listSitsUsers->getResultPg();
        } else {
            $this->dados['listSitsUsers'] = [];
            $this->dados['pagination'] = null;
        }
        
        $button = ['add_sits_users' => ['menu_controller' => 'add-sits-users', 'menu_metodo' => 'index'],
            'view_sits_users' => ['menu_controller' => 'view-sits-users', 'menu_metodo' => 'index'],
            'edit_sits_users' => ['menu_controller' => 'edit-sits-users', 'menu_metodo' => 'index'],
            'delete_sits_users' => ['menu_controller' => 'delete-sits-users', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-sits-users";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/sitsUser/listSitsUsers", $this->dados);
        $carregarView->renderizar();
    }

}
