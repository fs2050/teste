<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditPerfil Recebe as informações do perfil do usuário que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditPerfil
{
    /** @var $dadosForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dadosForm;
    
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['EditPerfil'])) {
            $this->editPerfil();
        } else {
            $viewPerfil = new \App\adms\Models\AdmsEditPerfil();
            $viewPerfil->viewPerfil();
            if ($viewPerfil->getResultado()) {
                $this->dados['form'] = $viewPerfil->getResultadoBd();
                $this->viewEditPerfil();
            } else {
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            }
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões, enviar as informações para a View
     */
    private function viewEditPerfil() {
        $button = ['view_perfil' => ['menu_controller' => 'view-perfil', 'menu_metodo' => 'index'],
            'edit_perfil_password' => ['menu_controller' => 'edit-perfil-password', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-perfil";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editPerfil", $this->dados);
        $carregarView->renderizar();
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter as informações no formulário e enviar para a Models para que a edição seja feita
     */
    private function editPerfil() {
        if (!empty($this->dadosForm['EditPerfil'])) {
            unset($this->dadosForm['EditPerfil']);
            $editPerfil = new \App\adms\Models\AdmsEditPerfil();
            $editPerfil->update($this->dadosForm);
            if ($editPerfil->getResultado()) {
                $urlDestino = URLADM . "view-perfil/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditPerfil();
            }
        } else {
            $_SESSION['msg'] = "Erro: Usuário não encontrado!<br>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

}
