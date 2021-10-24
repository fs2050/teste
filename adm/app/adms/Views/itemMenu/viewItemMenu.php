<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Detalhes do Item de Menu</h2>
            </div>
            <?php
            if (!empty($this->dados['viewItemMenu'])) {
                extract($this->dados['viewItemMenu'][0]);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_item_menu']) {
                            echo "<a href='" . URLADM . "list-item-menu/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['edit_item_menu']) {
                            echo "<a href='" . URLADM . "edit-item-menu/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['button']['delete_item_menu']) {
                            echo "<a href='" . URLADM . "delete-item-menu/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a> ";
                        }
                        ?> 
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_item_menu']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-item-menu/index'>Listar</a>";
                            }
                            if ($this->dados['button']['edit_item_menu']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-item-menu/index/$id'>Editar</a>";
                            }
                            if ($this->dados['button']['delete_item_menu']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-item-menu/index/$id' data-confirm='Excluir'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        if (!empty($this->dados['viewItemMenu'])) {
            ?>
            <dl class="row">                

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $name; ?></dd>

                <dt class="col-sm-3">Ordem</dt>
                <dd class="col-sm-9"><?php echo $order_item_menu; ?></dd>
                
                <dt class="col-sm-3">Ícone</dt>
                <dd class="col-sm-9">
                    <?php echo "<i class='" . $icon . "'></i> - " . $icon; ?>
                </dd>
            </dl>
            <?php
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro: Item de menu não encontrado!</div>";
        }
        ?>
    </div>
</div>