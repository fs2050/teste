<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditPages recebe as informações que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Contem a Id da página que será editada no sistema */
    private int $id;
    
    /** @var array $data Recebe as informações que serão editadas */
    private array $data;
    
    /** @var array $dataExitVal Recebe campos especificos do formulário que serão retirados da validação */
    private array $dataExitVal;
    
    /** @var $listRegistryEdit Recebe as informações que serão usadas no dropdown do formulário */
    private $listRegistryEdit;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResult(): bool {
        return $this->result;
    }

    /** @return Retorna o resultado do banco de dados*/
    function getResultDb() {
        return $this->resultDb;
    }

    /**
     * Método para fazer busca do Id na tabela adms_pages e validar o mesmo
     * @param array $id Recebe a informação que será validada e editada no banco de dados */
    public function viewPage($id) {
        $this->id = (int) $id;
        $viewPage = new \App\adms\Models\helper\AdmsRead();
        $viewPage->fullRead("SELECT pg.id, pg.controller, pg.metodo, pg.menu_controller, pg.menu_metodo, pg.name_page, pg.publish, pg.icon, pg.obs, pg.adms_sits_pgs_id, pg.adms_types_pgs_id, pg.adms_groups_pgs_id,
                tpg.type type_tpg, tpg.name name_tpg,
                sit.name name_sit, 
                clr.color name_color
                FROM adms_pages pg
                LEFT JOIN adms_types_pgs AS tpg ON tpg.id=pg.adms_types_pgs_id
                LEFT JOIN adms_sits_pgs AS sit ON sit.id=pg.adms_sits_pgs_id
                INNER JOIN adms_colors AS clr ON clr.id=sit.adms_color_id
                WHERE pg.id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultDb = $viewPage->getResult();
        if ($this->resultDb) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não encontrada!</div>";
            $this->result = false;
        }
    }

    /**
     * Método para validar os dados antes que a edição seja feita e retirar campos especificos da validação
     * @param array $data Recebe a informação que será validada*/
    public function update(array $data) {
        $this->data = $data;

        $this->dataExitVal['icon'] = $this->data['icon'];
        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['icon'], $this->data['obs']);

        $valEmptyField = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valEmptyField->validarDados($this->data);
        if ($valEmptyField->getResultado()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }    

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para fazer a atualização das informações no banco de dados
     */
    private function edit() {
        $this->data['icon'] = $this->dataExitVal['icon'];
        $this->data['obs'] = $this->dataExitVal['obs'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upPage = new \App\adms\Models\helper\AdmsUpdate();
        $upPage->exeUpdate("adms_pages", $this->data, "WHERE id =:id", "id={$this->data['id']}");

        if ($upPage->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Página editada com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Página não editada com sucesso!</div>";
            $this->result = false;
        }
    }
    
    /** Metodo para buscar informações no banco de dados que serão usadas no dropdown do formulário */    
    public function listSelect() {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_pgs ORDER BY name ASC");
        $registry['sit'] = $list->getResult();

        $list->fullRead("SELECT id id_type, type, name name_type FROM adms_types_pgs ORDER BY name ASC");
        $registry['type'] = $list->getResult();
        
        $list->fullRead("SELECT id id_group, name name_group FROM adms_groups_pgs ORDER BY name ASC");
        $registry['group'] = $list->getResult();

        $this->listRegistryEdit = ['sit' => $registry['sit'], 'type' => $registry['type'], 'group' => $registry['group']];

        return $this->listRegistryEdit;
    }

}
