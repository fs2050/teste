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
                <h2 class="display-4 title">Editar Conteúdo do Topo</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['view_page_home']) {
                            echo "<a href='" . URLADM . "view-page-home/index' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['view_page_home']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "view-page-home/index'>Visualizar</a>";
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
        <form id="edit_home_top" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="title_top"><span class="text-danger">*</span> Título:</label>
                <input name="title_top" type="text" class="form-control" id="title_top" placeholder="Título da área do topo do site"  value="<?php
                if (isset($valorForm['title_top'])) {
                    echo $valorForm['title_top'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="description_top"><span class="text-danger">*</span> Descrição:</label>
                <input name="description_top" type="text" class="form-control" id="description_top" placeholder="Descrição da área do topo do site"  value="<?php
                if (isset($valorForm['description_top'])) {
                    echo $valorForm['description_top'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="link_btn_top"><span class="text-danger">*</span> Link do Botão:</label>
                <input name="link_btn_top" type="text" class="form-control" id="link_btn_top" placeholder="Link do Botão da área do topo do site"  value="<?php
                if (isset($valorForm['link_btn_top'])) {
                    echo $valorForm['link_btn_top'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="txt_btn_top"><span class="text-danger">*</span> Texto do Botão:</label>
                <input name="txt_btn_top" type="text" class="form-control" id="txt_btn_top" placeholder="Texto do Botão da área do topo do site"  value="<?php
                if (isset($valorForm['txt_btn_top'])) {
                    echo $valorForm['txt_btn_top'];
                }
                ?>" required>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditHomeTop" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>