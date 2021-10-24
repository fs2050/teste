<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsSyncPagesLevels Tem a função de sincronizar as permissões das páginas para todos os níveis de acesso
 *
 * @author Celke
 */
class AdmsSyncPagesLevels
{

    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;

    /** @var $listLevels Recebe a lista dos níveis de acesso */
    private $listLevels;

    /** @var $listPages Recebe a lista das páginas */
    private $listPages;

    /** @var int $levelId Recebe o Id do nível de acesso */
    private int $levelId;

    /** @var int $pageId Recebe o Id da página */
    private int $pageId;

    /** @var int $publish Recebe o Id da página publica */
    private int $publish;

    /** @var $listLevelPage Recebe a lista das páginas com os niveis de acesso cadastrados */
    private $listLevelPage;

    /** @var $dataLevelPage Recebe as informações que serão salvas no banco de dados */
    private $dataLevelPage;

    /** @var $viewLastOrder Recebe a ultima ordem */
    private $viewLastOrder;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Metodo listar os niveis de acesso na tabela adms_access_levels
     */
    public function syncPagesLevels() {
        $listLevels = new \App\adms\Models\helper\AdmsRead();
        $listLevels->fullRead("SELECT id FROM adms_access_levels");
        $this->listLevels = $listLevels->getResult();
        if ($this->listLevels) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Permissões sincronizadas com sucesso!</div>";
            $this->listPages();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum nível de acesso encontrado!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para listar as páginas do sistema
     */
    private function listPages() {
        $listPages = new \App\adms\Models\helper\AdmsRead();
        $listPages->fullRead("SELECT id, publish FROM adms_pages");
        $this->listPages = $listPages->getResult();
        if ($this->listPages) {
            $this->readLevels();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhuma página encontrada!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para ler os níveis de acesso e instanciar o metodo readPages
     */
    private function readLevels() {
        foreach ($this->listLevels as $level) {
            extract($level);
            $this->levelId = $id;
            $this->readPages();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para ler as paǵinas do sistema e instanciar o metodo searchLevelPage
     */
    private function readPages() {
        foreach ($this->listPages as $page) {
            extract($page);
            $this->pageId = $id;
            $this->publish = $publish;
            $this->searchLevelPage();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para verificar as permissões das páginas e instanciar o metodo addLevelPermission 
     */
    private function searchLevelPage() {
        $listLevelPage = new \App\adms\Models\helper\AdmsRead();
        $listLevelPage->fullRead("SELECT id FROM adms_levels_pages
                WHERE adms_access_level_id =:adms_access_level_id 
                AND adms_page_id =:adms_page_id",
                "adms_access_level_id={$this->levelId}&adms_page_id={$this->pageId}");
        $this->listLevelPage = $listLevelPage->getResult();
        if (!$this->listLevelPage) {
            $this->addLevelPermission();
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para verificar se a página do sistema tem permnissões de nivel de acesso, caso não tenha, as permissões são cadastradas
     */
    private function addLevelPermission() {
        $this->dataLevelPage['permission'] = (($this->levelId == 1) OR ( $this->publish == 1 )) ? 1 : 2;
        $this->searchLastOrder();
        $this->dataLevelPage['order_level_page'] = $this->viewLastOrder[0]['order_level_page'] + 1;
        $this->dataLevelPage['adms_access_level_id'] = $this->levelId;
        $this->dataLevelPage['adms_page_id'] = $this->pageId;
        $this->dataLevelPage['created'] = date("Y-m-d H:i:s");
        $addAccessLevel = new \App\adms\Models\helper\AdmsCreate();
        $addAccessLevel->exeCreate("adms_levels_pages", $this->dataLevelPage);

        if ($addAccessLevel->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Permissões sincronizadas com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Permissões não sincronizadas com sucesso!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo para verificar a ultima ordem do nível de acesso
     */
    private function searchLastOrder() {
        $viewLastOrder = new \App\adms\Models\helper\AdmsRead();
        $viewLastOrder->fullRead("SELECT order_level_page, adms_access_level_id FROM adms_levels_pages WHERE adms_access_level_id =:adms_access_level_id ORDER BY order_level_page	 DESC LIMIT :limit", "adms_access_level_id={$this->levelId}&limit=1");
        $this->viewLastOrder = $viewLastOrder->getResult();
        if (!$this->viewLastOrder) {
            $this->viewLastOrder[0]['order_level_page'] = 0;
        }
    }

}
