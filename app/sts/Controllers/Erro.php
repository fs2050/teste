<?php

namespace App\sts\Controllers;

if (!defined('48b5t9')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
/**
 * Controller da página Erro
 *
 * @author Celke
 */
class Erro
{
    /** @var array $dados Recebe os dados que devem ser enviados para VIEW */
    private array $dados;

    /**
     * Instantiar a classe responsável em carregar a View
     * 
     * @return void
     */
    public function index(): void {
        $this->dados = [];
        $carregarView = new \Core\ConfigView("sts/Views/erro/erro", $this->dados);
        $carregarView->renderizar();
    }
}
