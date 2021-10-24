<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsValUserSingleLogin valida o usuario usado no login para que seja único
 *
 * @author Celke
 */
class AdmsValUserSingleLogin
{
    /** @var string $userName Recebe o nome de usuário*/
    private string $userName;
    
    /** @var bool $resultado Recebe o resultado */
    private bool $resultado;
    
    /** @var $resultadoBd Recebe o resultado das informações do banco de dados*/
    private $resultadoBd;

    /**
     * Recebe o resultado, verdadeiro ou falso
     * @return bool Verdadeiro ou falso
     */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Metodo recebe o usuário usado no login e faz a validação para que seja único
     * @param type $username Nome de usuario usado no login
     */
    public function validarUserSingleLogin($username) {
        $this->userName = $username;

        $valUserSingleLogin = new \App\adms\Models\helper\AdmsRead();
        $valUserSingleLogin->fullRead("SELECT id FROM adms_users WHERE username =:username LIMIT :limit", "username={$this->userName}&limit=1");

        $this->resultadoBd = $valUserSingleLogin->getResult();
        if (!$this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Este e-mail já está cadastrado!</div>";
            $this->resultado = false;
        }
    }

}
