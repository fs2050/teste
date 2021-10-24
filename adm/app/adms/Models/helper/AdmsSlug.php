<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsSlug cria o Slug 
 *
 * @author Celke
 */
class AdmsSlug
{
    /** @var string $nome Recebe o nome que será manipulado */
    private string $nome;
    
    /** @var array $formato Recebe o formato */
    private array $formato;

    /**
     * Metodo recebe o nome que será manipulado
     * @param string $nome Recebe o nome
     * @return type Retorna o nome depois que foi mudado para slug
     */
    public function slug($nome) {
        $this->nome = (string) $nome;

        $this->formato['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        $this->formato['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
        $this->nome = strtr(utf8_decode($this->nome), utf8_decode($this->formato['a']), $this->formato['b']);
        $this->nome = str_replace(" ", "-", $this->nome);
        $this->nome = str_replace(array('-----', '----', '---', '--'), '-', $this->nome);
        $this->nome = strtolower($this->nome);

        return $this->nome;
    }

}
