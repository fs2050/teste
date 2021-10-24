<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}
/**
 * Classes do PHPMailer
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * A classe AdmsSendEmail faz o envio de e-mails
 *
 * @author Celke
 */
class AdmsSendEmail
{
    /** @var array $dados Recebe os dados que serão utilizados no e-mail*/
    private array $dados;
    
    /** @var array $dadosInfoEmail Recebe os dados do servidor do e-mail*/
    private array $dadosInfoEmail;
    
    /** @var array $resultadoBd Recebe o resultado que veio do banco de dados*/
    private array $resultadoBd;
    
    /** @var bool $resultado Recebe dos resultados que estão sendo manipulados*/
    private bool $resultado;
    
    /** @var string $fromEmail Recebe o e-mail do administrador*/
    private string $fromEmail;
    
    /** @var int $optionConfEmail Recebe o optionConfEmail*/
    private int $optionConfEmail;

    /**
     * Recebe o resultado verdadeiro ou falso
     * @return bool
     */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Recebe os dados do e-mail
     * @return string
     */
    function getFromEmail(): string {
        return $this->fromEmail;
    }

    /**
     * Metodo recebe os dados que serão usados no envio do e-mail
     * @param array $dados Recebe os dados
     * @param int $optionConfEmail
     */
    public function sendEmail($dados, $optionConfEmail) {
        $this->optionConfEmail = $optionConfEmail;
        $this->dados = $dados;
        $this->infoPhpMailer();
        $this->sendEmailPhpMailer();
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo recebe os dados de configuração de envio de e-mail
     */
    private function infoPhpMailer() {
        $confEmail = new \App\adms\Models\helper\AdmsRead();
        $confEmail->fullRead("SELECT name, email, host, username, password, smtpsecure, port FROM adms_confs_emails WHERE id =:id LIMIT :limit", "id={$this->optionConfEmail}&limit=1");
        $this->resultadoBd = $confEmail->getResult();
        
        $this->dadosInfoEmail['host'] = $this->resultadoBd[0]['host'];
        $this->dadosInfoEmail['fromEmail'] = $this->resultadoBd[0]['email'];
        $this->fromEmail = $this->dadosInfoEmail['fromEmail'];
        $this->dadosInfoEmail['fromName'] = $this->resultadoBd[0]['name'];
        $this->dadosInfoEmail['username'] = $this->resultadoBd[0]['username'];
        $this->dadosInfoEmail['password'] = $this->resultadoBd[0]['password'];
        $this->dadosInfoEmail['smtpsecure'] = $this->resultadoBd[0]['smtpsecure'];
        $this->dadosInfoEmail['port'] = $this->resultadoBd[0]['port'];
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo recebe os dados de configuração de envio de e-mail e o conteudo do e-mail
     */
    private function sendEmailPhpMailer() {
        $mail = new PHPMailer(true);
        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = $this->dadosInfoEmail['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->dadosInfoEmail['username'];
            $mail->Password = $this->dadosInfoEmail['password'];
            $mail->SMTPSecure = $this->dadosInfoEmail['smtpsecure'];
            $mail->Port = $this->dadosInfoEmail['port'];

            $mail->setFrom($this->dadosInfoEmail['fromEmail'], $this->dadosInfoEmail['fromName']);
            $mail->addAddress($this->dados['toEmail'], $this->dados['toName']);

            $mail->isHTML(true);
            $mail->Subject = $this->dados['subject'];
            $mail->Body = $this->dados['contentHtml'];
            $mail->AltBody = $this->dados['contentText'];

            $mail->send();
            $this->resultado = true;
        } catch (Exception $ex) {
            $this->resultado = false;
        }
    }

}
