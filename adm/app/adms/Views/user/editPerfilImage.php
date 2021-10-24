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
                <h2 class="display-4 title">Editar a Imagem</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['view_perfil']) {
                            echo "<a href='" . URLADM . "view-perfil/index' class='btn btn-outline-primary btn-sm'>Perfil</a> ";
                        }
                        if ($this->dados['button']['edit_perfil']) {
                            echo "<a href='" . URLADM . "edit-perfil/index' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['button']['edit_perfil_password']) {
                            echo "<a href='" . URLADM . "edit-perfil-password/index' class='btn btn-outline-warning btn-sm'>Editar Senha</a>";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['view_perfil']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "view-perfil/index'>Perfil</a>";
                            }
                            if ($this->dados['button']['edit_perfil']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-perfil/index'>Editar</a>";
                            }
                            if ($this->dados['button']['edit_perfil_password']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-perfil-password/index'>Editar Senha</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr class="hr-title">

        <form id="edit_img" method="POST" action="" enctype="multipart/form-data">

            <input name="image" type="hidden" value="<?php
            if (isset($valorForm['image'])) {
                echo $valorForm['image'];
            }
            ?>">

            <?php
            if (isset($valorForm['image']) AND (!empty($valorForm['image'])) AND (file_exists('app/adms/assets/image/users/' . $_SESSION['user_id'] . '/' . $valorForm['image']))) {
                $old_image = URLADM . 'app/adms/assets/image/users/' . $_SESSION['user_id'] . '/' . $valorForm['image'];
            } else {
                $old_image = URLADM . 'app/adms/assets/image/users/icon_user.png';
            }
            ?>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="new_image"><span class="text-danger">*</span> Imagem</label>
                    <input name="new_image" type="file" class="form-control-file" id="new_image">
                </div>

                <div class="form-group col-md-6">
                    <img src="<?php echo $old_image; ?>" alt="Imagem do Perfil" id="preview-img" class="img-thumbnail view-img-size">
                </div>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditPerfilImagem" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>