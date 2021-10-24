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
                <h2 class="display-4 title">Detalhes da Mensagem de Contato</h2>
            </div>
            <?php
            if (!empty($this->dados['viewContactMsg'])) {
                extract($this->dados['viewContactMsg'][0]);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_contact_msg']) {
                            echo "<a href='" . URLADM . "list-contact-msg/index' class='btn btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['edit_contact_msg']) {
                            echo "<a href='" . URLADM . "edit-contact-msg/index/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['button']['delete_contact_msg']) {
                            echo "<a href='" . URLADM . "delete-contact-msg/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a>";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <?php
                            if ($this->dados['button']['list_contact_msg']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "list-contact-msg/index'>Listar</a>";
                            }
                            if ($this->dados['button']['edit_contact_msg']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "edit-contact-msg/index/$id'>Editar</a>";
                            }
                            if ($this->dados['button']['delete_contact_msg']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "delete-contact-msg/index/$id' data-confirm='Excluir'>Apagar</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        if (!empty($this->dados['viewContactMsg'])) {
            ?>
            <dl class="row">

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $name; ?></dd>

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9"><?php echo $email; ?></dd>

                <dt class="col-sm-3">Assunto</dt>
                <dd class="col-sm-9"><?php echo $subject; ?></dd>

                <dt class="col-sm-3">Conteúdo</dt>
                <dd class="col-sm-9"><?php echo $content; ?></dd>
                
                <dt class="col-sm-3">Cadastrado</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Editado</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($modified)) {
                        echo date('d/m/Y H:i:s', strtotime($modified));
                    }
                    ?>
                </dd>
            </dl>
            <?php
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não encontrada!</div>";
        }
        ?>
    </div>
</div>
