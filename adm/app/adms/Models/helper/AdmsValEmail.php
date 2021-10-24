<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsValEmail faz a validação do e-mail
 *
 * @author Celke
 */
class AdmsValEmail
{
    /** @var string $email Recebe o e-mail*/
    private string $email;
    
    /** @var bool $resultado Recebe o resultado*/
    private bool $resultado;

    /**
     * Recebe o resultado, verdadeiro ou falso
     * @return bool Verdadeiro ou falso
     */
    function getResultado(): bool {
        return $this->resultado;
    }
    
    /**
     * Metodo recebe o e-mail e verifica se é válido
     * @param string $email Recebe o e-mail
     */
    public function validarEmail($email) {
        $this->email = $email;
        
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail inválido!</div>";
            $this->resultado = false;            
        }
    }
}
