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
                <h2 class="display-4 title">Detalhes da Situação para Usuário</h2>
            </div>
            <?php
            if (!empty($this->dados['viewSitsUser'])) {
                extract($this->dados['viewSitsUser'][0]);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_sits_users']) {
                            echo "<a href='" . URLADM . "list-sits-users/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['edit_sits_users']) {
                            echo "<a href='" . URLADM . "edit-sits-users/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['button']['delete_sits_users']) {
                            echo "<a href='" . URLADM . "delete-sits-users/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a>";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_sits_users']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-sits-users/index'>Listar</a>";
                            }
                            if ($this->dados['button']['edit_sits_users']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-sits-users/index/$id'>Editar</a>";
                            }
                            if ($this->dados['button']['delete_sits_users']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-sits-users/index/$id' data-confirm='Excluir'>Apagar</a>";
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

        if (!empty($this->dados['viewSitsUser'])) {
            ?>
            <dl class="row">                

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><span class="badge badge-<?php echo $color; ?>"><?php echo $name; ?></span></dd>
            </dl>
            <?php
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
        }
        ?>
    </div>
</div>
