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
                <h2 class="display-4 title">Editar Página</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_pages']) {
                            echo "<a href='" . URLADM . "list-pages/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['view_pages']) {
                            echo "<a href='" . URLADM . "view-pages/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                        }
                        if ($this->dados['button']['delete_pages']) {
                            echo "<a href='" . URLADM . "delete-pages/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a> ";
                        }
                        ?>                         
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_pages']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-pages/index'>Listar</a>";
                            }
                            if ($this->dados['button']['view_pages']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "view-pages/index/$id'>Visualizar</a>";
                            }
                            if ($this->dados['button']['delete_pages']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-pages/index/$id' data-confirm='Excluir'>Apagar</a>";
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
        <form id="pages" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome da Página</label>
                    <input name="name_page" type="text" id="name_page" class="form-control" placeholder="Nome da Página a ser apresentado no menu" value="<?php
                    if (isset($valorForm['name_page'])) {
                        echo $valorForm['name_page'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Classe</label>
                    <input name="controller" type="text" id="controller" class="form-control" placeholder="Nome da Classe" value="<?php
                    if (isset($valorForm['controller'])) {
                        echo $valorForm['controller'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Método</label>
                    <input name="metodo" type="text" id="metodo" class="form-control" placeholder="Nome do Método" value="<?php
                    if (isset($valorForm['metodo'])) {
                        echo $valorForm['metodo'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Classe no menu</label>
                    <input name="menu_controller" type="text" id="menu_controller" class="form-control" placeholder="Nome da classe no menu" value="<?php
                    if (isset($valorForm['menu_controller'])) {
                        echo $valorForm['menu_controller'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Método no menu</label>
                    <input name="menu_metodo" type="text" id="menu_metodo" class="form-control" placeholder="Nome do método no menu" value="<?php
                    if (isset($valorForm['menu_metodo'])) {
                        echo $valorForm['menu_metodo'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                            <i class="fas fa-question-circle"></i>
                        </span> Ícone</label>
                    <input name="icon" type="text" id="icon" class="form-control" placeholder="Ícone a ser apresentado no menu" value="<?php
                    if (isset($valorForm['icon'])) {
                        echo $valorForm['icon'];
                    }
                    ?>">
                </div>
            </div>


            <div class="form-group">
                <label> Observação</label>
                <textarea name="obs" id="obs" class="form-control" rows="3"><?php
                    if (isset($valorForm['obs'])) {
                        echo $valorForm['obs'];
                    }
                    ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Página Pública</label>
                    <select name="publish" id="publish" class="form-control">
                        <?php
                        if ($valorForm['publish'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['publish'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="adms_sits_pgs_id"><span class="text-danger">*</span> Situação da Página</label>
                    <select name="adms_sits_pgs_id" id="adms_sits_pgs_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ((isset($valorForm['adms_sits_pgs_id'])) AND $valorForm['adms_sits_pgs_id'] == $id_sit) {
                                echo "<option value='$id_sit' selected>$name_sit</option>";
                            } else {
                                echo "<option value='$id_sit'>$name_sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="adms_groups_pgs_id"><span class="text-danger">*</span> Grupo da Página</label>
                    <select name="adms_groups_pgs_id" id="adms_groups_pgs_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->dados['select']['group'] as $group) {
                            extract($group);
                            if ((isset($valorForm['adms_groups_pgs_id'])) AND $valorForm['adms_groups_pgs_id'] == $id_group) {
                                echo "<option value='$id_group' selected>$name_group</option>";
                            } else {
                                echo "<option value='$id_group'>$name_group</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="adms_types_pgs_id"><span class="text-danger">*</span> Tipo da Página</label>
                    <select name="adms_types_pgs_id" id="adms_types_pgs_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->dados['select']['type'] as $type) {
                            extract($type);
                            if ((isset($valorForm['adms_types_pgs_id'])) AND $valorForm['adms_types_pgs_id'] == $id_type) {
                                echo "<option value='$id_type' selected>$name_type</option>";
                            } else {
                                echo "<option value='$id_type'>$name_type</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>            
            <input name="EditPage" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar">            
        </form>
    </div>
</div>