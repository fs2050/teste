<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
if (isset($this->dados['form'])) {
    $valorForm = $this->dados['form'];
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Cadastrar E-mail</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['list_conf_emails']) {
                    echo "<a href='" . URLADM . "list-conf-emails/index' class='btn btn-outline-info btn-sm'>Listar</a>";
                }
                ?>
            </div>
        </div>
        <hr class="hr-title">
        <span class="msg"></span>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form id="add_conf_email" method="POST" action="">
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
                <label for="password"><span class="text-danger">*</span> Senha:</label>
                <input name="password" type="text" class="form-control" id="password" placeholder="Senha do e-mail"  value="<?php
                if (isset($valorForm['password'])) {
                    echo $valorForm['password'];
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

            <input name="AddConfEmails" type="submit" class="btn btn-outline-success btn-sm" value="Cadastrar"> 

        </form>

    </div>
</div>


