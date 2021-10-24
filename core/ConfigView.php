<?php

namespace Core;

if (!defined('48b5t9')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Carregar as páginas da View
 *
 * @author Celke
 */
class ConfigView
{
    /** @var string $nome Recebe o endereço da VIEW que deve ser carregada */
    private string $nome;
    /** @var array $dados Recebe os dados que a VIEW deve receber */
    private $dados;
    
    /**
     * Receber o endereço da VIEW e os dados.
     * @param string $nome Endereço da VIEW que deve ser carregada
     * @param array $dados Dados que a VIEW deve receber.
     */
    public function __construct($nome, $dados) {
        $this->nome = $nome;
        $this->dados = $dados;
    }
    
    /**
     * Carregar a VIEW.
     * Verificar se o arquivo existe, e carregar caso exista, não existindo para o carregamento
     * 
     * @return void
     */
    public function renderizar(): void {
        if(file_exists('app/' . $this->nome . '.php')){
            include 'app/sts/Views/include/head.php';
            include 'app/sts/Views/include/menu.php';
            include 'app/' . $this->nome . '.php';
            include 'app/sts/Views/include/footer.php';
            include 'app/sts/Views/include/libraries_js.php';
        }else{
            echo "Página não encontrada: {$this->nome}<br>";
            die("Página não encontrada!");
        }        
    }
}
