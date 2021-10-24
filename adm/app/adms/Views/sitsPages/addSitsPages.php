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
                <h2 class="display-4 title">Cadastrar Situação de Página</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['list_sits_pages']) {
                    echo "<a href='" . URLADM . "list-sits-pages/index' class='btn btn-outline-info btn-sm'>Listar</a>";
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
        <form id="sits_pages" method="POST" action="">
            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome da situação de página"  value="<?php
                if (isset($valorForm['name'])) {
                    echo $valorForm['name'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="adms_color_id">Cor</label>
                <select name="adms_color_id" id="adms_color_id" class="form-control">
                    <option value="">Selecione</option>
                    <?php
                    foreach ($this->dados['select']['cor'] as $cor) {
                        extract($cor);
                        if ((isset($valorForm['adms_color_id'])) AND $valorForm['adms_color_id'] == $id_cor) {
                            echo "<option value='$id_cor' selected>$name_cor</option>";
                        } else {
                            echo "<option value='$id_cor'>$name_cor</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="AddSitsPages" type="submit" class="btn btn-outline-success btn-sm" value="Cadastrar"> 

        </form>

    </div>
</div>
