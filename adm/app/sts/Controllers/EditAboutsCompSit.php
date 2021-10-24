<?php

namespace App\sts\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe EditAboutsCompSit 
 *
 * @author Celke
 */
class EditAboutsCompSit
{
    private int $id;
    private int $pag;

    public function index() {

        $this->id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        
        $editAboutsCompSit = new \App\sts\Models\StsEditAboutsCompSit();
        $editAboutsCompSit->editAboutsCompSit($this->id);

        $urlDestino = URLADM . "list-abouts-comp/index/{$this->pag}";
        header("Location: $urlDestino");
    }

}
