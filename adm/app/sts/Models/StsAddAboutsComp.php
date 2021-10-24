<?php

namespace App\sts\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsAddAboutsComp
 *
 * @author Celke
 */
class StsAddAboutsComp {

    private array $dados;
    private bool $resultado;
    private $lastInsertAboutsComp;

    function getResultado() {
        return $this->resultado;
    }

    public function create(array $dados = null) {
        $this->dados = $dados;

        $this->dadosImage = $this->dados['new_image'];
        unset($this->dados['new_image'], $this->dados['image']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->valInput();
        } else {
            $this->resultado = false;
        }
    }

    private function valInput() {
        $valExtImg = new \App\adms\Models\helper\AdmsValExtImg();
        $valExtImg->valExtImg($this->dadosImage['type']);
        if ($valExtImg->getResultado()) {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->nameImg = $slugImg->slug($this->dadosImage['name']);
            $this->add();
        } else {
            $this->resultado = false;
        }
    }

    private function add() {
        $this->dados['image'] = $this->nameImg;
        $this->dados['created'] = date("Y-m-d H:i:s");

        $createAboutsComp = new \App\adms\Models\helper\AdmsCreate();
        $createAboutsComp->exeCreate("sts_abouts_companies", $this->dados);

        if ($createAboutsComp->getResult()) {
            $this->lastInsertAboutsComp = $createAboutsComp->getResult();
            $this->upload();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não cadastrado com sucesso. Tente mais tarde!</div>";
            $this->resultado = false;
        }
    }

    private function upload() {

        $this->diretorio = "app/sts/assets/image/about_company/" . $this->lastInsertAboutsComp . "/";

        $uploadImgRed = new \App\adms\Models\helper\AdmsUploadImgRed();
        $uploadImgRed->upload($this->dadosImage, $this->diretorio, $this->nameImg, 500, 500);

        if ($uploadImgRed->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Sobre empresa cadastrado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $this->resultado = false;
            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>Erro: Sobre empresa cadastrado com sucesso. Imagem não enviada com sucesso!</div>";
        }
    }

}
