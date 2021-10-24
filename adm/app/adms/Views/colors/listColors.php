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
                <h2 class="display-4 title">Listar Cores</h2>
            </div>
            <div class="p-2">
                <?php
                if ($this->dados['button']['add_colors']) {
                    echo "<a href='" . URLADM . "add-colors/index' class='btn btn-outline-success btn-sm'>Cadastrar</a>";
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
                        <th>Nome da Cor</th>
                        <th class="d-none d-sm-table-cell">Cor</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->dados['listColors'] as $color) {
                        extract($color);
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $name; ?></td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-<?php echo $color; ?>"><?php echo $color; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-lg-block">
                                    <?php
                                    if ($this->dados['button']['view_colors']) {
                                        echo "<a href='" . URLADM . "view-colors/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->dados['button']['edit_colors']) {
                                        echo "<a href='" . URLADM . "edit-colors/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->dados['button']['delete_colors']) {
                                        echo "<a href='" . URLADM . "delete-colors/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a> ";
                                    }
                                    ?>                                     
                                </span>
                                <div class="dropdown d-block d-lg-none">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->dados['button']['view_colors']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "view-colors/index/$id'>Visualizar</a>";
                                        }
                                        if ($this->dados['button']['edit_colors']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "edit-colors/index/$id'>Editar</a>";
                                        }
                                        if ($this->dados['button']['delete_colors']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "delete-colors/index/$id' data-confirm='Excluir'>Apagar</a>";
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
