<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe NewConfEmail Recebe as informações para enviar um e-mail quando um novo usuário se cadastra no sistema
 *
 * @author Celke
 */
class NewConfEmail
{
    /** @var $dados Recebe as informações que serão enviadas para a View*/
    private $dados;
    
    /** @var $dadosForm Recebe as informações que serão usadas no formulário */
    private $dadosForm;

    /** Metodo para receber os dados da View e enviar para Models */
    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['NewConfEmail'])) {
            unset($this->dadosForm['NewConfEmail']);
            $newConfEmail= new \App\adms\Models\AdmsNewConfEmail();
            $newConfEmail->newConfEmail($this->dadosForm);
            if($newConfEmail->getResultado()){
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            }else{
                $this->dados['form'] = $this->dadosForm;
                $this->viewNewConfEmail();
            }            
        }else{
            $this->viewNewConfEmail();
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo para carregar a view
     */
    private function viewNewConfEmail() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/newConfEmail", $this->dados);
        $carregarView->renderizarLogin();
    }

}
