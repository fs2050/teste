<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditAccessLevels Recebe as informações que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditAccessLevels
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dadosForm;
    
    /** @var $id Recebe o ID do nível de acesso que será editado*/
    private $id;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditAccessLevels']))) {
            $viewAccessLevels = new \App\adms\Models\AdmsEditAccessLevels();
            $viewAccessLevels->viewAccessLevels($this->id);
            if ($viewAccessLevels->getResultado()) {
                $this->dados['form'] = $viewAccessLevels->getResultadoBd();
                $this->viewEditAccessLevels();
            } else {
                $urlDestino = URLADM . "list-access-levels/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editAccessLevels();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões e enviar as informações para a View
     */
    private function viewEditAccessLevels() {
        $button = ['list_access_levels' => ['menu_controller' => 'list-access-levels', 'menu_metodo' => 'index'],
            'view_access_levels' => ['menu_controller' => 'view-access-levels', 'menu_metodo' => 'index'],
            'delete_access_levels' => ['menu_controller' => 'delete-access-levels', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-acess-levels";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/accessLevels/editAccessLevels", $this->dados);
        $carregarView->renderizar();
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editAccessLevels() {
        if (!empty($this->dadosForm['EditAccessLevels'])) {
            unset($this->dadosForm['EditAccessLevels']);
            $editAccessLevels = new \App\adms\Models\AdmsEditAccessLevels();
            $editAccessLevels->update($this->dadosForm);
            if ($editAccessLevels->getResultado()) {
                $urlDestino = URLADM . "list-access-levels/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditAccessLevels();
            }
        } else {
            $_SESSION['msg'] = "Nível de acesso não encontrado!<br>";
            $urlDestino = URLADM . "list-access-levels/index";
            header("Location: $urlDestino");
        }
    }

}
