<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditPageMenu
 *
 * @author Celke
 */
class EditPageMenu
{
    
    private $data;
    private $dataForm;
    private $id;
    private int $level;
    private int $pag;
    
    public function index() {
        $this->id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        $this->level = filter_input(INPUT_GET, "level", FILTER_SANITIZE_NUMBER_INT);
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dataForm['EditPageMenu']))) {
            $viewPageMenu = new \App\adms\Models\AdmsEditPageMenu();
            $viewPageMenu->viewPageMenu($this->id);
            if ($viewPageMenu->getResult()) {
                $this->data['form'] = $viewPageMenu->getResultDb();
                $this->viewEditPageMenu();
            } else {
                $urlRedirect = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editPageMenu();
        }
    }

    private function viewEditPageMenu() {
        $button = ['list_permission' => ['menu_controller' => 'list-permission', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $this->data['btnLevel'] = $this->level;
        $this->data['btnPag'] = $this->pag;

        $listSelect = new \App\adms\Models\AdmsEditPageMenu();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-access-levels";

        $loadView = new \App\adms\core\ConfigView("adms/Views/permission/editPageMenu", $this->data);
        $loadView->renderizar();
    }
    
    
    private function editPageMenu() {
        if (!empty($this->dataForm['EditPageMenu'])) {
            unset($this->dataForm['EditPageMenu']);
            $editPageMenu = new \App\adms\Models\AdmsEditPageMenu();
            $editPageMenu->update($this->dataForm);
            if ($editPageMenu->getResult()) {
                $urlRedirect = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditPageMenu();
            }
        } else {
            $_SESSION['msg'] = "Item de menu da página não encontrado!<br>";
            $urlRedirect = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
            header("Location: $urlRedirect");
        }
    }

}
