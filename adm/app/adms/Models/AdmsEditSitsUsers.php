<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditSitsUsers Recebe as informações da situação de usuário que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditSitsUsers
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var int $id Recebe a ID da situação de usuário que será editada */
    private int $id;
    
    /** @var array $dados Recebe os dados serão enviados para a View */
    private array $dados;
    
    /** @var $listRegistryEdit Recebe os dados que serão usados no dropdown do formulário */
    private $listRegistryEdit;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }
    
    /** @return Retorna o resultado do banco de dados*/
    function getResultadoBd() {
        return $this->resultadoBd;
    }

    /**
     * Método para fazer busca na tabela adms_sits_users e validar as informações existentes sobre a situação de usuário antes de editar
     */
    public function viewSitsUser($id) {
        $this->id = (int) $id;
        $viewSitsUser = new \App\adms\Models\helper\AdmsRead();
        $viewSitsUser->fullRead("SELECT id, name, adms_color_id
                FROM adms_sits_users
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewSitsUser->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação de usuário não encontrado!</div>";
            $this->resultado = false;
        }
    }

    /**
     * Método para validar os dados antes que a edição seja feita
     * @param array $dados Recebe a informação que será validada*/
    public function update(array $dados) {
        $this->dados = $dados;

        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->edit();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para salvar as informações editadas no banco de dados
     */
    private function edit() {
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_sits_users", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upUser->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação para usuário editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não editado com sucesso!</div>";
            $this->resultado = false;
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
