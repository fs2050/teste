<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsDeleteGroupsPages recebe a informação que será deletada do banco de dados
 *
 * @author robson
 */
class AdmsDeleteGroupsPages
{
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Contem a Id do grupo de página que será deletado do sistema */
    private int $id;
    
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }
    
    /**
     * Método para fazer busca do Id na tabela adms_groups_pgs e validar o mesmo
     * @param array $id Recebe a informação que será validada e deletada do banco de dados */
    public function deleteGroupsPages($id) {
        $this->id = (int) $id;
        if ($this->viewGroupsPages() AND $this->verifyAddedPackage()) {
            $deleteGroupsPages = new \App\adms\Models\helper\AdmsDelete();
            $deleteGroupsPages->exeDelete("adms_groups_pgs", "WHERE id =:id", "id={$this->id}");
            if ($deleteGroupsPages->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Grupo de página apagado com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Grupo de página não apagado com sucesso!</div>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se o grupo de página está cadastrado no sistema, caso esteja o resultado é enviado para o metodo deleteGroupsPages
     */
    private function viewGroupsPages() {
        $viewGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $viewGroupsPages->fullRead("SELECT id FROM adms_groups_pgs
                    WHERE id=:id
                    LIMIT :limit", "id={$this->id}&limit=1");
        $this->resultDb = $viewGroupsPages->getResult();
        if ($this->resultDb) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Grupo de página não encontrado!</div>";
            return false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se tem pacotes (Ex: sts, adms, cpadms) cadastrados usando o grupo de página a ser deletado, caso tenha, a exclusão não é permitida
     */
    private function verifyAddedPackage() {
        $verifyAddedPackage = new \App\adms\Models\helper\AdmsRead();
        $verifyAddedPackage->fullRead("SELECT id FROM adms_pages WHERE adms_groups_pgs_id=:adms_groups_pgs_id LIMIT :limit", "adms_groups_pgs_id={$this->id}&limit=1");
        if ($verifyAddedPackage->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: O grupo de página não pode ser apagado, há páginas cadastradas com esse grupo!</div>";
            return false;
        } else {
            return true;
        }
    }

}
