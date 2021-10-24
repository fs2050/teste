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
                <h2 class="display-4 title">Editar Conteúdo do Serviço</h2>
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
        <form id="edit_home_serv" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="title_serv"><span class="text-danger">*</span> Título:</label>
                <input name="title_serv" type="text" class="form-control" id="title_serv" placeholder="Título da área do serviço do site"  value="<?php
                if (isset($valorForm['title_serv'])) {
                    echo $valorForm['title_serv'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="description_serv"><span class="text-danger">*</span> Descrição:</label>
                <input name="description_serv" type="text" class="form-control" id="description_serv" placeholder="Descrição da área do serviço do site"  value="<?php
                if (isset($valorForm['description_serv'])) {
                    echo $valorForm['description_serv'];
                }
                ?>" >
            </div>

            <div class="form-group">
                <label for="titulo_um_serv"><span class="text-danger">*</span> Titulo do Serviço Um:</label>
                <input name="titulo_um_serv" type="text" class="form-control" id="titulo_um_serv" placeholder="Título do Serviço Um"  value="<?php
                if (isset($valorForm['titulo_um_serv'])) {
                    echo $valorForm['titulo_um_serv'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="description_um_serv"><span class="text-danger">*</span> Descrição do Serviço Um:</label>
                <input name="description_um_serv" type="text" class="form-control" id="description_um_serv" placeholder="Descrição do Serviço Um"  value="<?php
                if (isset($valorForm['description_um_serv'])) {
                    echo $valorForm['description_um_serv'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="icone_um_serv"><span class="text-danger">*</span> Ícone do Serviço Um:</label>
                <input name="icone_um_serv" type="text" class="form-control" id="icone_um_serv" placeholder="Ícone do Serviço Um"  value="<?php
                if (isset($valorForm['icone_um_serv'])) {
                    echo $valorForm['icone_um_serv'];
                }
                ?>" required> 
            </div>

            <div class="form-group">
                <label for="titulo_dois_serv"><span class="text-danger">*</span> Titulo do Serviço Dois:</label>
                <input name="titulo_dois_serv" type="text" class="form-control" id="titulo_dois_serv" placeholder="Título do Serviço Dois"  value="<?php
                if (isset($valorForm['titulo_dois_serv'])) {
                    echo $valorForm['titulo_dois_serv'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="description_dois_serv"><span class="text-danger">*</span> Descrição do Serviço Dois:</label>
                <input name="description_dois_serv" type="text" class="form-control" id="description_dois_serv" placeholder="Descrição do Serviço Dois"  value="<?php
                if (isset($valorForm['description_dois_serv'])) {
                    echo $valorForm['description_dois_serv'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="icone_dois_serv"><span class="text-danger">*</span> Ícone do Serviço Dois:</label>
                <input name="icone_dois_serv" type="text" class="form-control" id="icone_dois_serv" placeholder="Ícone do Serviço Dois"  value="<?php
                if (isset($valorForm['icone_dois_serv'])) {
                    echo $valorForm['icone_dois_serv'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="titulo_tres_serv"><span class="text-danger">*</span> Titulo do Serviço Três:</label>
                <input name="titulo_tres_serv" type="text" class="form-control" id="titulo_tres_serv" placeholder="Título do Serviço Um"  value="<?php
                if (isset($valorForm['titulo_tres_serv'])) {
                    echo $valorForm['titulo_tres_serv'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="description_tres_serv"><span class="text-danger">*</span> Descrição do Serviço Três:</label>
                <input name="description_tres_serv" type="text" class="form-control" id="description_tres_serv" placeholder="Descrição do Serviço Um"  value="<?php
                if (isset($valorForm['description_tres_serv'])) {
                    echo $valorForm['description_tres_serv'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="icone_tres_serv"><span class="text-danger">*</span> Ícone do Serviço Três:</label>
                <input name="icone_tres_serv" type="text" class="form-control" id="icone_tres_serv" placeholder="Ícone do Serviço Um"  value="<?php
                if (isset($valorForm['icone_tres_serv'])) {
                    echo $valorForm['icone_tres_serv'];
                }
                ?>" required> 
            </div>


            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditHomeServ" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>