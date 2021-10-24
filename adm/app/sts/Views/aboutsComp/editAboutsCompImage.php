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
                <h2 class="display-4 title">Editar Imagem Sobre Empresa</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_abouts_comp']) {
                            echo "<a href='" . URLADM . "list-abouts-comp/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['view_abouts_comp']) {
                            echo "<a href='" . URLADM . "view-abouts-comp/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                        }
                        if ($this->dados['button']['edit_abouts_comp']) {
                            echo "<a href='" . URLADM . "edit-abouts-comp/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['button']['delete_abouts_comp']) {
                            echo "<a href='" . URLADM . "delete-abouts-comp/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a>";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_abouts_comp']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-abouts-comp/index'>Listar</a>";
                            }
                            if ($this->dados['button']['view_abouts_comp']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "view-abouts-comp/index/$id'>Visualizar</a>";
                            }
                            if ($this->dados['button']['edit_abouts_comp']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-abouts-comp/index/$id'>Editar</a>";
                            }
                            if ($this->dados['button']['delete_abouts_comp']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-abouts-comp/index/$id' data-confirm='Excluir'>Apagar</a>";
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

        <form id="edit_img" method="POST" action="" enctype="multipart/form-data">

            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <input name="image" type="hidden" value="<?php
            if (isset($valorForm['image'])) {
                echo $valorForm['image'];
            }
            ?>">

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

            <input name="EditAboutsCompImage" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>        

    </div>
</div>