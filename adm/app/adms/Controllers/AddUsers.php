<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AddUsers recebe as informações que serão enviadas para o banco de dados
 *
 * @author Celke
 */
class AddUsers
{
    /** @var $dados Recebe as informações que estarão na Views*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações que serão cadastradas no banco de dados através do formulário*/
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddUser'])) {
            unset($this->dadosForm['AddUser']);
            $addUser = new \App\adms\Models\AdmsAddUsers();
            $addUser->create($this->dadosForm);
            if ($addUser->getResultado()) {
                $urlDestino = URLADM . "list-users/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddUser();
            }
        } else {
            $this->viewAddUser();
        }
    }

    /** Metodo para enviar os dados para a View, carregar os botões e listar informações que serão usadas no dropdown
     * Metodo privado, só pode ser chamado na classe
     */
    private function viewAddUser() {
        $button = ['list_users' => ['menu_controller' => 'list-users', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);
        
        $listSelect = new \App\adms\Models\AdmsAddUsers();
        $this->dados['select'] = $listSelect->listSelect();
        
        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "list-users";

        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/addUser", $this->dados);
        $carregarView->renderizar();
    }

}
