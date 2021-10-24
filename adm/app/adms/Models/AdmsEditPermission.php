<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditPermission Recebe as informações as permissões que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditPermission
{
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    private $resultadoBdLevel;
    
    /** @var $id Recebe a ID do nível de acesso que será editado */
    private $id;
    
    /** @var $dados Recebe os dados do nível de acesso que será editado */
    private $dados;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Método para fazer busca na tabela adms_levels_pages e validar as informações existentes sobre as permissões antes de editar
     */
    public function editPermission($id = null) {

        $this->id = (int) $id;
        $viewPermission = new \App\adms\Models\helper\AdmsRead();
        $viewPermission->fullRead("SELECT lev_pag.id, lev_pag.permission, lev_pag.adms_page_id 
                        FROM adms_levels_pages lev_pag
                        INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id
                        WHERE lev_pag.id =:id
                        AND lev.order_levels >:order_levels
                        LIMIT :limit",
                "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");
        $this->resultadoBd = $viewPermission->getResult();

        if ($this->resultadoBd) {
            $this->levelPermAcess();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Registro não encontrado!</div>";
            $this->resultado = false;
        }
    }
    
    private function levelPermAcess() {
        $viewLevelPermis = new \App\adms\Models\helper\AdmsRead();
        $viewLevelPermis->fullRead("SELECT lev_pag.id
                        FROM adms_levels_pages lev_pag
                        WHERE (lev_pag.adms_page_id =:adms_page_id 
                        AND lev_pag.adms_access_level_id =:adms_access_level_id)
                        AND lev_pag.permission = 1
                        LIMIT :limit",
                "adms_page_id={$this->resultadoBd[0]['adms_page_id']}&adms_access_level_id=" . $_SESSION['adms_access_level_id'] . "&limit=1");
        $this->resultadoBdLevel = $viewLevelPermis->getResult();

        if ($this->resultadoBdLevel) {
            $this->edit();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Registro não encontrado!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar o status da permissão, liberado ou bloqueado e salvar no banco de dados a alteração.
     */
    private function edit() {
        if ($this->resultadoBd[0]['permission'] == 1) {
            $this->dados['permission'] = 2;
        } else {
            $this->dados['permission'] = 1;
        }
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upPermission = new \App\adms\Models\helper\AdmsUpdate();
        $upPermission->exeUpdate("adms_levels_pages", $this->dados, "WHERE id=:id", "id={$this->id}");
        if ($upPermission->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Permissão editada com sucesso!</div>";
            $this->resultado = false;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Permissão não editada com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
