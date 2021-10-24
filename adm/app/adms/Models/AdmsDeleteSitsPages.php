<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsDeleteSitsPages recebe a informação que será deletada do banco de dados
 *
 * @author Celke
 */
class AdmsDeleteSitsPages
{
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Contem a Id da situação de página que será deletada do sistema */
    private int $id;
    
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }
    
    /**
     * Método para fazer busca do Id na tabela adms_sits_pgs e validar o mesmo
     * @param array $id Recebe a informação que será validada e deletada do banco de dados */
    public function deleteSitsPages($id) {
        $this->id = (int) $id;

        if ($this->viewSitsPages() AND $this->verfPageAdded()) {
            $deleteSitsPages = new \App\adms\Models\helper\AdmsDelete();
            $deleteSitsPages->exeDelete("adms_sits_pgs", "WHERE id =:id", "id={$this->id}");

            if ($deleteSitsPages->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação de página apagada com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação de página não apagada com sucesso!</div>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se a situação de página está cadastrada no sistema, caso esteja o resultado é enviado para o metodo deleteSitsPages
     */
    private function viewSitsPages() {
        $viewSitsPages = new \App\adms\Models\helper\AdmsRead();
        $viewSitsPages->fullRead("SELECT id FROM adms_sits_pgs
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultDb = $viewSitsPages->getResult();
        if ($this->resultDb) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação de página não encontrada!</div>";
            return false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se tem alguma página cadastrada no sistema usando a situação de página a ser deletada, caso esteja, o resultado é enviado para o metodo deleteSitsPages e a exclusão não é permitida
     */
    private function verfPageAdded() {
        $viewPageAdded = new \App\adms\Models\helper\AdmsRead();
        $viewPageAdded->fullRead("SELECT id FROM adms_pages WHERE adms_sits_pgs_id=:adms_sits_pgs_id LIMIT :limit", "adms_sits_pgs_id={$this->id}&limit=1");
        if($viewPageAdded->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação de página não pode ser apagada, há páginas cadastradas com essa situação!</div>";
            return false;
        }else{
            return true;
        }
    }

}
