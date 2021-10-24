<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsDeletePages recebe a informação que será deletada do banco de dados
 *
 * @author Celke
 */
class AdmsDeletePages
{
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Contem a Id da página que será deletada do sistema */
    private int $id;
    
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }
    
    /**
     * Método para fazer busca do Id na tabela adms_pages e validar o mesmo
     * @param array $id Recebe a informação que será validada e deletada do banco de dados */
    public function deletePages($id) {
        $this->id = (int) $id;

        if ($this->viewPages()) {
            $deletePage = new \App\adms\Models\helper\AdmsDelete();
            $deletePage->exeDelete("adms_pages", "WHERE id =:id", "id={$this->id}");

            if ($deletePage->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Página apagada com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não foi apagada com sucesso!</div>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se a página está cadastrada no sistema, caso esteja o resultado é enviado para o metodo deletePages
     */
    private function viewPages() {
        $viewPage = new \App\adms\Models\helper\AdmsRead();
        $viewPage->fullRead("SELECT id FROM adms_pages WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultDb = $viewPage->getResult();
        if ($this->resultDb) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não encontrada!</div>";
            return false;
        }
    }

}
