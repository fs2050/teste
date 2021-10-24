<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditSitsPages Recebe as informações da situação de página que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditSitsPages
{
    /** @var $data Recebe as informações que serão enviadas para a View*/
    private $data;
    
    /** @var $dataForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dataForm;
    
    /** @var $id Recebe a Id da situação de página */
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id) {
        $this->id = (int) $id;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dataForm['EditSitsPages']))) {
            $viewSitsPages = new \App\adms\Models\AdmsEditSitsPages();
            $viewSitsPages->viewSitsPages($this->id);
            if ($viewSitsPages->getResult()) {
                $this->data['form'] = $viewSitsPages->getResultDb();
                $this->viewEditSitsPages();
            } else {
                $urlRedirect = URLADM . "list-sits-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editSitsPages();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões, enviar as informações para a View e listar informações no dropdown do formulário
     */
    private function viewEditSitsPages() {
        $button = ['list_sits_pages' => ['menu_controller' => 'list-sits-pages', 'menu_metodo' => 'index'],
            'view_sits_pages' => ['menu_controller' => 'view-sits-pages', 'menu_metodo' => 'index'],
            'delete_sits_pages' => ['menu_controller' => 'delete-sits-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsEditSitsPages();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-sits-pages";

        $loadView = new \App\adms\core\ConfigView("adms/Views/sitsPages/editSitsPages", $this->data);
        $loadView->renderizar();
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editSitsPages() {
        if (!empty($this->dataForm['EditSitsPages'])) {
            unset($this->dataForm['EditSitsPages']);
            $editSitsPages = new \App\adms\Models\AdmsEditSitsPages();
            $editSitsPages->update($this->dataForm);
            if ($editSitsPages->getResult()) {
                $urlRedirect = URLADM . "list-sits-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditSitsPages();
            }
        } else {
            $_SESSION['msg'] = "Situação de página não encontrada!<br>";
            $urlRedirect = URLADM . "list-sits-pages/index";
            header("Location: $urlRedirect");
        }
    }

}
