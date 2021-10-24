<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe ConfEmail recebe a chave de confirmação do e-mail que foi enviada para o usuário
 *
 * @author Celke
 */
class ConfEmail
{
    /** @var $chave Recebe a informação que estará na Views*/
    private $chave;

    /** Metodo para receber os dados da View e chamar o metodo privado para validar a chave*/
    public function index() {
        $this->chave = filter_input(INPUT_GET, "chave", FILTER_DEFAULT);

        if (!empty($this->chave)) {
            $this->validarChave();
        } else {
            $_SESSION['msg'] = "Erro: Link inválido!";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe 
     * Metodo validar a chave e enviar a informação para a Models*/
    private function validarChave() {
        $confEmail = new \App\adms\Models\AdmsConfEmail();
        $confEmail->confEmail($this->chave);
        if ($confEmail->getResultado()) {
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        } else {
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

}
