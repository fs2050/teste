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
                <h2 class="display-4 title">Editar Situação para Usuário</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_sits_users']) {
                            echo "<a href='" . URLADM . "list-sits-users/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['view_sits_users']) {
                            echo "<a href='" . URLADM . "view-sits-users/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                        }
                        if ($this->dados['button']['delete_sits_users']) {
                            echo "<a href='" . URLADM . "delete-sits-users/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_sits_users']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-sits-users/index'>Listar</a>";
                            }
                            if ($this->dados['button']['view_sits_users']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-sits-users/index/$id'>Editar</a>";
                            }
                            if ($this->dados['button']['delete_sits_users']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-sits-users/index/$id' data-confirm='Excluir'>Apagar</a>";
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
        <form id="sits_user" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome da situação para usuário"  value="<?php
                if (isset($valorForm['name'])) {
                    echo $valorForm['name'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="adms_color_id"><span class="text-danger">*</span> Cor</label>
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

            <input name="EditSitsUser" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>
