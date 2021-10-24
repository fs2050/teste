<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsDeleteUsers recebe a informação que será deletada do banco de dados
 *
 * @author Celke
 */
class AdmsDeleteUsers
{
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var int $id Contem a Id do usuário que será deletada do sistema */
    private int $id;
    
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var string $delDiretorio Contem a informação sobre o diretório da imagem do usuário que será deletado */
    private string $delDiretorio;
    
    /** @var string $delImg Contem a informação sobre a imagem do usuário que será deletado*/
    private string $delImg;
    
    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }
    
    /**
     * Método para fazer busca do Id na tabela adms_users e validar o mesmo
     * @param array $id Recebe a informação que será validada e deletada do banco de dados */
    public function deleteUser($id) {
        $this->id = (int) $id;

        if ($this->viewUsers()) {
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteUser->exeDelete("adms_users", "WHERE id =:id", "id={$this->id}");

            if ($deleteUser->getResult()) {
                $this->deleteImg();
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuário apagado com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não apagado com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se o usuário está cadastrado no sistema, caso esteja, o resultado é enviado para o metodo deleteUser
     */
    private function viewUsers() {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT usu.id, usu.image 
                FROM adms_users usu
                INNER JOIN adms_access_levels AS lev ON lev.id=usu.adms_access_level_id
                WHERE usu.id=:id AND lev.order_levels >:order_levels
                LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultadoBd = $viewUser->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
            return false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para verificar se o usuário tem uma imagem cadastrada no banco de dados, caso tenha, a imagem e o diretório são excluidos do servidor
     */
    private function deleteImg() {
        if ((!empty($this->resultadoBd[0]['image'])) OR ($this->resultadoBd[0]['image'] != null)) {
            $this->delDiretorio = "app/adms/assets/image/users/" . $this->resultadoBd[0]['id'];
            $this->delImg = $this->delDiretorio . "/" . $this->resultadoBd[0]['image'];

            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }

            if (file_exists($this->delDiretorio)) {
                rmdir($this->delDiretorio);
            }
        }
    }

}
