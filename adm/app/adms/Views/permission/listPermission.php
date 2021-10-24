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
                <h2 class="display-4 title">Listar Permissão</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['list_access_levels']) {
                    echo "<a href='" . URLADM . "list-access-levels/index' class='btn btn-outline-info btn-sm'>Listar Nível de Acesso</a> ";
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
                        <th>Página</th>
                        <th class="d-none d-sm-table-cell">Permissão</th>
                        <th class="d-none d-sm-table-cell">Menu</th>
                        <th class="d-none d-sm-table-cell">Dropdown</th>
                        <th>Ordem</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qnt_linhas_exe = 1;
                    foreach ($this->dados['listPermission'] as $permission) {
                        extract($permission);
                        ?>
                        <tr>
                            <td class="d-none d-sm-table-cell"><?php echo $id; ?></td>
                            <td><?php echo $name_page; ?></td>
                            <td class="d-none d-sm-table-cell">
                                <?php
                                if ($this->dados['button']['edit_permission']) {
                                    if ($permission == 1) {
                                        echo "<a href='" . URLADM . "edit-permission/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "'><span class='badge badge-success'>Liberado</span></a>";
                                    } else {
                                        echo "<a href='" . URLADM . "edit-permission/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "'><span class='badge badge-danger'>Bloqueado</span></a>";
                                    }
                                } else {
                                    if ($permission == 1) {
                                        echo "<span class='badge badge-success'>Liberado</span>";
                                    } else {
                                        echo "<span class='badge badge-danger'>Bloqueado</span>";
                                    }
                                }
                                ?>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <?php
                                if ($this->dados['button']['edit_print_menu']) {
                                    if ($print_menu == 1) {
                                        echo "<a href='" . URLADM . "edit-print-menu/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "'><span class='badge badge-success'>Liberado</span></a>";
                                    } else {
                                        echo "<a href='" . URLADM . "edit-print-menu/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "'><span class='badge badge-danger'>Bloqueado</span></a>";
                                    }
                                }else{
                                    if ($print_menu == 1) {
                                        echo "<span class='badge badge-success'>Liberado</span>";
                                    } else {
                                        echo "<span class='badge badge-danger'>Bloqueado</span>";
                                    }
                                }
                                ?>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <?php
                                if ($this->dados['button']['edit_dropdown_menu']) {
                                    if ($dropdown == 1) {
                                        echo "<a href='" . URLADM . "edit-dropdown-menu/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "'><span class='badge badge-success'>Sim</span></a>";
                                    } else {
                                        echo "<a href='" . URLADM . "edit-dropdown-menu/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "'><span class='badge badge-danger'>Não</span></a>";
                                    }
                                }else{
                                    if ($dropdown == 1) {
                                        echo "<span class='badge badge-success'>Sim</span>";
                                    } else {
                                        echo "<span class='badge badge-danger'>Não</span>";
                                    }
                                }
                                ?>
                            </td>
                            
                            <td><?php echo $order_level_page; ?></td>
                            <td class="text-center">
                                <span class="d-none d-lg-block">
                                    <?php
                                    if ($this->dados['button']['order_page_menu']) {
                                        echo "<a href='" . URLADM . "order-page-menu/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                    }  
                                    
                                    if ($this->dados['button']['edit_page_menu']) {
                                        echo "<a href='" . URLADM . "edit-page-menu/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    } 
                                    ?> 
                                </span>
                                <div class="dropdown d-block d-lg-none">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->dados['button']['order_page_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "order-page-menu/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "'>Ordem</a>";
                                        }
                                        if ($this->dados['button']['edit_page_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-page-menu/index?id=$id&level=$adms_access_level_id&pag=" . $this->dados['pag'] . "'>Editar</a>";
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
