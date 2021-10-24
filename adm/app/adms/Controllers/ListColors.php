<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ListColors Recebe as informações das cores que serão listadas na View
 *
 * @author Celke
 */
class ListColors
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $pag Recebe o numero dá pagina para que seja feita a paginação do resultado vindo do banco de dados */
    private $pag;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listColors = new \App\adms\Models\AdmsListColors();
        $listColors->listColors($this->pag);
        if ($listColors->getResultado()) {
            $this->dados['listColors'] = $listColors->getResultadoBd();
            $this->dados['pagination'] = $listColors->getResultPg();
        } else {
            $this->dados['listColors'] = [];
            $this->dados['pagination'] = null;
        }

        $button = ['add_colors' => ['menu_controller' => 'add-colors', 'menu_metodo' => 'index'],
            'view_colors' => ['menu_controller' => 'view-colors', 'menu_metodo' => 'index'],
            'edit_colors' => ['menu_controller' => 'edit-colors', 'menu_metodo' => 'index'],
            'delete_colors' => ['menu_controller' => 'delete-colors', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-colors";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/colors/listColors", $this->dados);
        $carregarView->renderizar();
    }

}
