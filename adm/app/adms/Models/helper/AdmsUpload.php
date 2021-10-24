<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsUpload faz o upload da imagem no servidor
 *
 * @author Celke
 */
class AdmsUpload
{
    /** @var string $diretorio Recebe o nome do direitorio */
    private string $diretorio;
    
    /** @var string $tmpName Recebe o nome temporario*/
    private string $tmpName;
    
    /** @var string $name Recebe o nome da imagem*/
    private string $name;
    
    /** @var bool $resultado Recebe o resultado */
    private bool $resultado;
    
    /**
     * Recebe o resultado verdadeiro ou falso
     * @return bool
     */
    function getResultado(): bool {
        return $this->resultado;
    }

    /**
     * Metodo recebe o diretorio, nome temporario e o nome da imagem
     * @param string $diretorio Recebe o diretorio
     * @param string $tmpName Recebe o nome temporario
     * @param string $name Recebe o nome da imagem
     */
    public function upload($diretorio, $tmpName, $name) {
        $this->diretorio = (string) $diretorio;
        $this->tmpName = (string) $tmpName;
        $this->name = (string) $name;
        
        if($this->valDiretorio()){
            $this->uploadFile();
        }else{
            $this->resultado = false;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo valida o diretorio
     */
    private function valDiretorio() {
        if(!file_exists($this->diretorio) && !is_dir($this->diretorio)){
            mkdir($this->diretorio);
            if(!file_exists($this->diretorio) && !is_dir($this->diretorio)){
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Upload não realizado com sucesso. Tente novamente!</div>";
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
    
    /** Metodo privado, só pode ser chamado na classe
     * Metodo faz o upload do arquivo no servidor
     */
    private function uploadFile() {
        if(move_uploaded_file($this->tmpName, $this->diretorio . $this->name)){
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Upload não realizado com sucesso. Tente novamente!</div>";
            $this->resultado = false;
        }
    }
}
