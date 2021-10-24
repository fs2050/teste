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
                <h2 class="display-4 title">Listar Nível de Acesso</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <?php
                    if ($this->dados['button']['add_access_levels']) {
                        echo "<a href='" . URLADM . "add-access-levels/index' class='btn btn-outline-success btn-sm'>Cadastrar</a> ";
                    }
                    if ($this->dados['button']['sync_pages_levels']) {
                        echo "<span id='btn-synchronize'><a href='" . URLADM . "sync-pages-levels/index' class='btn btn-outline-warning btn-sm' onclick='loadBtnSynchronize()'>Sincronizar</a></span>";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->dados['button']['add_access_levels']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "add-access-levels/index'>Cadastrar</a>";
                        }
                        if ($this->dados['button']['sync_pages_levels']) {
                            echo "<span id='link-synchronize'><a class='dropdown-item' href='" . URLADM . "sync-pages-levels/index' onclick='loadLinkSynchronize()'>Sincronizar</a></span>";
                        }
                        ?>
                    </div>
                </div>
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
                    foreach ($this->dados['listAccessLevels'] as $accessLevel) {
                        extract($accessLevel);
                        ?>
                        <tr>
                            <td class="d-none d-sm-table-cell"><?php echo $id; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $order_levels; ?></td>
                            <td class="text-center">
                                <span class="d-none d-lg-block">
                                    <?php
                                    if ($this->dados['button']['order_access_levels']) {
                                        if ($qnt_linhas_exe <= 1 AND ($this->dados['pag'] == 1)) {
                                            echo "<a href='" . URLADM . "order-access-levels/index/$id?pag=" . $this->dados['pag'] . "' class='btn btn-outline-secondary btn-sm disabled'><i class='fas fa-angle-double-up'></i></a> ";
                                        } else {
                                            echo "<a href='" . URLADM . "order-access-levels/index/$id?pag=" . $this->dados['pag'] . "' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                        }
                                    }
                                    if ($this->dados['button']['list_permission']) {
                                        echo "<a href='" . URLADM . "list-permission/index?level=$id' class='btn btn-outline-info btn-sm'>Permissão</a> ";
                                    }
                                    if ($this->dados['button']['view_access_levels']) {
                                        echo "<a href='" . URLADM . "view-access-levels/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->dados['button']['edit_access_levels']) {
                                        echo "<a href='" . URLADM . "edit-access-levels/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->dados['button']['delete_access_levels']) {
                                        echo "<a href='" . URLADM . "delete-access-levels/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a> ";
                                    }
                                    ?>                                     
                                </span>
                                <div class="dropdown d-block d-lg-none">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->dados['button']['order_access_levels']) {
                                            if ($qnt_linhas_exe <= 1 AND ($this->dados['pag'] == 1)) {
                                                echo "<a class='dropdown-item disabled' href='" . URLADM . "order-access-levels/index/$id?pag=" . $this->dados['pag'] . "'>Ordem</a>";
                                            } else {
                                                echo "<a class='dropdown-item' href='" . URLADM . "order-access-levels/index/$id?pag=" . $this->dados['pag'] . "'>Ordem</a>";
                                            }
                                            $qnt_linhas_exe++;
                                        }
                                        if ($this->dados['button']['view_access_levels']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-access-levels/index/$id'>Visualizar</a>";
                                        }
                                        if ($this->dados['button']['edit_access_levels']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-access-levels/index/$id'>Editar</a>";
                                        }
                                        if ($this->dados['button']['delete_access_levels']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-access-levels/index/$id' data-confirm='Excluir'>Apagar</a>";
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
