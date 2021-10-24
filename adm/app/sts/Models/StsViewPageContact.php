<?php

namespace App\sts\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsViewHome 
 *
 * @author Celke
 */
class StsViewPageContact {

    private $resultadoBd;

    function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function viewPageContact() {
        $viewPageContact = new \App\adms\Models\helper\AdmsRead();
        $viewPageContact->fullRead("SELECT id, title_opening_hours, opening_hours, title_address, address, address_two, phone
                FROM sts_contacts 
                LIMIT :limit", "limit=1");

        $this->resultadoBd = $viewPageContact->getResult();
    }

}
