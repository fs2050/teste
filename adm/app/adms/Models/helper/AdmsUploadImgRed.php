<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsUploadImgRed faz o upload da imagem redimensionada no servidor
 *
 * @author Celke
 */
class AdmsUploadImgRed
{
    /** @var string $imageData Recebe os dados da iamgem */
    private array $imageData;
    
    /** @var string $diretorio Recebe o nome do direitorio */
    private string $diretorio;
    
    /** @var string $name Recebe o nome da imagem*/
    private string $name;
    
    /** @var $largura Recebe a largura da imagem */
    private $largura;
    
    /** @var $altura Recebe a altura da imagem */
    private $altura;
    
    /** @var $altura Recebe a nova imagem */
    private $newImage;
    
    /** @var bool $resultado Recebe o resultado */
    private bool $resultado;
    
    /** @var $imgRedimens Recebe a imagem redimensionada */
    private $imgRedimens;

    /**
     * Recebe o resultado verdadeiro ou falso
     * @return bool
     */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Metodo recebe os dados da imagem, diretorio, nome, altura e a altura
     * @param string $imageData
     * @param string $diretorio
     * @param string $name
     * @param type $largura
     * @param type $altura
     */
    public function upload(array $imageData, $diretorio, $name, $largura, $altura) {
        $this->imageData = $imageData;
        $this->diretorio = $diretorio;
        $this->name = (string) $name;
        $this->largura = $largura;
        $this->altura = $altura;

        if ($this->valDiretorio()) {
            $this->uploadFile();
        } else {
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo valida o diretorio, verifica se o diretorio existe ou não
     */
    private function valDiretorio() {
        if (file_exists($this->diretorio) && (!is_dir($this->diretorio))) {
            if ($this->createDir()) {
                return true;
            } else {
                return false;
            }
        } elseif (!file_exists($this->diretorio)) {
            if ($this->createDir()) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo cria o direitorio para que seja feito o upload
     */
    private function createDir() {
        mkdir($this->diretorio, 0755);
        if (!file_exists($this->diretorio)) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Upload da imagem não realizado com sucesso. Tente novamente!</div>";
            return false;
        } else {
            return true;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo valida a extensão da imagem
     */
    private function uploadFile() {
        switch ($this->imageData['type']):
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->uploadFileJpeg();
                break;
            case 'image/png':
            case 'image/x-png':
                $this->uploadFilePng();
                break;
            default:
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar imagem JPEG ou PNG!</div>";
                $this->resultado = false;
        endswitch;
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo faz o upload da imagem com extensão jpeg
     */
    private function uploadFileJpeg() {
        //Cria uma nova imagem a partir de um arquivo ou URL
        $this->newImage = imagecreatefromjpeg($this->imageData['tmp_name']);

        $this->redImg();

        //Enviar a imagem para servidor
        if (imagejpeg($this->imgRedimens, $this->diretorio . $this->name, 100)) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Upload da imagem realizado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Upload da imagem não realizado com sucesso. Tente novamente!</div>";
            $this->resultado = false;
        }
    }

    /** Metodo privado, só pode ser chamado na classe
     * Metodo faz o upload da imagem com extensão png
     */
    private function uploadFilePng() {
        //Cria uma nova imagem a partir de um arquivo ou URL
        $this->newImage = imagecreatefrompng($this->imageData['tmp_name']);

        $this->redImg();

        //Enviar a imagem para servidor
        if (imagepng($this->imgRedimens, $this->diretorio . $this->name, 1)) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Upload da imagem realizado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Upload da imagem não realizado com sucesso. Tente novamente!</div>";
            $this->resultado = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo faz o upload da imagem redimensionada
     */
    private function redImg() {
        //Obter a largura da imagem
        $largura_original = imagesx($this->newImage);
        //Obter a altura da imagem
        $altura_original = imagesy($this->newImage);

        //Criar uma imagem modelo com as dimensões definidas para nova imagem
        $this->imgRedimens = imagecreatetruecolor($this->largura, $this->altura);

        //Copiar e redimensionar parte da imagem enviada pelo usuário e interpola com a imagem tamanho modelo
        imagecopyresampled($this->imgRedimens, $this->newImage, 0, 0, 0, 0, $this->largura, $this->altura, $largura_original, $altura_original);
    }

}
