<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditSitsPages Recebe as informações da situação de página que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditSitsPages
{
    /** @var $resultDb Recebe o resultado das informações que vieram do banco de dados */
    private $resultDb;
    
    /** @var bool $result Recebe o resultado das informações que estão sendo manipuladas */
    private bool $result;
    
    /** @var int $id Recebe a ID da situação de página que será editada */
    private int $id;
    
    /** @var array $data Recebe os dados serão enviados para a View */
    private array $data;
    
    /** @var $listRegistryEdit Recebe os dados que serão usados no dropdown do formulário */
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
     * Método para fazer busca na tabela adms_sits_pgs e validar as informações existentes sobre a situação de página antes de editar
     */
    public function viewSitsPages($id) {
        $this->id = (int) $id;
        $viewSitsPages = new \App\adms\Models\helper\AdmsRead();
        $viewSitsPages->fullRead("SELECT id, name, adms_color_id
                FROM adms_sits_pgs
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultDb = $viewSitsPages->getResult();
        if ($this->resultDb) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação de página não encontrada!</div>";
            $this->result = false;
        }
    }

    /**
     * Método para validar os dados antes que a edição seja feita
     * @param array $data Recebe a informação que será validada*/
    public function update(array $data) {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valEmptyField->validarDados($this->data);
        if ($valEmptyField->getResultado()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para salvar as informações editadas no banco de dados
     */
    private function edit() {
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upSitPages = new \App\adms\Models\helper\AdmsUpdate();
        $upSitPages->exeUpdate("adms_sits_pgs", $this->data, "WHERE id =:id", "id={$this->data['id']}");

        if ($upSitPages->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação de página editada com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação de página não editada com sucesso!</div>";
            $this->result = false;
        }
    }
    
    /** Metodo usado para listar informações no dropdown do formulário*/
    public function listSelect() {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_cor, name name_cor FROM adms_colors ORDER BY name ASC");
        $registry['cor'] = $list->getResult();
        
        $this->listRegistryEdit = ['cor' => $registry['cor']];
        
        return $this->listRegistryEdit;
    }

}
