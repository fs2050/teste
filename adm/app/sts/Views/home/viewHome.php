<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Detalhes da Página Home</h2>
            </div>
        </div>  
        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="lead">Topo da Página Home</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <?php
                    if ($this->dados['button']['edit_home_top']) {
                        echo "<a href='" . URLADM . "edit-home-top/index' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                    }
                    ?>                         
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->dados['button']['edit_home_top']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "edit-home-top/index'>Editar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>  
        <hr class="hr-title">
        <?php
        if (!empty($this->dados['viewHomeTop'][0])) {
            extract($this->dados['viewHomeTop'][0]);
            ?>
            <dl class="row">

                <?php
                if (!empty($image) AND (file_exists("app/sts/assets/image/home_top/$image"))) {
                    $image = URLADM . "app/sts/assets/image/home_top/$image";
                } else {
                    $image = URLADM . "app/sts/assets/image/home_top/icon_home_top.png";
                }
                ?>

                <dt class="col-sm-3">Imagem</dt>
                <dd class="col-sm-9 mb-4">
                    <div class="img-edit">
                        <img src="<?php echo $image; ?>" alt="<?php echo $title_top; ?>" class="img-thumbnail view-img-size-sts">
                        <div class="edit">
                            <a href="<?php echo URLADM . 'edit-home-top-img/index'; ?>" class="btn btn-outline-warning btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </dd>

                <dt class="col-sm-3">Título</dt>
                <dd class="col-sm-9"><?php echo $title_top; ?></dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?php echo $description_top; ?></dd>

                <dt class="col-sm-3">Link do Botão</dt>
                <dd class="col-sm-9"><?php echo $link_btn_top; ?></dd>

                <dt class="col-sm-3">Texto do Botão</dt>
                <dd class="col-sm-9"><?php echo $txt_btn_top; ?></dd>
            </dl>
            <?php
        }
        ?>
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="lead">Serviços da Página Home</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <?php
                    if ($this->dados['button']['edit_home_serv']) {
                        echo "<a href='" . URLADM . "edit-home-serv/index' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                    }
                    ?>                         
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->dados['button']['edit_home_serv']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "edit-home-serv/index'>Editar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>  
        <hr class="hr-title">
        <?php
        if (!empty($this->dados['viewHomeServ'][0])) {
            extract($this->dados['viewHomeServ'][0]);
            ?>
            <dl class="row">

                <dt class="col-sm-3">Título</dt>
                <dd class="col-sm-9"><?php echo $title_serv; ?></dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?php echo $description_serv; ?></dd>

                <dt class="col-sm-3">Título do Ícone Um</dt>
                <dd class="col-sm-9"><?php echo $titulo_um_serv; ?></dd>

                <dt class="col-sm-3">Descrição do Ícone Um</dt>
                <dd class="col-sm-9"><?php echo $description_um_serv; ?></dd>

                <dt class="col-sm-3">Ícone do Serviço Um</dt>
                <dd class="col-sm-9"><?php echo $icone_um_serv; ?></dd>

                <dt class="col-sm-3">Título do Ícone Dois</dt>
                <dd class="col-sm-9"><?php echo $titulo_dois_serv; ?></dd>

                <dt class="col-sm-3">Descrição do Ícone Dois</dt>
                <dd class="col-sm-9"><?php echo $description_dois_serv; ?></dd>

                <dt class="col-sm-3">Ícone do Serviço Dois</dt>
                <dd class="col-sm-9"><?php echo $icone_dois_serv; ?></dd>

                <dt class="col-sm-3">Título do Ícone Três</dt>
                <dd class="col-sm-9"><?php echo $titulo_tres_serv; ?></dd>

                <dt class="col-sm-3">Descrição do Ícone Três</dt>
                <dd class="col-sm-9"><?php echo $description_tres_serv; ?></dd>

                <dt class="col-sm-3">Ícone do Serviço Três</dt>
                <dd class="col-sm-9"><?php echo $icone_tres_serv; ?></dd>
            </dl>
            <?php
        }
        ?>
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="lead">Ação da Página Home</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <?php
                    if ($this->dados['button']['edit_home_action']) {
                        echo "<a href='" . URLADM . "edit-home-action/index' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                    }
                    ?>                         
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->dados['button']['edit_home_action']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "edit-home-action/index'>Editar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>  
        <hr class="hr-title">
        <?php
        if (!empty($this->dados['viewHomeAction'][0])) {
            extract($this->dados['viewHomeAction'][0]);
            ?>
            <dl class="row">

                <?php
                if (!empty($image) AND (file_exists("app/sts/assets/image/home_action/$image"))) {
                    $image = URLADM . "app/sts/assets/image/home_action/$image";
                } else {
                    $image = URLADM . "app/sts/assets/image/home_action/icon_chamada_acao.png";
                }
                ?>

                <dt class="col-sm-3">Imagem</dt>
                <dd class="col-sm-9 mb-4">
                    <div class="img-edit">
                        <img src="<?php echo $image; ?>" alt="<?php echo $title_action; ?>" class="img-thumbnail view-img-size-sts">
                        <div class="edit">
                            <a href="<?php echo URLADM . 'edit-home-action-img/index'; ?>" class="btn btn-outline-warning btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </dd>

                <dt class="col-sm-3">Título</dt>
                <dd class="col-sm-9"><?php echo $title_action; ?></dd>

                <dt class="col-sm-3">Subtítulo</dt>
                <dd class="col-sm-9"><?php echo $subtitle_action; ?></dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?php echo $description_action; ?></dd>

                <dt class="col-sm-3">Link do Botão</dt>
                <dd class="col-sm-9"><?php echo $link_btn_action; ?></dd>

                <dt class="col-sm-3">Texto do Botão</dt>
                <dd class="col-sm-9"><?php echo $txt_btn_action; ?></dd>
            </dl>
            <?php
        }
        ?>
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="lead">Detalhes da Página Home</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <?php
                    if ($this->dados['button']['edit_home_det']) {
                        echo "<a href='" . URLADM . "edit-home-det/index' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                    }
                    ?>                         
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->dados['button']['edit_home_det']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "edit-home-det/index'>Editar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>  
        <hr class="hr-title">
        <?php
        if (!empty($this->dados['viewHomeDet'][0])) {
            extract($this->dados['viewHomeDet'][0]);
            ?>
            <dl class="row">

                <?php
                if (!empty($image) AND (file_exists("app/sts/assets/image/home_det/$image"))) {
                    $image = URLADM . "app/sts/assets/image/home_det/$image";
                } else {
                    $image = URLADM . "app/sts/assets/image/home_det/icon_detalhes_servico.png";
                }
                ?>

                <dt class="col-sm-3">Imagem</dt>
                <dd class="col-sm-9 mb-4">
                    <div class="img-edit">
                        <img src="<?php echo $image; ?>" alt="<?php echo $title_action; ?>" class="img-thumbnail view-img-size-sts">
                        <div class="edit">
                            <a href="<?php echo URLADM . 'edit-home-det-img/index'; ?>" class="btn btn-outline-warning btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </dd>

                <dt class="col-sm-3">Título</dt>
                <dd class="col-sm-9"><?php echo $title_det; ?></dd>

                <dt class="col-sm-3">Subtítulo</dt>
                <dd class="col-sm-9"><?php echo $subtitle_det; ?></dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?php echo $description_det; ?></dd>
            </dl>
            <?php
        }
        ?>
    </div>
</div>
