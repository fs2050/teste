<?php

namespace App\adms\Models\helper;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsButton busca informações da permissão dos botões no banco de dados de acordo com os niveis de acesso 
 *
 * @author Celke
 */
class AdmsButton
{
    /** @var $result Recebe o resultado das informações que veio do banco de dados*/
    private $result;
    
    /** @var $data Recebe o array de dados */
    private $data;

    public function buttonPermission(array $data) {
        $this->data = $data;
        foreach ($this->data as $key => $button) {
            extract($button);
            $viewButton = new \App\adms\Models\helper\AdmsRead();
            $viewButton->fullRead("SELECT pag.id id_pag
                    FROM adms_pages pag
                    INNER JOIN adms_levels_pages AS lev_pag ON lev_pag.adms_page_id=pag.id
                    WHERE pag.menu_controller =:menu_controller
                    AND pag.menu_metodo =:menu_metodo
                    AND lev_pag.permission = 1
                    AND lev_pag.adms_access_level_id =:adms_access_level_id
                    LIMIT :limit", "menu_controller=$menu_controller&menu_metodo=$menu_metodo&adms_access_level_id=" . $_SESSION['adms_access_level_id'] . "&limit=1");

            if ($viewButton->getResult()) {
                $this->result[$key] = true;
            } else {
                $this->result[$key] = false;
            }
        }

        return $this->result;
    }

}
