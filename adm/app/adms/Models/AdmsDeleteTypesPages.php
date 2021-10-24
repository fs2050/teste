<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsDeleteTypesPages recebe a informação que será deletada do banco de dados
 *
 * @author robson
 */
class AdmsDeleteTypesPages
{
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Contem a Id da situação de usuário que será deletada do sistema */
    private int $id;
    
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }
    
    /**
     * Método para fazer busca do Id na tabela adms_types_pgss e validar o mesmo
     * @param array $id Recebe a informação que será validada e deletada do banco de dados */
    public function deleteTypesPages($id) {
        $this->id = (int) $id;
        if ($this->viewTypesPages() AND $this->verifyAddedPackage()) {
            $deleteTypesPages = new \App\adms\Models\helper\AdmsDelete();
            $deleteTypesPages->exeDelete("adms_types_pgs", "WHERE id =:id", "id={$this->id}");
            if ($deleteTypesPages->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Tipo de página apagado com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não apagado com sucesso!</div>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se o tipo de página está cadastrado no sistema, caso esteja, o resultado é enviado para o metodo deleteTypesPages
     */
    private function viewTypesPages() {
        $viewTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPages->fullRead("SELECT id FROM adms_types_pgs
                    WHERE id=:id
                    LIMIT :limit", "id={$this->id}&limit=1");
        $this->resultDb = $viewTypesPages->getResult();
        if ($this->resultDb) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não encontrado!</div>";
            return false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se tem páginas cadastradas no sistema usando o tipo de página a ser deletado, caso tenha, o resultado é enviado para o metodo deleteTypesPages e a exclusão não é permitida
     */
    private function verifyAddedPackage() {
        $verifyAddedPackage = new \App\adms\Models\helper\AdmsRead();
        $verifyAddedPackage->fullRead("SELECT id FROM adms_pages WHERE adms_types_pgs_id=:adms_types_pgs_id LIMIT :limit", "adms_types_pgs_id={$this->id}&limit=1");
        if ($verifyAddedPackage->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: O tipo de página não pode ser apagado, há páginas cadastradas nesse pacote!</div>";
            return false;
        } else {
            return true;
        }
    }

}
