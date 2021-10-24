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
                <h2 class="display-4 title">Detalhes Sobre Empresa</h2>
            </div>
            <?php
            if (!empty($this->dados['viewAboutsComp'])) {
                extract($this->dados['viewAboutsComp'][0]);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_abouts_comp']) {
                            echo "<a href='" . URLADM . "list-abouts-comp/index' class='btn btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['edit_abouts_comp']) {
                            echo "<a href='" . URLADM . "edit-abouts-comp/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['button']['delete_abouts_comp']) {
                            echo "<a href='" . URLADM . "delete-abouts-comp/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a>";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_abouts_comp']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-abouts-comp/index'>Listar</a>";
                            }
                            if ($this->dados['button']['edit_abouts_comp']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-abouts-comp/index/$id'>Editar</a>";
                            }
                            if ($this->dados['button']['delete_abouts_comp']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-abouts-comp/index/$id' data-confirm='Excluir'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        if (!empty($this->dados['viewAboutsComp'])) {
            ?>
            <dl class="row">

                <?php
                if (isset($image) AND (!empty($image)) AND (file_exists('app/sts/assets/image/about_company/' . $id . '/' . $image))) {
                    $image = URLADM . 'app/sts/assets/image/about_company/' . $id . '/' . $image;
                } else {
                    $image = URLADM . 'app/sts/assets/image/about_company/icon_about_company.jpg';
                }
                ?>

                <dt class="col-sm-3">Imagem</dt>
                <dd class="col-sm-9 mb-4">
                    <div class="img-edit">
                        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" class="img-thumbnail view-img-size">
                        <div class="edit">
                            <a href="<?php echo URLADM . 'edit-abouts-comp-image/index/' . $id; ?>" class="btn btn-outline-warning btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </dd>

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Título</dt>
                <dd class="col-sm-9"><?php echo $title; ?></dd>

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?php echo $description; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9"><?php echo $sts_situation_id; ?></dd>
                
                <dt class="col-sm-3">Cadastrado</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Editado</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($modified)) {
                        echo date('d/m/Y H:i:s', strtotime($modified));
                    }
                    ?>
                </dd>
            </dl>
            <?php
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
        }
        ?>
    </div>
</div>
