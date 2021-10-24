<?php

namespace App\adms\core;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ConfigView
 *
 * @author Celke
 */
class ConfigView
{

    private string $nome;
    private $dados;

    public function __construct($nome, array $dados = null) {
        $this->nome = $nome;
        $this->dados = $dados;
    }

    public function renderizar() {
        if (file_exists('app/' . $this->nome . '.php')) {
            include 'app/adms/Views/include/head.php';
            include 'app/adms/Views/include/header.php';
            include 'app/adms/Views/include/start_content.php';
            include 'app/adms/Views/include/sidebar.php';
            include 'app/' . $this->nome . '.php';
            include 'app/adms/Views/include/end_content.php';
            include 'app/adms/Views/include/footer.php';
        } else {
            die("Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM . "!<br>");
            //echo "Erro ao carregar view: {$this->nome}<br>";
        }
    }

    public function renderizarLogin() {
        if (file_exists('app/' . $this->nome . '.php')) {
            include 'app/adms/Views/include/head_login.php';
            include 'app/' . $this->nome . '.php';
            include 'app/adms/Views/include/footer_login.php';
        } else {
            die("Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM . "!<br>");
            //echo "Erro ao carregar view: {$this->nome}<br>";
        }
    }

}
