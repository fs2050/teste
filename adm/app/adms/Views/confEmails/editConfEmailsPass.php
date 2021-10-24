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
                <h2 class="display-4 title">Editar Senha do E-mail</h2>
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
                        if ($this->dados['button']['edit_conf_emails']) {
                            echo "<a href='" . URLADM . "edit-conf-emails/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
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
                            if ($this->dados['button']['edit_conf_emails']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-conf-emails/index/$id'>Editar</a>";
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
        <form id="edit_conf_email_pass" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="password"><span class="text-danger">*</span> Senha:</label>
                <input name="password" type="text" class="form-control" id="password" placeholder="Senha do e-mail"  value="<?php
                if (isset($valorForm['password'])) {
                    echo $valorForm['password'];
                }
                ?>" required>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditConfEmailsPass" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>