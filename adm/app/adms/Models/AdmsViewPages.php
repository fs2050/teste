<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsViewPages Recebe as informações para visualizar os detalhes do da página do sistema
 *
 * @author Celke
 */
class AdmsViewPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Recebe o Id da página a ser visualizada*/
    private int $id;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }

    /** @return Retorna o resultado que veio do banco de dados */
    function getResultDb() {
        return $this->resultDb;
    }

    /**
     * Metodo para pesquisar as informações no banco de dados na tabela adms_pages
     * @param int $id Recebe o Id da página
     */
    public function viewPages($id) {
        $this->id = (int) $id;
        $viewPages = new \App\adms\Models\helper\AdmsRead();
        $viewPages->fullRead("SELECT pg.id, pg.controller, pg.metodo, pg.menu_controller, pg.menu_metodo, pg.name_page, pg.publish, pg.icon, pg.obs,
                tpg.type type_tpg, tpg.name name_tpg,
                sit.name name_sit, clr.color name_color
                FROM adms_pages pg
                LEFT JOIN adms_types_pgs AS tpg ON tpg.id=pg.adms_types_pgs_id
                LEFT JOIN adms_sits_pgs AS sit ON sit.id=pg.adms_sits_pgs_id
                INNER JOIN adms_colors AS clr ON clr.id=sit.adms_color_id
                WHERE pg.id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultDb = $viewPages->getResult();
        if ($this->resultDb) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não encontrado</div>";
            $this->result = false;
        }
    }

}
