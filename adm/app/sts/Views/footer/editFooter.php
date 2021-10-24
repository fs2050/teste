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
                <h2 class="display-4 title">Editar Conteúdo do Rodapé</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['view_footer']) {
                            echo "<a href='" . URLADM . "view-footer/index' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['view_footer']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "view-footer/index'>Visualizar</a>";
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
        <form id="edit_footer" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="title_site"><span class="text-danger">*</span> Título do Site:</label>
                <input name="title_site" type="text" class="form-control" id="title_site" placeholder="Título do site"  value="<?php
                if (isset($valorForm['title_site'])) {
                    echo $valorForm['title_site'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="title_contact"><span class="text-danger">*</span> Título do Contato:</label>
                <input name="title_contact" type="text" class="form-control" id="title_contact" placeholder="Título do contato"  value="<?php
                if (isset($valorForm['title_contact'])) {
                    echo $valorForm['title_contact'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="phone"><span class="text-danger">*</span> Telefone:</label>
                <input name="phone" type="text" class="form-control" id="phone" placeholder="Telefone completo"  value="<?php
                if (isset($valorForm['phone'])) {
                    echo $valorForm['phone'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="address"><span class="text-danger">*</span> Endereço:</label>
                <input name="address" type="text" class="form-control" id="address" placeholder="Endereço"  value="<?php
                if (isset($valorForm['address'])) {
                    echo $valorForm['address'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="url_address"><span class="text-danger">*</span> URL do Endereço:</label>
                <input name="url_address" type="text" class="form-control" id="url_address" placeholder="URL do Endereço"  value="<?php
                if (isset($valorForm['url_address'])) {
                    echo $valorForm['url_address'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="cnpj"><span class="text-danger">*</span> CNPJ:</label>
                <input name="cnpj" type="text" class="form-control" id="cnpj" placeholder="cnpj"  value="<?php
                if (isset($valorForm['cnpj'])) {
                    echo $valorForm['cnpj'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="url_cnpj"><span class="text-danger">*</span> URL do CNPJ:</label>
                <input name="url_cnpj" type="text" class="form-control" id="url_cnpj" placeholder="URL do CNPJ"  value="<?php
                if (isset($valorForm['url_cnpj'])) {
                    echo $valorForm['url_cnpj'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="title_social_networks"><span class="text-danger">*</span> Título da Rede Social:</label>
                <input name="title_social_networks" type="text" class="form-control" id="title_social_networks" placeholder="Título da rede social"  value="<?php
                if (isset($valorForm['title_social_networks'])) {
                    echo $valorForm['title_social_networks'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="txt_one_social_networks"><span class="text-danger">*</span> Texto da Rede Social Um:</label>
                <input name="txt_one_social_networks" type="text" class="form-control" id="txt_one_social_networks" placeholder="Texto da Rede Social Um"  value="<?php
                if (isset($valorForm['txt_one_social_networks'])) {
                    echo $valorForm['txt_one_social_networks'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="link_one_social_networks"><span class="text-danger">*</span> Link da Rede Social Um:</label>
                <input name="link_one_social_networks" type="text" class="form-control" id="link_one_social_networks" placeholder="Link da Rede Social Um"  value="<?php
                if (isset($valorForm['link_one_social_networks'])) {
                    echo $valorForm['link_one_social_networks'];
                }
                ?>" required>
            </div>
            
            
            
            

            <div class="form-group">
                <label for="txt_two_social_networks"><span class="text-danger">*</span> Texto da Rede Social Dois:</label>
                <input name="txt_two_social_networks" type="text" class="form-control" id="txt_two_social_networks" placeholder="Texto da Rede Social Dois"  value="<?php
                if (isset($valorForm['txt_two_social_networks'])) {
                    echo $valorForm['txt_two_social_networks'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="link_two_social_networks"><span class="text-danger">*</span> Link da Rede Social Dois:</label>
                <input name="link_two_social_networks" type="text" class="form-control" id="link_two_social_networks" placeholder="Link da Rede Social Dois"  value="<?php
                if (isset($valorForm['link_two_social_networks'])) {
                    echo $valorForm['link_two_social_networks'];
                }
                ?>" required>
            </div> 

            <div class="form-group">
                <label for="txt_three_social_networks"><span class="text-danger">*</span> Texto da Rede Social Três:</label>
                <input name="txt_three_social_networks" type="text" class="form-control" id="txt_three_social_networks" placeholder="Texto da Rede Social Três"  value="<?php
                if (isset($valorForm['txt_three_social_networks'])) {
                    echo $valorForm['txt_three_social_networks'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="link_three_social_networks"><span class="text-danger">*</span> Link da Rede Social Três:</label>
                <input name="link_three_social_networks" type="text" class="form-control" id="link_three_social_networks" placeholder="Link da Rede Social Três"  value="<?php
                if (isset($valorForm['link_three_social_networks'])) {
                    echo $valorForm['link_three_social_networks'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="txt_four_social_networks"><span class="text-danger">*</span> Texto da Rede Social Quatro:</label>
                <input name="txt_four_social_networks" type="text" class="form-control" id="txt_four_social_networks" placeholder="Texto da Rede Social Quatro"  value="<?php
                if (isset($valorForm['txt_four_social_networks'])) {
                    echo $valorForm['txt_four_social_networks'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="link_four_social_networks"><span class="text-danger">*</span> Link da Rede Social Quatro:</label>
                <input name="link_four_social_networks" type="text" class="form-control" id="link_four_social_networks" placeholder="Link da Rede Social Quatro"  value="<?php
                if (isset($valorForm['link_four_social_networks'])) {
                    echo $valorForm['link_four_social_networks'];
                }
                ?>" required>
            </div>
            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditFooter" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>