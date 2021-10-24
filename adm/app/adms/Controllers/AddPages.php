<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AddPages cadastra uma nova página no sistema
 *
 * @author Celke
 */
class AddPages
{
    /** @var $data Recebe as informações que estarão na Views*/
    private $data;
    
    /** @var $dataForm Recebe as informações que serão cadastradas no banco de dados através do formulário*/
    private $dataForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dataForm['AddPage'])) {
            unset($this->dataForm['AddPage']);
            $addPages = new \App\adms\Models\AdmsAddPages();
            $addPages->create($this->dataForm);
            if ($addPages->getResult()) {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddPages();
            }
        } else {
            $this->viewAddPages();
        }
    }

    /** Metodo para enviar os dados para a View, carregar os botões e listar opções no dropdown do formulário
     * Metodo privado, só pode ser chamado na classe
     */
    private function viewAddPages() {
        $button = ['list_pages' => ['menu_controller' => 'list-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsAddPages();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-pages";

        $loadView = new \App\adms\core\ConfigView("adms/Views/pages/addPages", $this->data);
        $loadView->renderizar();
    }

}
