<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

if (isset($this->dados['form'])) {
    $valorForm = $this->dados['form'];
}

if (isset($this->dados['form'][0])) {
    $valorForm = $this->dados['form'][0];
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar E-mail</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_conf_emails']) {
                            echo "<a href='" . URLADM . "list-conf-emails/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['view_conf_emails']) {
                            echo "<a href='" . URLADM . "view-conf-emails/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
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
                            if ($this->dados['button']['view_conf_emails']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "view-conf-emails/index/$id'>Visualizar</a>";
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

        <span class="msg"></span>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form id="edit_conf_email" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="title"><span class="text-danger">*</span> Título:</label>
                <input name="title" type="text" class="form-control" id="title" placeholder="Título para identificar o e-mail"  value="<?php
                if (isset($valorForm['title'])) {
                    echo $valorForm['title'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome que será apresentado no remetente"  value="<?php
                if (isset($valorForm['name'])) {
                    echo $valorForm['name'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="email"><span class="text-danger">*</span> E-mail:</label>
                <input name="email" type="text" class="form-control" id="email" placeholder="E-mail que será apresentado no remetente"  value="<?php
                if (isset($valorForm['email'])) {
                    echo $valorForm['email'];
                }
                ?>" required>
            </div> 

            <div class="form-group">
                <label for="host"><span class="text-danger">*</span> Host:</label>
                <input name="host" type="text" class="form-control" id="host" placeholder="Servidor utilizado para enviar o e-mail"  value="<?php
                if (isset($valorForm['host'])) {
                    echo $valorForm['host'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="username"><span class="text-danger">*</span> Usuário:</label>
                <input name="username" type="text" class="form-control" id="username" placeholder="Usuário do e-mail, na maioria dos casos é o próprio e-mail"  value="<?php
                if (isset($valorForm['username'])) {
                    echo $valorForm['username'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="smtpsecure"><span class="text-danger">*</span> SMTP:</label>
                <input name="smtpsecure" type="text" class="form-control" id="smtpsecure" placeholder="SMTP"  value="<?php
                if (isset($valorForm['smtpsecure'])) {
                    echo $valorForm['smtpsecure'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="port"><span class="text-danger">*</span> Porta:</label>
                <input name="port" type="text" class="form-control" id="port" placeholder="Porta utilizada para enviar o e-mail"  value="<?php
                if (isset($valorForm['port'])) {
                    echo $valorForm['port'];
                }
                ?>" required>
            </div>


            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditConfEmails" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>