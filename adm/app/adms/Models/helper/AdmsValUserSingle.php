<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsValUserSingle valida o usuario que deve ser único
 *
 * @author Celke
 */
class AdmsValUserSingle
{
    /** @var string $userName  Recebe o username*/
    private string $userName;
    
    /** @var $edit Recebe a verificação true*/
    private $edit;
    
    /** @var $id Recebe o ID do username*/
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
     * Metodo recebe o username, edit e o id
     * @param type $username
     * @param type $edit
     * @param type $id
     */
    public function validarUserSingle($username, $edit = null, $id = null) {
        $this->userName = $username;
        $this->edit = $edit;
        $this->id = $id;

        $valUserSingle = new \App\adms\Models\helper\AdmsRead();
        if (($this->edit == true) AND (!empty($this->id))) {
            $valUserSingle->fullRead("SELECT id
                    FROM adms_users
                    WHERE (username =:username OR email =:email) AND
                    id <>:id
                    LIMIT :limit",
                    "username={$this->userName}&email={$this->userName}&id={$this->id}&limit=1");
        } else {
            $valUserSingle->fullRead("SELECT id FROM adms_users WHERE username =:username LIMIT :limit", "username={$this->userName}&limit=1");
        }

        $this->resultadoBd = $valUserSingle->getResult();
        if (!$this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Este usuário já está cadastrado!</div>";
            $this->resultado = false;
        }
    }

}
