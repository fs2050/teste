<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsNewConfEmail Recebe as informações para enviar um e-mail quando um novo usuário se cadastra no sistema
 *
 * @author Celke
 */
class AdmsNewConfEmail
{
    /** @var array $dados Recebe as informações que serão enviadas para a View */
    private array $dados;
    
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var string $firstName Recebe o primeiro nome do usuário que se cadastrar no sistema */
    private string $firstName;
    
    /** @var array $emailData Recebe o conteudo do e-mail a ser enviado para o usuário */
    private array $emailData;
    
    /** @var array $saveData Recebe as informações que serão salvas no banco de dados*/
    private array $saveData;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado() {
        return $this->resultado;
    }

    /** Metodo recebe os dados e faz a validação
     * 
     * @param array $dados Recebe os dados do usuário
     */
    public function newConfEmail(array $dados = null) {
        $this->dados = $dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->valUser();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para verificar o usuário que foi cadastrado no sistema e instanciar o metodo para que seja enviado o e-mail de confirmação
     */
    private function valUser() {
        $newConfEmail = new \App\adms\Models\helper\AdmsRead();
        $newConfEmail->fullRead("SELECT id, name, email, conf_email
                FROM adms_users
                WHERE email =:email
                LIMIT :limit",
                "email={$this->dados['email']}&limit=1");

        $this->resultadoBd = $newConfEmail->getResult();
        if ($this->resultadoBd) {
            if ($this->valConfEmail()) {
                $this->sendEmail();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link não enviado, tente novamente!</div>";
                $this->resultado = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não cadastrado!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para salvar a confirmação do e-mail no banco de dados
     */
    private function valConfEmail() {
        if (empty($this->resultadoBd[0]['conf_email']) OR $this->resultadoBd[0]['conf_email'] == NULL) {

            $this->saveData['conf_email'] = password_hash(date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
            $this->saveData['modified'] = date("Y-m-d H:i:s");
            
            $up_conf_email = new \App\adms\Models\helper\AdmsUpdate();
            $up_conf_email->exeUpdate("adms_users", $this->saveData, "WHERE id=:id", "id={$this->resultadoBd[0]['id']}");
            
            if ($up_conf_email->getResult()) {
                $this->resultadoBd[0]['conf_email'] = $this->saveData['conf_email'];
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para instanciar os metodos para enviar o e-mail com tags HTML e apenas texto
     */
    private function sendEmail() {
        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();
        $this->emailHtml();
        $this->emailText();
        $sendEmail->sendEmail($this->emailData, 2);
        if ($sendEmail->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Novo link enviado com sucesso. Acesse a sua caixa de e-mail para confimar o e-mail!</div>";
            $this->resultado = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link não enviado, tente novamente ou entre em contato com o e-mail {$this->fromEmail}!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar o e-mail com tags em HTML
     */
    private function emailHtml() {
        $name = explode(" ", $this->resultadoBd[0]['name']);
        $this->firstName = $name[0];

        $this->emailData['toEmail'] = $this->resultadoBd[0]['email'];
        $this->emailData['toName'] = $this->firstName;
        $this->emailData['subject'] = "Confirmar sua conta";
        $url = URLADM . "conf-email/index?chave=" . $this->resultadoBd[0]['conf_email'];

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastramento em nosso site!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='" . $url . "'>" . $url . "</a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para enviar o e-mail apenas com o texto
     */
    private function emailText() {
        $url = URLADM . "conf-email/index?chave=" . $this->resultadoBd[0]['conf_email'];
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastramento em nosso site!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo ou cole o link no navegador: \n\n";
        $this->emailData['contentText'] .= $url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";
    }

}
