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
                <h2 class="display-4 title">Detalhes do E-mail</h2>
            </div>
            <?php
            if (!empty($this->dados['viewConfEmails'])) {
                extract($this->dados['viewConfEmails'][0]);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_conf_emails']) {
                            echo "<a href='" . URLADM . "list-conf-emails/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['edit_conf_emails']) {
                            echo "<a href='" . URLADM . "edit-conf-emails/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['button']['edit_conf_emails_password']) {
                            echo "<a href='" . URLADM . "edit-conf-emails-password/index/$id' class='btn btn-outline-warning btn-sm'>Editar Senha</a> ";
                        }
                        if ($this->dados['button']['delete_conf_emails']) {
                            echo "<a href='" . URLADM . "delete-conf-emails/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_conf_emails']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-conf-emails/index'>Listar</a>";
                            }
                            if ($this->dados['button']['edit_conf_emails']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-conf-emails/index/$id'>Editar</a>";
                            }
                            if ($this->dados['button']['edit_conf_emails_password']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-conf-emails-password/index/$id'>Editar Senha</a>";
                            }
                            if ($this->dados['button']['delete_conf_emails']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-conf-emails/index/$id' data-confirm='Excluir'>Apagar</a>";
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

        if (!empty($this->dados['viewConfEmails'])) {
            ?>
            <dl class="row">                

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Título</dt>
                <dd class="col-sm-9"><?php echo $title; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $name; ?></dd>

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9"><?php echo $email; ?></dd>

                <dt class="col-sm-3">Host</dt>
                <dd class="col-sm-9"><?php echo $host; ?></dd>

                <dt class="col-sm-3">Usuário</dt>
                <dd class="col-sm-9"><?php echo $username; ?></dd>

                <dt class="col-sm-3">SMTP</dt>
                <dd class="col-sm-9"><?php echo $smtpsecure; ?></dd>

                <dt class="col-sm-3">Porta</dt>
                <dd class="col-sm-9"><?php echo $port; ?></dd>
            </dl>
            <?php
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro: Configuração de e-mail não encontrada!</div>";
        }
        ?>
    </div>
</div>
