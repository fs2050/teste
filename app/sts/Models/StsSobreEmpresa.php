<?php

namespace App\sts\Models;

if (!defined('48b5t9')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Models responsável em buscar os dados da página sobre empresa
 *
 * @author Celke
 */
class StsSobreEmpresa
{

    /**
     * Instancia a classe genérica no helper responsável em buscar os registro no banco de dados.
     * Possui a QUERY responsável em buscar os registros no BD.
     * @return array Retorna o registro do banco de dados com informações para página sobre empresa
     */
    public function index(): array {
        $listSobreEmpresa = new \App\sts\Models\helper\StsRead();
        /*$listSobreEmpresa->exeRead("sts_sobres_empresas", "WHERE sts_situation_id =:sts_situation_id LIMIT :limit", "sts_situation_id=1&limit=5");*/
        $listSobreEmpresa->fullRead("SELECT id, title, description, image
                FROM sts_abouts_companies
                WHERE sts_situation_id =:sts_situation_id LIMIT :limit", "sts_situation_id=1&limit=10");
        return $listSobreEmpresa->getResult();
    }
}
