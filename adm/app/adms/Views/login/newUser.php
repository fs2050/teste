<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
if (isset($this->dados['form'])) {
    $valorForm = $this->dados['form'];
}
?>
<form id="new_user" method="POST" action="" class="form-signin">

    <div class="text-center mb-4">
        <img class="mb-4" src="<?php echo URLADM; ?>app/adms/assets/image/logo_login/logo.png" alt="Celke" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal text-light">Novo Usuário</h1>
    </div>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>
    <span class="msg"></span>

    <div class="form-label-group">
        <input name="name" type="text" id="name" class="form-control" placeholder="Digite o nome completo" value="<?php
        if (isset($valorForm['name'])) {
            echo $valorForm['name'];
        }
        ?>" autofocus required>
        <label for="name">Nome</label>
    </div>

    <div class="form-label-group">
        <input name="email" type="email" id="email" class="form-control" placeholder="Digite o seu melhor e-mail" value="<?php
        if (isset($valorForm['email'])) {
            echo $valorForm['email'];
        }
        ?>" required>
        <label for="email">E-mail</label>
    </div>

    <div class="form-label-group">
        <input name="password" type="password" id="password" class="form-control" placeholder="Digite a senha" value="<?php
        if (isset($valorForm['password'])) {
            echo $valorForm['password'];
        }
        ?>" onkeyup="passwordStrength()" required>
        <label for="password">Senha</label>
        <span id="msgViewStrength"></span>
    </div>

    <input name="SendNewUser" type="submit" value="Cadastrar" class="btn btn-lg btn-primary btn-block">    

    <p class="mt-2 mb-3 text-muted text-center">
        <a href="<?php echo URLADM; ?>login/index" class="text-decoration-none">Clique aqui</a> para acessar.
    </p>
</form>