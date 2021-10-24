<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
if (isset($this->dados['form'])) {
    $valorForm = $this->dados['form'];
}
?>
<form id="send_login" method="POST" action="" class="form-signin">

    <div class="text-center mb-4">
        <img class="mb-4" src="<?php echo URLADM; ?>app/adms/assets/image/logo_login/logo.png" alt="Celke" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal text-light">Área Restrita</h1>
    </div>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>
    <span class="msg"></span>

    <div class="form-label-group">
        <input name="username" type="text" id="username" class="form-control" placeholder="Digite o usuário ou e-mail" value="<?php
        if (isset($valorForm['username'])) {
            echo $valorForm['username'];
        }
        ?>" autofocus required>
        <label for="username">Usuário</label>
    </div>

    <div class="form-label-group">
        <input name="password" type="password" id="password" class="form-control" placeholder="Digite a senha" required>
        <label for="password">Senha</label>
    </div>

    <input name="SendLogin" type="submit" value="Acessar" class="btn btn-lg btn-primary btn-block">     

    <p class="mt-2 mb-3 text-muted text-center">
        <a href="<?php echo URLADM; ?>new-user/index" class="text-decoration-none">Cadastrar</a> - 
        <a href="<?php echo URLADM; ?>recover-password/index" class="text-decoration-none">Esqueceu a Senha</a>
    </p>

    <p class="mt-2 mb-3 text-muted text-center">
        Usuário: cesar@celke.com.br<br>
        Senha: 123456a
    </p>

</form>



