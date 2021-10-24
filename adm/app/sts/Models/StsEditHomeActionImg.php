<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditHomeActionImg
 * @author Celke
 */
class StsEditHomeActionImg
{
    private $resultadoBd;
    private bool $resultado;
    private array $dados;
    private $dadosImage;
    private $diretorio;
    private array $saveData;
    private string $delImg;
    private string $nameImg;
    
    function getResultadoBd() {
        return $this->resultadoBd;
    }
    
    function getResultado(): bool {
        return $this->resultado;
    }
    
    public function viewHomeActionImg() {
        $viewHomeActionImg = new \App\adms\Models\helper\AdmsRead();
        $viewHomeActionImg->fullRead("SELECT id, image
                FROM sts_homes_actions
                LIMIT :limit ", 
                "limit=1");
        $this->resultadoBd = $viewHomeActionImg->getResult();
        if($this->resultadoBd){
            $this->resultado = true;
            return true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Imagem da ação da página home não encontrado!</div>";
            $this->resultado = false;
            return false;
        }
    }
    
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

    private function valInput() {
        $valExtImg = new \App\adms\Models\helper\AdmsValExtImg();
        $valExtImg->valExtImg($this->dadosImage['type']);
        if ($this->viewHomeActionImg() AND $valExtImg->getResultado()) {
            $this->upload();
        } else {
            $this->resultado = false;
        }
    }

    private function upload() {
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->nameImg = $slugImg->slug($this->dadosImage['name']);

        $this->diretorio = "app/sts/assets/image/home_action/";

        $uploadImgRed = new \App\adms\Models\helper\AdmsUploadImgRed();
        $uploadImgRed->upload($this->dadosImage, $this->diretorio, $this->nameImg, 1280, 720);

        if ($uploadImgRed->getResultado()) {
            $this->edit();
        } else {
            $this->resultado = false;
        }
    }
    
    private function edit() {
        $this->saveData['image'] = $this->nameImg;
        $this->saveData['modified'] = date("Y-m-d H:i:s");

        $upHomeActionImg = new \App\adms\Models\helper\AdmsUpdate();
        $upHomeActionImg->exeUpdate("sts_homes_actions", $this->saveData, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upHomeActionImg->getResult()) {
            $this->deleteImage();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Imagem da ação da página home não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

    private function deleteImage() {
        if ((!empty($this->resultadoBd[0]['image']) OR ($this->resultadoBd[0]['image'] != null)) AND ($this->resultadoBd[0]['image'] != $this->nameImg)) {
            $this->delImg = "app/sts/assets/image/home_action/" . $this->resultadoBd[0]['image'];
            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }
        }

        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Imagem da ação da página home editado com sucesso!</div>";
        $this->resultado = true;
    }
    
    
}
