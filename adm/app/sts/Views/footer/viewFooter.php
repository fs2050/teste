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
                <h2 class="display-4 title">Detalhes do Rodapé</h2>
            </div>
            <div class="p-2">
               <span class="d-none d-lg-block">
                    <?php
                    if ($this->dados['button']['edit_footer']) {
                        echo "<a href='" . URLADM . "edit-footer/index' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                    }
                    ?>                         
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->dados['button']['edit_footer']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "edit-footer/index'>Editar</a>";
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
        if (!empty($this->dados['viewFooter'][0])) {
            extract($this->dados['viewFooter'][0]);
            ?>
            <dl class="row">

                <dt class="col-sm-3">Título do Site</dt>
                <dd class="col-sm-9"><?php echo $title_site; ?></dd>

                <dt class="col-sm-3">Título do Contato</dt>
                <dd class="col-sm-9"><?php echo $title_contact; ?></dd>

                <dt class="col-sm-3">Telefone</dt>
                <dd class="col-sm-9"><?php echo $phone; ?></dd>

                <dt class="col-sm-3">Endereço</dt>
                <dd class="col-sm-9"><?php echo $address; ?></dd>

                <dt class="col-sm-3">URL do Endereço</dt>
                <dd class="col-sm-9"><?php echo $url_address; ?></dd>

                <dt class="col-sm-3">CNPJ</dt>
                <dd class="col-sm-9"><?php echo $cnpj; ?></dd>

                <dt class="col-sm-3">URL CNPJ</dt>
                <dd class="col-sm-9"><?php echo $url_cnpj; ?></dd>

                <dt class="col-sm-3">Título Redes Sociais</dt>
                <dd class="col-sm-9"><?php echo $title_social_networks; ?></dd>

                <dt class="col-sm-3">Rede Social Um</dt>
                <dd class="col-sm-9"><?php echo $txt_one_social_networks; ?></dd>

                <dt class="col-sm-3">Link Social Um</dt>
                <dd class="col-sm-9"><?php echo $link_one_social_networks; ?></dd>

                <dt class="col-sm-3">Rede Social Dois</dt>
                <dd class="col-sm-9"><?php echo $txt_two_social_networks; ?></dd>

                <dt class="col-sm-3">Link Social Dois</dt>
                <dd class="col-sm-9"><?php echo $link_two_social_networks; ?></dd>

                <dt class="col-sm-3">Rede Social Três</dt>
                <dd class="col-sm-9"><?php echo $txt_three_social_networks; ?></dd>

                <dt class="col-sm-3">Link Social Três</dt>
                <dd class="col-sm-9"><?php echo $link_three_social_networks; ?></dd>
                
                <dt class="col-sm-3">Rede Social Quatro</dt>
                <dd class="col-sm-9"><?php echo $txt_four_social_networks; ?></dd>

                <dt class="col-sm-3">Link Social Quatro</dt>
                <dd class="col-sm-9"><?php echo $link_four_social_networks; ?></dd>
                
                
            </dl>          
            <?php
        }
        ?>
    </div>
</div>
