<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsValPassword valida a senha
 *
 * @author Celke
 */
class AdmsValPassword
{
    /** @var string $password Recebe a senha*/
    private string $password;
    
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
     * Metodo valida a senha, verifica se tem caracteres invalidos
     * @param string $password
     */
    public function validarPassword($password) {
        $this->password = (string) $password;

        if (stristr($this->password, "'")) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado na senha inválido!</div>";
            $this->resultado = false;
        } else {
            if (stristr($this->password, " ")) {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no campo senha!</div>";
                $this->resultado = false;
            } else {
                $this->valExtensPassword();
            }
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo valida a extensão da senha, verifica a quantidade de caracteres
     */
    private function valExtensPassword() {
        if ((strlen($this->password) < 6)) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter no mínimo 6 caracteres!</div>";
            $this->resultado = false;
        } else {
            $this->valValuePassword();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo valida os valores da senha, verifica se a senha tem letras e números
     */
    private function valValuePassword() {
        if (preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]{6,}$/', $this->password)) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter letras e números!</div>";
            $this->resultado = false;
        }
    }

}
