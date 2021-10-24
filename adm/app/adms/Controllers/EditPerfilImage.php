<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditPerfilImage Recebe as informações da imagem do perfil do usuário que serão editadas do banco de dados
 *
 * @author Celke
 */
class EditPerfilImage
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações do formulário que serão enviadas para a Models*/
    private $dadosForm;
    
    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['EditPerfilImagem'])) {
            $this->editPerfilImage();
        } else {
            $viewPerfil = new \App\adms\Models\AdmsEditPerfilImage();
            $viewPerfil->viewPerfil();
            if ($viewPerfil->getResultado()) {
                $this->dados['form'] = $viewPerfil->getResultadoBd();
                $this->viewEditPerfilImage();
            } else {
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            }
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para carregar os botões, enviar as informações para a View
     */
    private function viewEditPerfilImage() {
        $button = ['view_perfil' => ['menu_controller' => 'view-perfil', 'menu_metodo' => 'index'],
            'edit_perfil' => ['menu_controller' => 'edit-perfil', 'menu_metodo' => 'index'],
            'edit_perfil_password' => ['menu_controller' => 'edit-perfil-password', 'menu_metodo' => 'index']];
        $listButton = new \App\adms\Models\helper\AdmsButton();
        $this->dados['button'] = $listButton->buttonPermission($button);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->dados['menu'] = $listMenu->itemMenu();
        $this->dados['sidebarActive'] = "view-perfil";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editPerfilImage", $this->dados);
        $carregarView->renderizar();
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para manter a imagem no formulário e enviar para a Models para que a edição seja feita
     */
    private function editPerfilImage() {
        if (!empty($this->dadosForm['EditPerfilImagem'])) {
            unset($this->dadosForm['EditPerfilImagem']);
            $this->dadosForm['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            $editPerfil = new \App\adms\Models\AdmsEditPerfilImage();
            $editPerfil->update($this->dadosForm);
            if ($editPerfil->getResultado()) {
                $urlDestino = URLADM . "view-perfil/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditPerfilImage();
            }
        } else {
            $_SESSION['msg'] = "Erro: Usuário não encontrado!<br>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

}
