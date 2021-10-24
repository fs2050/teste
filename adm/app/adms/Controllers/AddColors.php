<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 *  * A classe AddColors cadastra uma nova cor no sistema
 *
 * @author Celke
 */
class AddColors
{
    /** @var $dados Recebe as informações que estarão na Views*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações que serão cadastradas no banco de dados através do formulário*/
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddColors'])) {
            unset($this->dadosForm['AddColors']);
            $addColors = new \App\adms\Models\AdmsAddColors();
            $addColors->create($this->dadosForm);
            if ($addColors->getResultado()) {
                $urlDestino = URLADM . "list-colors/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddColors();
            }
        } else {
            $this->viewAddColors();
        }
    }

    /** Metodo para enviar os dados para a View e carregar os botões
     * Metodo privado, só pode ser chamado na classe
     */
    private function viewAddColors() {
        $button = ['list_colors' => ['menu_controller' => 'list-colors', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-colors";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/colors/addColors", $this->dados);
        $carregarView->renderizar();
    }

}
