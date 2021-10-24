<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditUsers Recebe as informações do usuário que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditUsers
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var int $id Recebe o ID do usuário que será editado */
    private int $id;
    
    /** @var array $dados Recebe os dados serão enviados para a View */
    private array $dados;
    
    /** @var array $dadosExitVal Recebe os dados serão retirados da validação */
    private array $dadosExitVal;
    
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
     * Método para fazer busca na tabela adms_users e validar as informações sobre o usuário antes de editar
     */
    public function viewUser($id) {
        $this->id = (int) $id;
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT usu.id, usu.name, usu.nickname, usu.email, usu.username, usu.adms_sits_user_id, usu.adms_access_level_id
                FROM adms_users usu
                INNER JOIN adms_access_levels AS lev ON lev.id=usu.adms_access_level_id
                WHERE usu.id=:id AND lev.order_levels >:order_levels
                LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultadoBd = $viewUser->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
            $this->resultado = false;
        }
    }

    /**
     * Método para validar os dados antes que a edição seja feita e retirar campos especificos da validação
     * @param array $dados Recebe a informação que será validada*/
    public function update(array $dados) {
        $this->dados = $dados;

        $this->dadosExitVal['nickname'] = $this->dados['nickname'];
        unset($this->dados['nickname']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->valInput();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para validar campos especificos e unicos da tabela
     */
    private function valInput() {
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validarEmail($this->dados['email']);

        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validarEmailSingle($this->dados['email'], true, $this->dados['id']);

        $valUserSingle = new \App\adms\Models\helper\AdmsValUserSingle();
        $valUserSingle->validarUserSingle($this->dados['username'], true, $this->dados['id']);

        if ($valEmail->getResultado() AND $valEmailSingle->getResultado() AND $valUserSingle->getResultado()) {
            //$_SESSION['msg'] = "Editar Usuário!<br>";
            //$this->resultado = false;
            $this->edit();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para salvar as informações editadas no banco de dados
     */
    private function edit() {
        $this->dados['nickname'] = $this->dadosExitVal['nickname'];
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upUser->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuário editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo usado para listar informações no dropdown do formulário*/
    public function listSelect() {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_users ORDER BY name ASC");
        $registry['sit'] = $list->getResult();

        $list->fullRead("SELECT id id_lev, name name_lev
                FROM adms_access_levels
                WHERE order_levels >:order_levels
                ORDER BY name ASC", "order_levels=" . $_SESSION['order_levels']);
        $registry['lev'] = $list->getResult();

        $this->listRegistryEdit = ['sit' => $registry['sit'], 'lev' => $registry['lev']];

        return $this->listRegistryEdit;
    }

}
