<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditGroupsPages Recebe as informações que serão editadas do banco de dados
 *
 * @author robson
 */
class EditGroupsPages
{
    /** @var $data Recebe as informações que serão enviadas para a View*/
    private $data;
    
    /** @var $dataForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dataForm;
    
    /** @var $id Recebe o ID do grupo de página que será editada*/
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id) {
        $this->id = (int) $id;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dataForm['EditGroupsPages']))) {
            $viewGroupsPages = new \App\adms\Models\AdmsEditGroupsPages();
            $viewGroupsPages->viewGroupsPages($this->id);
            if ($viewGroupsPages->getResult()) {
                $this->data['form'] = $viewGroupsPages->getResultDb();
                $this->viewEditGroupsPages();
            } else {
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editGroupsPages();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões e enviar as informações para a View
     */
    private function viewEditGroupsPages() {
        $button = ['list_groups_pages' => ['menu_controller' => 'list-groups-pages', 'menu_metodo' => 'index'],
            'view_groups_pages' => ['menu_controller' => 'view-groups-pages', 'menu_metodo' => 'index'],
            'delete_groups_pages' => ['menu_controller' => 'delete-groups-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-groups-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/groupsPages/editGroupsPages", $this->data);
        $loadView->renderizar();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editGroupsPages() {
        if (!empty($this->dataForm['EditGroupsPages'])) {
            unset($this->dataForm['EditGroupsPages']);
            $editGroupsPages = new \App\adms\Models\AdmsEditGroupsPages();
            $editGroupsPages->update($this->dataForm);
            if ($editGroupsPages->getResult()) {
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditGroupsPages();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Grupo de página não encontrado!</div>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
    }

}
