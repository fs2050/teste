<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsEditPerfilImage recebe as informações da imagem do perfil do usuário que serão editadas no banco de dados
 *
 * @author Celke
 */
class AdmsEditPerfilImage
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;
    
    /** @var array $dados Recebe as informações que serão editadas */
    private array $dados;
    
    /** @var array $dadosImage Recebe as informações da imagem que sera editada */
    private $dadosImage;
    
    /** @var array $diretorio Recebe as informações do diretorio da imagem que sera editada */
    private $diretorio;
    
    /** @var array $saveData Recebe os dados que serão salvos no banco de dados */
    private array $saveData;
    
    /** @var string $delImg Recebe os dados da imagem que será deletada*/
    private string $delImg;
    
    /** @var string $nameImg Recebe o nome da nova imagem*/
    private string $nameImg;
    
    /** @return Retorna o resultado do banco de dados*/
    function getResultadoBd() {
        return $this->resultadoBd;
    }
    
    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Método para fazer busca na tabela adms_users e validar as informações existentes antes de editar
     */
    public function viewPerfil() {
        $viewPerfil = new \App\adms\Models\helper\AdmsRead();
        $viewPerfil->fullRead("SELECT id, image
                FROM adms_users
                WHERE id=:id
                LIMIT :limit ", 
                "id={$_SESSION['user_id']}&limit=1");
        $this->resultadoBd = $viewPerfil->getResult();
        if($this->resultadoBd){
            $this->resultado = true;
            return true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
            $this->resultado = false;
            return false;
        }
    }

    /**
     * Método para validar os dados antes que a edição seja feita e retirar campos especificos da validação
     * @param array $dados Recebe a informação que será validada*/
    public function update(array $dados) {
        $this->dados = $dados;

        $this->dadosImage = $this->dados['new_image'];
        unset($this->dados['new_image'], $this->dados['image']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            if (!empty($this->dadosImage['name'])) {
                $this->valInput();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar uma imagem!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para validar a extensão da imagem
     */
    private function valInput() {
        $valExtImg = new \App\adms\Models\helper\AdmsValExtImg();
        $valExtImg->valExtImg($this->dadosImage['type']);
        if ($this->viewPerfil() AND $valExtImg->getResultado()) {
            $this->upload();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para fazer o upload da imagem no servidor
     */
    private function upload() {
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->nameImg = $slugImg->slug($this->dadosImage['name']);

        $this->diretorio = "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/";

        $uploadImgRed = new \App\adms\Models\helper\AdmsUploadImgRed();
        $uploadImgRed->upload($this->dadosImage, $this->diretorio, $this->nameImg, 300, 300);

        if ($uploadImgRed->getResultado()) {
            $this->edit();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para salvar as informações da imagem no banco de dados
     */
    private function edit() {
        $this->saveData['image'] = $this->nameImg;
        $this->saveData['modified'] = date("Y-m-d H:i:s");

        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->saveData, "WHERE id =:id", "id={$_SESSION['user_id']}");

        if ($upUser->getResult()) {
            $this->deleteImage();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Imagem não editada com sucesso!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo usado para deletar a imagem antiga do perfil do usuário
     */
    private function deleteImage() {
        if ((!empty($this->resultadoBd[0]['image']) OR ($this->resultadoBd[0]['image'] != null)) AND ($this->resultadoBd[0]['image'] != $this->nameImg)) {
            $this->delImg = "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/" . $this->resultadoBd[0]['image'];
            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }
        }

        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Imagem editada com sucesso!</div>";
        $this->resultado = true;
    }
    
    
}
