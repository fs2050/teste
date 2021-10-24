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
                <h2 class="display-4 title">Listar Sobre Empresa</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['add_abouts_comp']) {
                    echo "<a href='" . URLADM . "add-abouts-comp/index' class='btn btn-outline-success btn-sm'>Cadastrar</a>";
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
                        <th>ID</th>
                        <th>Título</th>
                        <th class="d-none d-sm-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->dados['listAboutsComp'] as $aboutsComp) {
                        extract($aboutsComp);
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $title; ?></td>
                            <td class="d-none d-sm-table-cell">
                                <?php
                                if ($this->dados['button']['edit_abouts_comp_sit']) {
                                    if ($sts_situation_id == 1) {
                                        echo "<a href='" . URLADM . "edit-abouts-comp-sit/index?id=$id&pag=" . $this->dados['pag'] . "'><span class='badge badge-success'>Ativo</span></a>";
                                    } else {
                                        echo "<a href='" . URLADM . "edit-abouts-comp-sit/index?id=$id&pag=" . $this->dados['pag'] . "'><span class='badge badge-danger'>Inativo</span></a>";
                                    }
                                }else{
                                    if ($sts_situation_id == 1) {
                                        echo "<span class='badge badge-success'>Ativo</span>";
                                    } else {
                                        echo "<span class='badge badge-danger'>Inativo</span>";
                                    }
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-lg-block">
                                    <?php
                                    if ($this->dados['button']['view_abouts_comp']) {
                                        echo "<a href='" . URLADM . "view-abouts-comp/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->dados['button']['edit_abouts_comp']) {
                                        echo "<a href='" . URLADM . "edit-abouts-comp/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
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
