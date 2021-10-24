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
                <h2 class="display-4 title">Cadastrar Tipo de Página</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['list_types_pages']) {
                    echo "<a href='" . URLADM . "list-types-pages/index' class='btn btn-outline-info btn-sm'>Listar</a>";
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
        <form id="types_pages" method="POST" action="">
            <div class="form-group">
                <label for="type"><span class="text-danger">*</span> Tipo:</label>
                <input name="type" type="text" class="form-control" id="type" placeholder="Tipo de página"  value="<?php
                if (isset($valorForm['type'])) {
                    echo $valorForm['type'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome do tipo de página"  value="<?php
                if (isset($valorForm['name'])) {
                    echo $valorForm['name'];
                }
                ?>" required >
            </div>

            <div class="form-group">
                <label> Observação</label>
                <textarea name="obs" class="form-control" rows="3"><?php
                    if (isset($valorForm['obs'])) {
                        echo $valorForm['obs'];
                    }
                    ?></textarea>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="AddTypesPages" type="submit" class="btn btn-outline-success btn-sm" value="Cadastrar"> 

        </form>

    </div>
</div>