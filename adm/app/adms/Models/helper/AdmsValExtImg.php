<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsUploadImgRed verifica a extensão da imagem
 *
 * @author Celke
 */
class AdmsValExtImg
{
    /** @var string $mimeType Recebe o mimeType da imagem*/
    private string $mimeType;
    
    /** @var bool $resultado Recebe o resultado*/
    private bool $resultado;

    /**
     * Recebe o resultado, verdadeiro ou falso
     * @return bool Verdadeiro ou falso
     */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Metodo faz a validação da extensão da imagem
     * @param string $mimeType Extensão da imagem
     */
    public function valExtImg($mimeType) {
        $this->mimeType = $mimeType;
        switch ($this->mimeType):
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->resultado = true;
                break;
            case 'image/png':
            case 'image/x-png':
                $this->resultado = true;
                break;
            default:
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar imagem JPEG ou PNG!</div>";
                $this->resultado = false;
        endswitch;
    }

}
