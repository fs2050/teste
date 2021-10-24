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
                <h2 class="display-4 title">Editar Sobre Empresa</h2>
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
                        if ($this->dados['button']['delete_abouts_comp']) {
                            echo "<a href='" . URLADM . "delete-abouts-comp/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a> ";
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
        <form id="form_color" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

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

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditAboutsComp" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>