<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsLogin Recebe as informações do login do usuário para que o usuário acesse o sistema
 *
 * @author Celke
 */
class AdmsLogin
{
    /** @var array $dados Recebe as informações que serão enviadas para a View */
    private array $dados;
    
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado() {
        return $this->resultado;
    }

    /** Metodo buscar as informações na tabela adms_users e verificar se o usuário está cadastrado no sistema
     * 
     * @param array $dados
     */
    public function login(array $dados = null) {
        $this->dados = $dados;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        //$viewUser->exeRead("adms_users", "WHERE user =:user LIMIT :limit", "user={$this->dados['user']}&limit=1");
        $viewUser->fullRead("SELECT usu.id, usu.name, usu.nickname, usu.email, usu.password, usu.adms_sits_user_id, usu.image,
                lev.id id_lev, lev.order_levels
                FROM adms_users usu
                INNER JOIN adms_access_levels AS lev ON lev.id=usu.adms_access_level_id
                WHERE usu.username =:username OR
                usu.email =:email
                LIMIT :limit",
                "username={$this->dados['username']}&email={$this->dados['username']}&limit=1");

        $this->resultadoBd = $viewUser->getResult();
        if ($this->resultadoBd) {
            $this->valEmailPerm();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para verificar a situação do usuário que esta tentando acessar o sistema
     */
    private function valEmailPerm() {
        if ($this->resultadoBd[0]['adms_sits_user_id'] == 3) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Necessário confirmar o e-mail, solicite novo e-mail <a href='" . URLADM . "new-conf-email/index'>clique aqui</a>!</div>";
            $this->resultado = false;
        } elseif ($this->resultadoBd[0]['adms_sits_user_id'] == 5) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail descadastrado, entre em contato com a empresa!</div>";
            $this->resultado = false;
        } elseif ($this->resultadoBd[0]['adms_sits_user_id'] == 2) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail inativo, entre em contato com a empresa!</div>>";
            $this->resultado = false;
        } else {
            $this->validarSenha();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para validar a senha e salvar dados principais na sessão
     */
    private function validarSenha() {
        if (password_verify($this->dados['password'], $this->resultadoBd[0]['password'])) {
            $_SESSION['user_id'] = $this->resultadoBd[0]['id'];
            $_SESSION['user_name'] = $this->resultadoBd[0]['name'];
            $_SESSION['user_nickname'] = $this->resultadoBd[0]['nickname'];
            $_SESSION['user_email'] = $this->resultadoBd[0]['email'];
            $_SESSION['user_image'] = $this->resultadoBd[0]['image'];
            $_SESSION['adms_access_level_id'] = $this->resultadoBd[0]['id_lev'];
            $_SESSION['order_levels'] = $this->resultadoBd[0]['order_levels'];
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário ou senha incorreta!</div>";
            $this->resultado = false;
        }
    }

}
