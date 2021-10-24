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
                <h2 class="display-4 title">Detalhes do Usuário</h2>
            </div>
            <?php
            if (!empty($this->dados['viewUser'])) {
                extract($this->dados['viewUser'][0]);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_users']) {
                            echo "<a href='" . URLADM . "list-users/index' class='btn btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['edit_users']) {
                            echo "<a href='" . URLADM . "edit-users/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['button']['edit_users_password']) {
                            echo "<a href='" . URLADM . "edit-users-password/index/$id' class='btn btn-outline-warning btn-sm'>Editar Senha</a> ";
                        }
                        if ($this->dados['button']['delete_users']) {
                            echo "<a href='" . URLADM . "delete-users/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar Senha</a>";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_users']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-users/index'>Listar</a>";
                            }
                            if ($this->dados['button']['edit_users']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-users/index/$id'>Editar</a>";
                            }
                            if ($this->dados['button']['edit_users_password']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-users-password/index/$id'>Editar Senha</a>";
                            }
                            if ($this->dados['button']['delete_users']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-users/index/$id' data-confirm='Excluir'>Apagar</a>";
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

        if (!empty($this->dados['viewUser'])) {
            ?>
            <dl class="row">

                <?php
                if (isset($image) AND (!empty($image)) AND (file_exists('app/adms/assets/image/users/' . $id . '/' . $image))) {
                    $image = URLADM . 'app/adms/assets/image/users/' . $id . '/' . $image;
                } else {
                    $image = URLADM . 'app/adms/assets/image/users/icon_user.png';
                }
                ?>

                <dt class="col-sm-3">Imagem</dt>
                <dd class="col-sm-9 mb-4">
                    <div class="img-edit">
                        <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" class="img-thumbnail view-img-size">
                        <div class="edit">
                            <a href="<?php echo URLADM . 'edit-users-image/index/' . $id; ?>" class="btn btn-outline-warning btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </dd>

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $name; ?></dd>

                <dt class="col-sm-3">Apelido</dt>
                <dd class="col-sm-9"><?php echo $nickname; ?></dd>

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9"><?php echo $email; ?></dd>

                <dt class="col-sm-3">Usuário</dt>
                <dd class="col-sm-9"><?php echo $username; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9"><span class="badge badge-<?php echo $color; ?>"><?php echo $name_sit; ?></span></dd>

                <dt class="col-sm-3">Nível de Acesso</dt>
                <dd class="col-sm-9"><?php echo $name_lev; ?></dd>
            </dl>
            <?php
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
        }
        ?>
    </div>
</div>
