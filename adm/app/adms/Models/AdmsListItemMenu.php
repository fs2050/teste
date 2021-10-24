<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe AdmsListItemMenu 
 * 
 * @author Celke
 */
class AdmsListItemMenu
{
    private $resultDb;
    private bool $result;
    private $pag;
    private $limitResult = 40;
    private $resultPg;
    
    function getResultDb()
    {
        return $this->resultDb;
    }

    function getResult(): bool
    {
        return $this->result;
    }

    function getResultPg()
    {
        return $this->resultPg;
    }
    
    public function listItemMenu($pag = null)
    {
        $this->pag = (int) $pag;
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-item-menu/index');
        $pagination->condition($this->pag, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_items_menus");
        $this->resultPg = $pagination->getResult();

        $listItemMenu = new \App\adms\Models\helper\AdmsRead();
        $listItemMenu->fullRead("SELECT id, name, order_item_menu
                    FROM adms_items_menus
                    ORDER BY order_item_menu ASC
                    LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");
        $this->resultDb = $listItemMenu->getResult();
        if($this->resultDb){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum item de menu encontrado!</div>";
            $this->result = false;
        }
    }

}
