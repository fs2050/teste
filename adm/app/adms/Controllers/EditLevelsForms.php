<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditGroupsPages Recebe as informações que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditLevelsForms
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (empty($this->dadosForm['EditLevelsForms'])) {
            $viewLevelsForm = new \App\adms\Models\AdmsEditLevelsForms();
            $viewLevelsForm->viewLevelsForms();
            if ($viewLevelsForm->getResultado()) {
                $this->dados['form'] = $viewLevelsForm->getResultadoBd();
                $this->viewEditLevelsForms();
            } else {
                $urlDestino = URLADM . "view-levels-forms/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editLevelsForms();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões, enviar as informações para a View e enviar informações que serão usadas no dropdown do formulário
     */
    private function viewEditLevelsForms() {
        $button = ['view_levels_forms' => ['menu_controller' => 'view-levels-forms', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsEditUsers();
        $this->dados['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-levels-forms";

        $carregarView = new \App\adms\core\ConfigView("adms/Views/levelsForms/editLevelsForms", $this->dados);
        $carregarView->renderizar();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editLevelsForms() {
        if (!empty($this->dadosForm['EditLevelsForms'])) {
            unset($this->dadosForm['EditLevelsForms']);
            $editLevelsForm = new \App\adms\Models\AdmsEditLevelsForms();
            $editLevelsForm->update($this->dadosForm);
            if ($editLevelsForm->getResultado()) {
                $urlDestino = URLADM . "view-levels-forms/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditLevelsForms();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso para formulário novo usuário não encontrado!</div>";
            $urlDestino = URLADM . "view-levels-forms/index";
            header("Location: $urlDestino");
        }
    }

}
