<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AddGroupsPages cadastra um grupo de página no sistema
 *
 * @author robson
 */
class AddGroupsPages
{
    /** @var $data Recebe as informações que estarão na Views*/
    private $data;
    
    /** @var $dataForm Recebe as informações que serão cadastradas no banco de dados através do formulário*/
    private $dataForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dataForm['AddGroupsPages'])) {
            unset($this->dataForm['AddGroupsPages']);
            $addGroupsPages = new \App\adms\Models\AdmsAddGroupsPages();
            $addGroupsPages->create($this->dataForm);
            if ($addGroupsPages->getResult()) {
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddGroupsPages();
            }
        } else {
            $this->viewAddGroupsPages();
        }
    }
    
    /** Metodo para enviar os dados para a View e carregar os botões
     * Metodo privado, só pode ser chamado na classe
     */
    private function viewAddGroupsPages() {
        $button = ['list_groups_pages' => ['menu_controller' => 'list-groups-pages', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listButton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-groups-pages";
        $loadView = new \App\adms\core\ConfigView("adms/Views/groupsPages/addGroupsPages", $this->data);
        $loadView->renderizar();
    }

}
