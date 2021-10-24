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
class StsViewHome {

    private $resultadoBdTop;
    private $resultadoBdServ;
    private $resultadoBdAction;
    private $resultadoBdDet;

    function getResultadoBdTop() {
        return $this->resultadoBdTop;
    }

    function getResultadoBdServ() {
        return $this->resultadoBdServ;
    }

    function getResultadoBdAction() {
        return $this->resultadoBdAction;
    }

    function getResultadoBdDet() {
        return $this->resultadoBdDet;
    }

    public function viewHomeTop() {
        $viewHomeTop = new \App\adms\Models\helper\AdmsRead();
        $viewHomeTop->fullRead("SELECT id, title_top, description_top, link_btn_top, txt_btn_top, image
                FROM sts_homes_tops 
                LIMIT :limit", "limit=1");

        $this->resultadoBdTop = $viewHomeTop->getResult();
    }

    public function viewHomeServ() {
        $viewHomeServ = new \App\adms\Models\helper\AdmsRead();
        $viewHomeServ->fullRead("SELECT id, title_serv, description_serv, icone_um_serv, titulo_um_serv, description_um_serv, icone_dois_serv, titulo_dois_serv, description_dois_serv, icone_tres_serv, titulo_tres_serv, description_tres_serv
                FROM sts_homes_servs 
                LIMIT :limit", "limit=1");

        $this->resultadoBdServ = $viewHomeServ->getResult();
    }

    public function viewHomeAction() {
        $viewHomeAction = new \App\adms\Models\helper\AdmsRead();
        $viewHomeAction->fullRead("SELECT id, title_action, subtitle_action, description_action, link_btn_action, txt_btn_action, image
                FROM sts_homes_actions
                LIMIT :limit", "limit=1");

        $this->resultadoBdAction = $viewHomeAction->getResult();
    }

    public function viewHomeDet() {
        $viewHomeDet = new \App\adms\Models\helper\AdmsRead();
        $viewHomeDet->fullRead("SELECT id, title_det, subtitle_det, description_det, image
                FROM sts_homes_dets
                LIMIT :limit", "limit=1");

        $this->resultadoBdDet = $viewHomeDet->getResult();
    }

}
