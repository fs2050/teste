<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe Login Recebe as informações do login do usuário para que o usuário acesse o sistema
 *
 * @author Celke
 */
class Login
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações que serão usadas no formulário */
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->dadosForm['SendLogin'])) {
            $valLogin= new \App\adms\Models\AdmsLogin();
            $valLogin->login($this->dadosForm);
            if($valLogin->getResultado()){
                $urlDestino = URLADM . "dashboard/index";
                header("Location: $urlDestino");
            }else{
                $this->dados['form'] = $this->dadosForm;
            }            
        }

        //$this->dados = [];

        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/access", $this->dados);
        $carregarView->renderizarLogin();
    }

}
