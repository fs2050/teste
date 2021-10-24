<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsValEmailSingle faz a validação do e-mail que deve ser unico
 *
 * @author Celke
 */
class AdmsValEmailSingle
{
    /** @var string $email Recebe o e-mail*/
    private string $email;
    
    /** @var $edit Recebe a verificação true*/
    private $edit;
    
    /** @var $id Recebe o ID do e-mail*/
    private $id;
    
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
     * Metodo recebe o e-mail, edit e o id e verifica se o e-mail é único
     * @param string $email
     * @param type $edit
     * @param type $id
     */
    public function validarEmailSingle($email, $edit = null, $id = null) {
        $this->email = $email;
        $this->edit = $edit;
        $this->id = $id;

        $valEmailSingle = new \App\adms\Models\helper\AdmsRead();
        if (($this->edit == true) AND (!empty($this->id))) {
            $valEmailSingle->fullRead("SELECT id
                    FROM adms_users
                    WHERE (email =:email OR username =:username) AND
                    id <>:id
                    LIMIT :limit", "email={$this->email}&username={$this->email}&id={$this->id}&limit=1");
        } else {
            $valEmailSingle->fullRead("SELECT id FROM adms_users WHERE email =:email LIMIT :limit", "email={$this->email}&limit=1");
        }

        $this->resultadoBd = $valEmailSingle->getResult();
        if (!$this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Este e-mail já está cadastrado!</div>";
            $this->resultado = false;
        }
    }

}
