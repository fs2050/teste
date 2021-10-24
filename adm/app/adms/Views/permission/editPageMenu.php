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
                <h2 class="display-4 title">Editar Item de Menu da Página</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_permission']) {
                            echo "<a href='" . URLADM . "list-permission/index/{$this->dados['btnPag']}?level={$this->dados['btnLevel']}' class='btn btn-outline-info btn-sm'>Listar Permissão</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_permission']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-permission/index/{$this->dados['btnPag']}?level={$this->dados['btnLevel']}'>Listar</a>";
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
        <form id="edit_page_menu" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="adms_items_menu_id"><span class="text-danger">*</span> Item de Menu</label>
                <select name="adms_items_menu_id" id="adms_items_menu_id" class="form-control">
                    <option value="">Selecione</option>
                    <?php
                    foreach ($this->dados['select']['itm'] as $itm) {
                        extract($itm);
                        if ((isset($valorForm['adms_items_menu_id'])) AND $valorForm['adms_items_menu_id'] == $id_itm) {
                            echo "<option value='$id_itm' selected>$name_itm</option>";
                        } else {
                            echo "<option value='$id_itm'>$name_itm</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditPageMenu" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>
