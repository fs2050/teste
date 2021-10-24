<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditDropdownMenu 
 *
 * @author Celke
 */
class EditDropdownMenu
{
   
    private int $id;
    private int $level;
    private int $pag;

    public function index() {

        $this->id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        $this->level = filter_input(INPUT_GET, "level", FILTER_SANITIZE_NUMBER_INT);
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        
        $editDropdownMenu = new \App\adms\Models\AdmsEditDropdownMenu();
        $editDropdownMenu->editDropdownMenu($this->id);

        $urlDestino = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
        header("Location: $urlDestino");
    }

}
