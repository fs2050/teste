<?php

namespace App\sts\Models;

if (!defined('48b5t9')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
/**
 * Models responsável em buscar os dados da página home
 *
 * @author Celke
 */
class StsHome
{
    /** @var array $data Recebe o registro do banco de dados */
    private array $data;
    /** @var array $dataTop Recebe o registro do banco de dados relacionado ao topo */
    private array $dataTop;
    /** @var array $dataServ Recebe o registro do banco de dados relacionado aos serviços */
    private array $dataServ;
    /** @var array $dataAction Recebe o registro do banco de dados relacionado a ação */
    private array $dataAction;
    /** @var array $dataDet Recebe o registro do banco de dados relacionado a detalhes do serviço */
    private array $dataDet;

    /**
     * Instancia a classe genérica no helper responsável em buscar os registro no banco de dados.
     * Possui a QUERY responsável em buscar os registros no BD.
     * @return array Retorna o registro do banco de dados com informações para página Home
     */
    public function index(): array {
        $this->viewTop();
        $this->viewServ();
        $this->viewAction();
        $this->viewDet();
        return $this->data;
    }
    
    private function viewTop() {
        $viewTop = new \App\sts\Models\helper\StsRead();
        $viewTop->fullRead("SELECT id, title_top, description_top, link_btn_top, txt_btn_top, image
                FROM sts_homes_tops
                LIMIT :limit", "limit=1");
        $this->dataTop = $viewTop->getResult();
        $this->data['top'] = $this->dataTop[0];
    }
    
    private function viewServ() {
        $viewServ = new \App\sts\Models\helper\StsRead();
        $viewServ->fullRead("SELECT id, title_serv, description_serv, icone_um_serv, titulo_um_serv, description_um_serv, icone_dois_serv, titulo_dois_serv, description_dois_serv, icone_tres_serv, titulo_tres_serv, description_tres_serv
                FROM sts_homes_servs
                LIMIT :limit", "limit=1");
        $this->dataServ = $viewServ->getResult();
        $this->data['serv'] = $this->dataServ[0];
    }
    
    private function viewAction() {
        $viewAction = new \App\sts\Models\helper\StsRead();
        $viewAction->fullRead("SELECT id, title_action, subtitle_action, description_action, link_btn_action, txt_btn_action, image
                FROM sts_homes_actions
                LIMIT :limit", "limit=1");
        $this->dataAction = $viewAction->getResult();
        $this->data['action'] = $this->dataAction[0];
    }
    
    private function viewDet() {
        $viewDet = new \App\sts\Models\helper\StsRead();
        $viewDet->fullRead("SELECT id, title_det, subtitle_det, description_det, image
                FROM sts_homes_dets
                LIMIT :limit", "limit=1");
        $this->dataDet = $viewDet->getResult();
        $this->data['det'] = $this->dataDet[0];
    }

}
