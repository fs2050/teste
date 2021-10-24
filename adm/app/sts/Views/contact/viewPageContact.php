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
                <h2 class="display-4 title">Detalhes da Página Contato</h2>
            </div>
            <div class="p-2">
               <span class="d-none d-lg-block">
                    <?php
                    if ($this->dados['button']['edit_page_contact']) {
                        echo "<a href='" . URLADM . "edit-page-contact/index' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                    }
                    ?>                         
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->dados['button']['edit_page_contact']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "edit-page-contact/index'>Editar</a>";
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
        if (!empty($this->dados['viewPageContact'][0])) {
            extract($this->dados['viewPageContact'][0]);
            ?>
            <dl class="row">

                <dt class="col-sm-3">Título do Horário</dt>
                <dd class="col-sm-9"><?php echo $title_opening_hours; ?></dd>

                <dt class="col-sm-3">Horário de Atendimento</dt>
                <dd class="col-sm-9"><?php echo $opening_hours; ?></dd>

                <dt class="col-sm-3">Título do Endereço</dt>
                <dd class="col-sm-9"><?php echo $title_address; ?></dd>

                <dt class="col-sm-3">Endereço</dt>
                <dd class="col-sm-9"><?php echo $address; ?></dd>

                <dt class="col-sm-3">Complemento do Endereço</dt>
                <dd class="col-sm-9"><?php echo $address_two; ?></dd>

                <dt class="col-sm-3">Telefone</dt>
                <dd class="col-sm-9"><?php echo $phone; ?></dd>
            </dl>          
            <?php
        }
        ?>
    </div>
</div>
