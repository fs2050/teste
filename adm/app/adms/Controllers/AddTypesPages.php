<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AddTypesPages cadastra um novo tipo de página no sistema
 *
 * @author robson
 */
class AddTypesPages
{
    /** @var $data Recebe as informações que estarão na Views*/
    private $data;
    
    /** @var $dataForm Recebe as informações que serão cadastradas no banco de dados através do formulário*/
    private $dataForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dataForm['AddTypesPages'])) {
            unset($this->dataForm['AddTypesPages']);
            $addTypesPages = new \App\adms\Models\AdmsAddTypesPages();
            $addTypesPages->create($this->dataForm);
            if ($addTypesPages->getResult()) {
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddTypesPages();
            }
        } else {
            $this->viewAddTypesPages();
        }
    }

    /** Metodo para enviar os dados para a View e carregar os botões
     * Metodo privado, só pode ser chamado na classe
     */
    private function viewAddTypesPages() {
        $button = ['list_types_pages' => ['menu_controller' => 'list-types-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-types-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/typesPages/addTypesPages", $this->data);
        $loadView->renderizar();
    }

}
