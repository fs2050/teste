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
                <h2 class="display-4 title">Listar Grupo de Páginas</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['add_groups_pages']) {
                    echo "<a href='" . URLADM . "add-groups-pages/index' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
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
                    foreach ($this->dados['listGroupsPages'] as $groupsPages) {
                        extract($groupsPages);
                        ?>
                        <tr>
                            <td class="d-none d-sm-table-cell"><?php echo $id; ?></td>
                            <td>
                                <?php echo $name; ?>
                            </td>
                            <td><?php echo $order_group_pg; ?></td>
                            <td class="text-center">
                                <span class="d-none d-lg-block">
                                    <?php
                                    if ($this->dados['button']['order_groups_pages']) {
                                        echo "<a href='" . URLADM . "order-groups-pages/index/$id?pag=" . $this->dados['pag'] . "' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                    }
                                    if ($this->dados['button']['view_groups_pages']) {
                                        echo "<a href='" . URLADM . "view-groups-pages/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->dados['button']['edit_groups_pages']) {
                                        echo "<a href='" . URLADM . "edit-groups-pages/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->dados['button']['delete_groups_pages']) {
                                        echo "<a href='" . URLADM . "delete-groups-pages/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a> ";
                                    }
                                    ?> 
                                </span>
                                <div class="dropdown d-block d-lg-none">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->dados['button']['order_groups_pages']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "order-groups-pages/index/$id?pag=" . $this->dados['pag'] . "'>Ordem</a>";
                                        }
                                        if ($this->dados['button']['view_groups_pages']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-groups-pages/index/$id'>Visualizar</a>";
                                        }
                                        if ($this->dados['button']['edit_groups_pages']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-groups-pages/index/$id'>Editar</a>";
                                        }
                                        if ($this->dados['button']['delete_groups_pages']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-groups-pages/index/$id' data-confirm='Excluir'>Apagar</a>";
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