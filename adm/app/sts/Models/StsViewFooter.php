<?php

namespace App\sts\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe StsViewFooter 
 *
 * @author Celke
 */
class StsViewFooter {

    private $resultadoBd;

    function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function viewFooter() {
        $viewFooter = new \App\adms\Models\helper\AdmsRead();
        $viewFooter->fullRead("SELECT id, title_site, title_contact, phone, address, url_address, cnpj, url_cnpj, title_social_networks, txt_one_social_networks, link_one_social_networks, txt_two_social_networks, link_two_social_networks, txt_three_social_networks, link_three_social_networks, txt_four_social_networks, link_four_social_networks
                FROM sts_footers 
                LIMIT :limit", "limit=1");

        $this->resultadoBd = $viewFooter->getResult();
    }

}
