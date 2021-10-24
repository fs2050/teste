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
                <h2 class="display-4 title">Listar Item de Menu</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['add_item_menu']) {
                    echo "<a href='" . URLADM . "add-item-menu/index' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                }
                ?>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">ID</th>
                        <th>Nome</th>
                        <th>Ordem</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qnt_linhas_exe = 1;
                    foreach ($this->dados['listItemMenu'] as $itemMenu) {
                        extract($itemMenu);
                        ?>
                        <tr>
                            <td class="d-none d-sm-table-cell"><?php echo $id; ?></td>
                            <td>
                                <?php echo $name; ?>
                            </td>
                            <td><?php echo $order_item_menu; ?></td>
                            <td class="text-center">
                                <span class="d-none d-lg-block">
                                    <?php
                                    if ($this->dados['button']['order_item_menu']) {
                                        echo "<a href='" . URLADM . "order-item-menu/index/$id?pag=" . $this->dados['pag'] . "' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                    }
                                    if ($this->dados['button']['view_item_menu']) {
                                        echo "<a href='" . URLADM . "view-item-menu/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
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
                                        if ($this->dados['button']['order_item_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "order-item-menu/index/$id?pag=" . $this->dados['pag'] . "'>Ordem</a>";
                                        }
                                        if ($this->dados['button']['view_item_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-item-menu/index/$id'>Visualizar</a>";
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
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php echo $this->dados['pagination']; ?>
        </div>
    </div>
</div>