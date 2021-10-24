<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsValCampoVazio faz a validação dos campos vazios dos formularios
 *
 * @author Celke
 */
class AdmsValCampoVazio
{
    /** @var array $dados Recebe os dados que serão validados*/
    private array $dados;
    
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
     * Metodo recebe os dados e faz a validação
     * @param array $dados Recebe os dados
     */
    public function validarDados(array $dados) {
        $this->dados = $dados;
        $this->dados = array_map('strip_tags', $this->dados);
        $this->dados = array_map('trim', $this->dados);
        
        if(in_array('', $this->dados)){
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            $this->resultado = false;
        }else{
            $this->resultado = true;
        }
    }
}
