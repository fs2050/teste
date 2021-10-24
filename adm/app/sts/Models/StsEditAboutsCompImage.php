<?php

namespace App\sts\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsEditAboutsCompImage
 *
 * @author Celke
 */
class StsEditAboutsCompImage
{
    private $resultadoBd;
    private bool $resultado;
    private int $id;
    private array $dados;
    private $dadosImage;
    private $diretorio;
    private $saveDate;
    private $delImg;
    private string $nameImg;

    function getResultado(): bool {
        return $this->resultado;
    }

    function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function viewAboutsComp($id) {
        $this->id = (int) $id;
        $viewAboutsComp = new \App\adms\Models\helper\AdmsRead();
        $viewAboutsComp->fullRead("SELECT comp.id, comp.image
                FROM sts_abouts_companies comp
                WHERE comp.id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewAboutsComp->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não encontrado!</div>";
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
        if ($this->viewAboutsComp($this->dados['id']) AND $valExtImg->getResultado()) {
            $this->upload();
        } else {
            $this->resultado = false;
        }
    }

    private function upload() {
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->nameImg = $slugImg->slug($this->dadosImage['name']);

        $this->diretorio = "app/sts/assets/image/about_company/" . $this->dados['id'] . "/";

        $uploadImgRed = new \App\adms\Models\helper\AdmsUploadImgRed();
        $uploadImgRed->upload($this->dadosImage, $this->diretorio, $this->nameImg, 500, 500);

        if ($uploadImgRed->getResultado()) {
            $this->edit();
        } else {
            $this->resultado = false;
        }
    }

    private function edit() {
        $this->saveDate['image'] = $this->nameImg;
        $this->saveDate['modified'] = date("Y-m-d H:i:s");

        $upAboutsComp = new \App\adms\Models\helper\AdmsUpdate();
        $upAboutsComp->exeUpdate("sts_abouts_companies", $this->saveDate, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upAboutsComp->getResult()) {
            $this->deleteImage();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Imagem sobre empresa não editada com sucesso!</div>";
            $this->resultado = false;
        }
    }

    private function deleteImage() {
        if ((!empty($this->resultadoBd[0]['image']) OR ($this->resultadoBd[0]['image'] != null)) AND ($this->resultadoBd[0]['image'] != $this->nameImg)) {
            $this->delImg = "app/sts/assets/image/about_company/" . $this->dados['id'] . "/" . $this->resultadoBd[0]['image'];
            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }
        }

        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Imagem sobre empresa editada com sucesso!</div>";
        $this->resultado = true;
    }

}
