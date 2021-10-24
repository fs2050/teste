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
                <h2 class="display-4 title">Editar Conteúdo da Página Contato</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['view_page_contact']) {
                            echo "<a href='" . URLADM . "view-page-contact/index' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['view_page_contact']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "view-page-contact/index'>Visualizar</a>";
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
        <form id="edit_page_contact" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="title_opening_hours"><span class="text-danger">*</span> Título:</label>
                <input name="title_opening_hours" type="text" class="form-control" id="title_opening_hours" placeholder="Título ddo horário de funcionamento"  value="<?php
                if (isset($valorForm['title_opening_hours'])) {
                    echo $valorForm['title_opening_hours'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="opening_hours"><span class="text-danger">*</span> Horário:</label>
                <input name="opening_hours" type="text" class="form-control" id="opening_hours" placeholder="Horário de funcionamento"  value="<?php
                if (isset($valorForm['opening_hours'])) {
                    echo $valorForm['opening_hours'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="title_address"><span class="text-danger">*</span> Título:</label>
                <input name="title_address" type="text" class="form-control" id="title_address" placeholder="Título do endereço"  value="<?php
                if (isset($valorForm['title_address'])) {
                    echo $valorForm['title_address'];
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
                <label for="address_two"><span class="text-danger">*</span> Complemento do Endereço:</label>
                <input name="address_two" type="text" class="form-control" id="address_two" placeholder="Complemento do Endereço"  value="<?php
                if (isset($valorForm['address_two'])) {
                    echo $valorForm['address_two'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="phone"><span class="text-danger">*</span> Telefone:</label>
                <input name="phone" type="text" class="form-control" id="phone" placeholder="Telefone"  value="<?php
                if (isset($valorForm['phone'])) {
                    echo $valorForm['phone'];
                }
                ?>" required>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditPageContact" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>