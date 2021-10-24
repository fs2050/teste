<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditTypesPages Recebe as informações do tipo de página que serão editadas do banco de dados
 *
 * @author robson
 */
class EditTypesPages
{
    /** @var $data Recebe as informações que serão enviadas para a View*/
    private $data;
    
    /** @var $dataForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dataForm;
    
    /** @var $id Recebe a Id do tipo de página */
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id) {
        $this->id = (int) $id;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dataForm['EditTypesPages']))) {
            $viewTypesPages = new \App\adms\Models\AdmsEditTypesPages();
            $viewTypesPages->viewTypesPages($this->id);
            if ($viewTypesPages->getResult()) {
                $this->data['form'] = $viewTypesPages->getResultDb();
                $this->viewEditTypesPages();
            } else {
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editTypesPages();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões, enviar as informações para a View
     */
    private function viewEditTypesPages() {
        $button = ['list_types_pages' => ['menu_controller' => 'list-types-pages', 'menu_metodo' => 'index'],
            'view_types_pages' => ['menu_controller' => 'view-types-pages', 'menu_metodo' => 'index'],
            'delete_types_pages' => ['menu_controller' => 'delete-types-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-types-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/typesPages/editTypesPages", $this->data);
        $loadView->renderizar();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editTypesPages() {
        if (!empty($this->dataForm['EditTypesPages'])) {
            unset($this->dataForm['EditTypesPages']);
            $editTypesPages = new \App\adms\Models\AdmsEditTypesPages();
            $editTypesPages->update($this->dataForm);
            if ($editTypesPages->getResult()) {
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditTypesPages();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não encontrado!</div>";
            $urlRedirect = URLADM . "list-types-pages/index";
            header("Location: $urlRedirect");
        }
    }

}
