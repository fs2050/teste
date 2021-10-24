<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AddAccessLevels cadastra um novo nível de acesso no sistema
 *
 * @author Celke
 */
class AddAccessLevels
{
    /** @var $dados Recebe as informações que estarão na Views*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações que serão cadastradas no banco de dados através do formulário*/
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddAccessLevels'])) {
            unset($this->dadosForm['AddAccessLevels']);
            $addAccessLevels = new \App\adms\Models\AdmsAddAccessLevels();
            $addAccessLevels->create($this->dadosForm);
            if ($addAccessLevels->getResultado()) {
                $urlDestino = URLADM . "list-access-levels/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddAccessLevels();
            }
        } else {
            $this->viewAddAccessLevels();
        }
    }

    /** Metodo para enviar os dados para a View e carregar os botões
     * Metodo privado, só pode ser chamado na classe
     */
    private function viewAddAccessLevels() {
        $button = ['list_access_levels' => ['menu_controller' => 'list-access-levels', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-access-levels";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/accessLevels/addAccessLevels", $this->dados);
        $carregarView->renderizar();
    }

}
