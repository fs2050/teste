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
                <h2 class="display-4 title">Cadastrar Mensagem de Contato</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['list_contact_msg']) {
                    echo "<a href='" . URLADM . "list-contact-msg/index' class='btn btn-outline-info btn-sm'>Listar</a>";
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
        <form id="add_contact_msg" method="POST" action="">
            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome completo"  value="<?php
                if (isset($valorForm['name'])) {
                    echo $valorForm['name'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="email"><span class="text-danger">*</span> E-mail:</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Melhor e-mail"  value="<?php
                if (isset($valorForm['email'])) {
                    echo $valorForm['email'];
                }
                ?>" required>
            </div>
            
            <div class="form-group">
                <label for="subject"><span class="text-danger">*</span> Assunto:</label>
                <input name="subject" type="text" class="form-control" id="subject" placeholder="Assunto da mensagem"  value="<?php
                if (isset($valorForm['subject'])) {
                    echo $valorForm['subject'];
                }
                ?>" required >
            </div>
            
            <div class="form-group">
                <label for="content"><span class="text-danger">*</span> Conteúdo:</label>
                <input name="content" type="text" class="form-control" id="content" placeholder="Conteúdo da mensagem"  value="<?php
                if (isset($valorForm['content'])) {
                    echo $valorForm['content'];
                }
                ?>" required >
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="AddContactMsg" type="submit" class="btn btn-outline-success btn-sm" value="Cadastrar"> 

        </form>

    </div>
</div>


