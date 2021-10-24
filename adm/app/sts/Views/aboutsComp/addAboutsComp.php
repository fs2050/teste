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
                <h2 class="display-4 title">Cadastrar Sobre Empresa</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['list_abouts_comp']) {
                    echo "<a href='" . URLADM . "list-abouts-comp/index' class='btn btn-outline-info btn-sm'>Listar</a>";
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
        <form id="abouts_comp" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title"><span class="text-danger">*</span> Título:</label>
                <input name="title" type="text" class="form-control" id="title" placeholder="Título do sobre empresa"  value="<?php
                if (isset($valorForm['title'])) {
                    echo $valorForm['title'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="description"><span class="text-danger">*</span> Descrição:</label>
                <input name="description" type="text" class="form-control" id="description" placeholder="Descrição do sobre empresa"  value="<?php
                if (isset($valorForm['description'])) {
                    echo $valorForm['description'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="sts_situation_id"><span class="text-danger">*</span> Situação</label>
                <select name="sts_situation_id" id="sts_situation_id" class="form-control">
                    <?php
                    if (isset($valorForm['sts_situation_id']) AND $valorForm['sts_situation_id'] == 1) {
                        echo "<option value=''>Selecione</option>";
                        echo "<option value='1' selected>Ativo</option>";
                        echo "<option value='2'>Inativo</option>";
                    } elseif (isset($valorForm['sts_situation_id']) AND $valorForm['sts_situation_id'] == 2) {
                        echo "<option value=''>Selecione</option>";
                        echo "<option value='1'>Ativo</option>";
                        echo "<option value='2' selected>Inativo</option>";
                    } else {
                        echo "<option value='' selected>Selecione</option>";
                        echo "<option value='1'>Ativo</option>";
                        echo "<option value='2'>Inativo</option>";
                    }
                    ?>
                </select>
            </div>
            
            <?php
            if (isset($valorForm['image']) AND (!empty($valorForm['image'])) AND (file_exists('app/sts/assets/image/about_company/' . $valorForm['id'] . '/' . $valorForm['image']))) {
                $old_image = URLADM . 'app/sts/assets/image/about_company/' . $valorForm['id'] . '/' . $valorForm['image'];
            } else {
                $old_image = URLADM . 'app/sts/assets/image/about_company/icon_about_company.jpg';
            }
            ?>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="new_image"><span class="text-danger">*</span> Imagem</label>
                    <input name="new_image" type="file" class="form-control-file" id="new_image">
                </div>

                <div class="form-group col-md-6">
                    <img src="<?php echo $old_image; ?>" alt="Sobre Empresa" id="preview-img" class="img-thumbnail view-img-size-sts">
                </div>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="AddAboutsComp" type="submit" class="btn btn-outline-success btn-sm" value="Cadastrar"> 

        </form>

    </div>
</div>


