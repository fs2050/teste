<?php
if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}
if (isset($this->dados['form'])) {
    $valorForm = $this->dados['form'];
}
?>
<form id="update_password" method="POST" action="" class="form-signin">
    
    <div class="text-center mb-4">
        <img class="mb-4" src="<?php echo URLADM; ?>app/adms/assets/image/logo_login/logo.png" alt="Celke" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal text-light">Atualizar a Senha</h1>
    </div>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>
    <span class="msg"></span>

    <div class="form-label-group">
        <input name="password" type="password" id="password" class="form-control" placeholder="Digite a senha" value="<?php
        if (isset($valorForm['password'])) {
            echo $valorForm['password'];
        }
        ?>" onkeyup="passwordStrength()" required>
        <label for="password">Senha</label>
        <span id="msgViewStrength"></span>
    </div>

    <input name="UpPassword" type="submit" value="Salvar" class="btn btn-lg btn-primary btn-block">   

    <p class="mt-2 mb-3 text-muted text-center">
        <a href="<?php echo URLADM; ?>login/index" class="text-decoration-none">Clique aqui</a> para acessar.
    </p> 
</form>
