<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe UpdatePassword Recebe as informações para atualizar a senha do usuário
 *
 * @author Celke
 */
class UpdatePassword
{
    /** @var $chave Recebe a chave para que a senha seja atualizada */
    private $chave;
    
    /** @var $dadosForm Recebe os dados que serão usados no formulário */
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {
        $this->chave = filter_input(INPUT_GET, "chave", FILTER_DEFAULT);
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->chave) AND empty($this->dadosForm['UpPassword'])) {
            $this->validarChave();
        } else {
            $this->updatePasword();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para validar a chave para atualizar a senha
     */
    private function validarChave() {
        $valChave = new \App\adms\Models\AdmsUpdatePassword();
        $valChave->validarChave($this->chave);
        if ($valChave->getResultado()) {
            $this->viewUpdatePassword();
        } else {
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para manter os dados no formulário e enviar as informações para o banco de dados
     */
    private function updatePasword() {
        if (!empty($this->dadosForm['UpPassword'])) {
            unset($this->dadosForm['UpPassword']);
            $this->dadosForm['chave'] = $this->chave;
            $upPassword = new \App\adms\Models\AdmsUpdatePassword();
            $upPassword->editPassword($this->dadosForm);
            if ($upPassword->getResultado()) {
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            } else {
                $this->viewUpdatePassword();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido, solicite novo link<a href='" . URLADM . "recover-password/index'>clique aqui!</div>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para carregar a View para atualizar a senha
     */
    private function viewUpdatePassword() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/updatePassword");
        $carregarView->renderizarLogin();
    }

}
