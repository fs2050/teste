<?php

namespace App\sts\Models;

if (!defined('48b5t9')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Cadastrar nova mensagem no banco de dados
 *
 * @author Celke
 */
class StsFooter
{

    /** @var array $dataContact Recebe os dados que são retornado do BD */
    private array $dataFooter;
    
    public function view() {
        $viewFooter = new \App\sts\Models\helper\StsRead();
        $viewFooter->fullRead("SELECT title_site, title_contact, phone, address, url_address, cnpj, url_cnpj, title_social_networks, txt_one_social_networks, link_one_social_networks, txt_two_social_networks, link_two_social_networks, txt_three_social_networks, link_three_social_networks, txt_four_social_networks, link_four_social_networks
                FROM sts_footers
                LIMIT :limit", "limit=1");
        $this->dataFooter = $viewFooter->getResult();
        return $this->dataFooter[0];
    }

}
