<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe RecoverPassword Recebe as informações para o usuário recuperar a senha
 *
 * @author Celke
 */
class RecoverPassword
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações que serão usadas no formulário*/
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['RecoverPassword'])) {
            unset($this->dadosForm['RecoverPassword']);
            $recoverPassword= new \App\adms\Models\AdmsRecoverPassword();
            $recoverPassword->recoverPassword($this->dadosForm);
            if($recoverPassword->getResultado()){
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            }else{
                $this->dados['form'] = $this->dadosForm;
                $this->viewRecoverPass();
            }            
        }else{
            $this->viewRecoverPass();
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo para carregar a View
     */
    private function viewRecoverPass() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/recoverPassword", $this->dados);
        $carregarView->renderizarLogin();
    }

}
