<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AddSitsPages cadastra uma situação de página no sistema
 *
 * @author Celke
 */
class AddSitsPages
{
    /** @var $data Recebe as informações que estarão na Views*/
    private $data;
    
    /** @var $dataForm Recebe as informações que serão cadastradas no banco de dados através do formulário*/
    private $dataForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dataForm['AddSitsPages'])) {
            unset($this->dataForm['AddSitsPages']);
            $addSitsPages = new \App\adms\Models\AdmsAddSitsPages();
            $addSitsPages->create($this->dataForm);
            if ($addSitsPages->getResult()) {
                $urlRedirect = URLADM . "list-sits-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddSitsPages();
            }
        } else {
            $this->viewAddSitsPages();
        }
    }

    /** Metodo para enviar os dados para a View, carregar os botões e listar opções no dropdown do formulário
     * Metodo privado, só pode ser chamado na classe
     */
    private function viewAddSitsPages() {
        $button = ['list_sits_pages' => ['menu_controller' => 'list-sits-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $listSelect = new \App\adms\Models\AdmsAddSitsPages();
        $this->data['select'] = $listSelect->listSelect();
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-sits-pages";

        $loadView = new \App\adms\core\ConfigView("adms/Views/sitsPages/addSitsPages", $this->data);
        $loadView->renderizar();
    }

}
