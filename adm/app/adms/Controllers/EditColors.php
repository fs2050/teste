<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditColors Recebe as informações que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditColors
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dadosForm;
    
    /** @var $id Recebe o ID da cor que será editada*/
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditColors']))) {
            $viewColors = new \App\adms\Models\AdmsEditColors();
            $viewColors->viewColors($this->id);
            if ($viewColors->getResultado()) {
                $this->dados['form'] = $viewColors->getResultadoBd();
                $this->viewEditColors();
            } else {
                $urlDestino = URLADM . "list-colors/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editColors();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões e enviar as informações para a View
     */
    private function viewEditColors() {
        $button = ['list_colors' => ['menu_controller' => 'list-colors', 'menu_metodo' => 'index'],
            'view_colors' => ['menu_controller' => 'view-colors', 'menu_metodo' => 'index'],
            'delete_colors' => ['menu_controller' => 'delete-colors', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-colors";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/colors/editColors", $this->dados);
        $carregarView->renderizar();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editColors() {
        if (!empty($this->dadosForm['EditColors'])) {
            unset($this->dadosForm['EditColors']);
            $editColors = new \App\adms\Models\AdmsEditColors();
            $editColors->update($this->dadosForm);
            if ($editColors->getResultado()) {
                $urlDestino = URLADM . "list-colors/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditColors();
            }
        } else {
            $_SESSION['msg'] = "Cor não encontrada!<br>";
            $urlDestino = URLADM . "list-colors/index";
            header("Location: $urlDestino");
        }
    }

}
