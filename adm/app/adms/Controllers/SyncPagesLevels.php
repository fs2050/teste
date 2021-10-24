<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * A classe SyncPagesLevels Tem a função de sincronizar as permissões das páginas para todos os níveis de acesso 
 *
 * @author Celke
 */
class SyncPagesLevels
{
    /**
     * Metodo para fazer a sincronização das permissões das páginas para os níveis de acesso 
     */
    public function index() {
         $syncPagesLevels= new \App\adms\Models\AdmsSyncPagesLevels();
         $syncPagesLevels->syncPagesLevels();        
        
         $urlDestino = URLADM . "list-access-levels/index";
         header("Location: $urlDestino");
    }

}
