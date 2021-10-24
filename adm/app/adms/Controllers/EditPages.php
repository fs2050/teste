<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditPages Recebe as informações que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditPages
{
    /** @var $data Recebe as informações que serão enviadas para a View*/
    private $data;
    
    /** @var $dataForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dataForm;
    
    /** @var $id Recebe o ID da página que será editada*/
    private $id;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index($id) {
        $this->id = (int) $id;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dataForm['EditPage']))) {
            $viewPage = new \App\adms\Models\AdmsEditPages();
            $viewPage->viewPage($this->id);
            if ($viewPage->getResult()) {
                $this->data['form'] = $viewPage->getResultDb();
                $this->viewEditPage();
            } else {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editPage();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões, enviar as informações para a View e enviar informações que serão usadas no dropdown do formulário
     */
    private function viewEditPage() {
        $button = ['list_pages' => ['menu_controller' => 'list-pages', 'menu_metodo' => 'index'],
            'view_pages' => ['menu_controller' => 'view-pages', 'menu_metodo' => 'index'],
            'delete_pages' => ['menu_controller' => 'delete-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $listSelect = new \App\adms\Models\AdmsEditPages();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-pages";

        $loadView = new \App\adms\core\ConfigView("adms/Views/pages/editPages", $this->data);
        $loadView->renderizar();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editPage() {
        if (!empty($this->dataForm['EditPage'])) {
            unset($this->dataForm['EditPage']);
            $editPage = new \App\adms\Models\AdmsEditPages();
            $editPage->update($this->dataForm);
            if ($editPage->getResult()) {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditPage();
            }
        } else {
            $_SESSION['msg'] = "Página não encontrado!<br>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
    }

}
