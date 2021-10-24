<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe NewUser Recebe as informações para cadastrar um novo usuário no sistema
 *
 * @author Celke
 */
class NewUser
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações que serão usadas no formulário */
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {
        
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(!empty($this->dadosForm['SendNewUser'])){
            unset($this->dadosForm['SendNewUser']);
            $createNewUser = new \App\adms\Models\AdmsNewUser();
            $createNewUser->create($this->dadosForm);
            if($createNewUser->getResultado()){
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            }else{
                $this->dados['form'] = $this->dadosForm;
                $this->viewNewUser();
            }            
        }else{
            $this->viewNewUser();
        }   
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo para carregar a view
     */
    private function viewNewUser() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/newUser", $this->dados);
        $carregarView->renderizarLogin();
    }

}
