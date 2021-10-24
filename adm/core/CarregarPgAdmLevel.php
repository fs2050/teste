<?php

namespace Core;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of CarregarPgAdmLevel
 *
 * @author Celke
 */
class CarregarPgAdmLevel
{

    private string $urlController;
    private string $urlMetodo;
    private string $urlParamentro;
    private string $classe;
    private $resultPage;
    private $resultLevelPage;

    /**
     * 
     * @param string $urlController Recebe da URL o nome da controller
     * @param string $urlMetodo Recebe da URL o método
     * @param string $urlParamentro Recebe da URL o parâmetro
     */
    public function carregarPg($urlController = null, $urlMetodo = null, $urlParamentro = null): void {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParamentro = $urlParamentro;

        $this->searchPage();
    }

    private function searchPage() {
        $searchPage = new \App\adms\Models\helper\AdmsRead();
        $searchPage->fullRead("SELECT pag.id, pag.publish,
                typ.type
                FROM adms_pages pag
                INNER JOIN adms_types_pgs AS typ ON typ.id=pag.adms_types_pgs_id
                WHERE pag.controller =:controller
                AND metodo =:metodo
                LIMIT :limit",
                "controller={$this->urlController}&metodo={$this->urlMetodo}&limit=1");
        $this->resultPage = $searchPage->getResult();
        if ($this->resultPage) {
            if ($this->resultPage[0]['publish'] == 1) {
                $this->classe = "\\App\\" . $this->resultPage[0]['type'] . "\\Controllers\\" . $this->urlController;
                $this->carregarMetodo();
            } else {
                $this->verificarLogin();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não encontrada!</div>";
            $urlDestino = URLADM . "dashboard/index";
            header("Location: $urlDestino");
        }
    }

    private function carregarMetodo() {
        $classCarregar = new $this->classe();
        if (method_exists($classCarregar, $this->urlMetodo)) {
            $classCarregar->{$this->urlMetodo}($this->urlParamentro);
        } else {
            die("Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM . "!<br>");
        }
    }

    private function verificarLogin() {
        if (isset($_SESSION['user_id']) AND isset($_SESSION['user_name']) AND isset($_SESSION['user_email']) AND isset($_SESSION['adms_access_level_id']) AND isset($_SESSION['order_levels'])) {
            $this->searchLevelPage();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Para acessar a página realize o login!</div>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    private function searchLevelPage() {
        $searchLevelPage = new \App\adms\Models\helper\AdmsRead();
        $searchLevelPage->fullRead("SELECT id, permission
                FROM adms_levels_pages
                WHERE adms_page_id =:adms_page_id
                AND adms_access_level_id =:adms_access_level_id
                AND permission =:permission
                LIMIT :limit",
                "adms_page_id={$this->resultPage[0]['id']}&adms_access_level_id=" . $_SESSION['adms_access_level_id'] . "&permission=1&limit=1");
        $this->resultLevelPage = $searchLevelPage->getResult();
        if ($this->resultLevelPage) {
            $this->classe = "\\App\\" . $this->resultPage[0]['type'] . "\\Controllers\\" . $this->urlController;
            $this->carregarMetodo();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sem permissão de acessar a página!</div>";
            $urlDestino = URLADM . "dashboard/index";
            header("Location: $urlDestino");
        }
    }

}
