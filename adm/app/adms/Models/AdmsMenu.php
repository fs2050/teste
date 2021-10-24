<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsMenu
 *
 * @author Celke
 */
class AdmsMenu 
{
    /** @var $resultadoBd Recebe o resultado das informações que vieram do banco de dados */
    private $resultadoBd;
    
    /** @var bool $resultado Recebe o resultado das informações que estão sendo manipuladas */
    private bool $resultado;

    /** @return Retorna o resultado verdadeiro ou falso */
    function getResultado() {
        return $this->resultado;
    }
    
    public function itemMenu() {        

        $listMenu = new \App\adms\Models\helper\AdmsRead();
        $listMenu->fullRead("SELECT lev_pag.dropdown,
                pag.menu_controller, pag.menu_metodo, pag.name_page, pag.icon,
                itm_men.id id_itm_men, itm_men.name name_itm_men, itm_men.icon icon_itm_men
                FROM adms_levels_pages lev_pag
                INNER JOIN adms_pages pag ON pag.id=lev_pag.adms_page_id 
                INNER JOIN adms_items_menus itm_men ON itm_men.id=lev_pag.adms_items_menu_id
                WHERE ((lev_pag.adms_access_level_id =:adms_access_level_id ) 
                AND (lev_pag.permission = 1))
                AND print_menu = 1
                ORDER BY itm_men.order_item_menu, lev_pag.order_level_page ASC", 
                "adms_access_level_id={$_SESSION['adms_access_level_id']}");
//AND print_menu = 1
        $this->resultadoBd = $listMenu->getResult();
        if ($this->resultadoBd) {
            //var_dump($this->resultadoBd);
            
            return $this->resultadoBd;
        } else {
            return false;
        }
    }
}
