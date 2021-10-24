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
                <h2 class="display-4 title">Perfil</h2>
            </div>
            <?php
            if (!empty($this->dados['perfil'])) {
                extract($this->dados['perfil'][0]);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['edit_perfil']) {
                            echo "<a href='" . URLADM . "edit-perfil/index' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['button']['edit_perfil_password']) {
                            echo "<a href='" . URLADM . "edit-perfil-password/index' class='btn btn-outline-warning btn-sm'>Editar Senha</a>";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['edit_perfil']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-perfil/index'>Editar</a>";
                            }
                            if ($this->dados['button']['edit_perfil_password']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-perfil-password/index'>Editar Senha</a>";
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

        if (!empty($this->dados['perfil'])) {
            ?>
            <dl class="row">

                <?php
                if (!empty($image) AND (file_exists("app/adms/assets/image/users/" . $_SESSION['user_id'] . "/$image"))) {
                    $image = URLADM . "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/$image";
                } else {
                    $image = URLADM . "app/adms/assets/image/users/icon_user.png";
                }
                ?>

                <dt class="col-sm-3">Imagem</dt>
                <dd class="col-sm-9 mb-4">
                    <div class="img-edit">
                        <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" class="img-thumbnail view-img-size">
                        <div class="edit">
                            <a href="<?php echo URLADM . 'edit-perfil-image/index'; ?>" class="btn btn-outline-warning btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $name; ?></dd>

                <dt class="col-sm-3">Apelido</dt>
                <dd class="col-sm-9"><?php echo $nickname; ?></dd>

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9"><?php echo $email; ?></dd>

                <dt class="col-sm-3">Usuário</dt>
                <dd class="col-sm-9"><?php echo $username; ?></dd>
            </dl>
            <?php
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
        }
        ?>
    </div>
</div>
