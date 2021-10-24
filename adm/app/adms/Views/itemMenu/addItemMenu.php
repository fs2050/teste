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
                <h2 class="display-4 title">Cadastrar Item de Menu</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['list_item_menu']) {
                    echo "<a href='" . URLADM . "list-item-menu/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
        <form id="item_menu" method="POST" action="">            

            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome do item de menu"  value="<?php
                if (isset($valorForm['name'])) {
                    echo $valorForm['name'];
                }
                ?>" required autofocus>
            </div>            

            <div class="form-group">
                <label for="icon"><span class="text-danger">*</span> Ícone: <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                            <i class="fas fa-question-circle"></i>
                        </span></label>
                <input name="icon" type="text" class="form-control" id="icon" placeholder="Ícone"  value="<?php
                if (isset($valorForm['icon'])) {
                    echo $valorForm['icon'];
                }
                ?>" required autofocus>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="AddItemMenu" type="submit" class="btn btn-outline-success btn-sm" value="Cadastrar"> 

        </form>

    </div>
</div>