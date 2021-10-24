<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsNewUser Recebe as informações para cadastrar um novo usuário no sistema
 *
 * @author Celke
 */
class AdmsNewUser
{
    /** @var array $dados Recebe as informações que serão enviadas para a View */
    private array $dados;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var string $fromEmail Recebe o e-mail do administrador do sistema */
    private string $fromEmail;
    
    /** @var string $firstName Recebe o primeiro nome do usuário cadastrado no sistema */
    private string $firstName;
    
    /** @var array $emailData Recebe o conteudo do e-mail a ser enviado para o usuário */
    private array $emailData;
    
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado() {
        return $this->resultado;
    }

    /** Metodo para validar os dados do usuário que está se cadastrando no sistema
     * 
     * @param array $dados Recebe os dados do usuário
     */
    public function create(array $dados = null) {
        $this->dados = $dados;
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->valInput();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para validar campos especificos que devem ser unicos no banco de dados
     */
    private function valInput() {
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validarEmail($this->dados['email']);

        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validarEmailSingle($this->dados['email']);

        $valPassword = new \App\adms\Models\helper\AdmsValPassword();
        $valPassword->validarPassword($this->dados['password']);

        $valUserSingleLogin = new \App\adms\Models\helper\AdmsValUserSingleLogin();
        $valUserSingleLogin->validarUserSingleLogin($this->dados['email']);

        if ($valEmail->getResultado() AND $valEmailSingle->getResultado() AND $valPassword->getResultado() AND $valUserSingleLogin->getResultado()) {
            //$_SESSION['msg'] = "Usuário deve ser cadastrado!";
            //$this->resultado = false;
            $this->add();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para salvar os dados do novo usuário que foi cadastrado no banco de dados
     */
    private function add() {
        if ($this->accessLevel()) {

            $this->dados['password'] = password_hash($this->dados['password'], PASSWORD_DEFAULT);
            $this->dados['username'] = $this->dados['email'];
            $this->dados['conf_email'] = password_hash($this->dados['password'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);

            $this->dados['created'] = date("Y-m-d H:i:s");
            $createUser = new \App\adms\Models\helper\AdmsCreate();
            $createUser->exeCreate("adms_users", $this->dados);

            if ($createUser->getResult()) {
                //$_SESSION['msg'] = "Usuário cadastrado com sucesso!";
                //$this->resultado = true;
                $this->sendEmail();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso. Tente mais tarde!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para verificar o nível de acesso do novo usuário que foi cadastrado no sistema
     */
    private function accessLevel() {
        $accessLevel = new \App\adms\Models\helper\AdmsRead();
        $accessLevel->fullRead("SELECT adms_access_level_id FROM adms_levels_forms LIMIT :limit", "limit=1");
        $this->resultadoBd = $accessLevel->getResult();
        if ($this->resultadoBd) {
            $this->dados['adms_access_level_id'] = $this->resultadoBd[0]['adms_access_level_id'];
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso. Tente mais tarde!</div>";
            return false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar um e-mail de confirmação para o novo usuário que se cadastrou no sistema, para que o mesmo confirme o e-mail
     */
    private function sendEmail() {
        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();
        $this->emailHtml();
        $this->emailText();
        $sendEmail->sendEmail($this->emailData, 2);
        if ($sendEmail->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso. Acesse a sua caixa de e-mail para confimar o e-mail!</div>";
            $this->resultado = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Usuário cadastrado com sucesso. Houve erro ao enviar o e-mail de confirmação, entre em contado com " . $this->fromEmail . " para mais informações!</div>";
            $this->resultado = true;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo com o conteudo do e-mail com tags HTML
     */
    private function emailHtml() {
        $name = explode(" ", $this->dados['name']);
        $this->firstName = $name[0];

        $this->emailData['toEmail'] = $this->dados['email'];
        $this->emailData['toName'] = $this->firstName;
        $this->emailData['subject'] = "Confirmar sua conta";
        $url = URLADM . "conf-email/index?chave=" . $this->dados['conf_email'];

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastramento em nosso site!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='" . $url . "'>" . $url . "</a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo com o conteudo do e-mail apenas com o texto
     */
    private function emailText() {
        $url = URLADM . "conf-email/index?chave=" . $this->dados['conf_email'];
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastramento em nosso site!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo ou cole o link no navegador: \n\n";
        $this->emailData['contentText'] .= $url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";
    }

}
