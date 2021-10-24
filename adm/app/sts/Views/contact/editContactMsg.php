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
                <h2 class="display-4 title">Editar Mensagem de Contato</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <?php
                        if ($this->dados['button']['list_contact_msg']) {
                            echo "<a href='" . URLADM . "list-contact-msg/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['button']['view_contact_msg']) {
                            echo "<a href='" . URLADM . "view-contact-msg/index/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                        }
                        if ($this->dados['button']['delete_contact_msg']) {
                            echo "<a href='" . URLADM . "delete-contact-msg/index/$id' class='btn btn-outline-danger btn-sm' data-confirm='Excluir'>Apagar</a> ";
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
                            if ($this->dados['button']['view_contact_msg']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "view-contact-msg/index/$id'>Visualizar</a>";
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

        <span class="msg"></span>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form id="edit_contact_msg" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome completo"  value="<?php
                if (isset($valorForm['name'])) {
                    echo $valorForm['name'];
                }
                ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="email"><span class="text-danger">*</span> E-mail:</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Melhor e-mail"  value="<?php
                if (isset($valorForm['email'])) {
                    echo $valorForm['email'];
                }
                ?>" required>
            </div>
            
            <div class="form-group">
                <label for="subject"><span class="text-danger">*</span> Assunto:</label>
                <input name="subject" type="text" class="form-control" id="subject" placeholder="Assunto da mensagem"  value="<?php
                if (isset($valorForm['subject'])) {
                    echo $valorForm['subject'];
                }
                ?>" required >
            </div>
            
            <div class="form-group">
                <label for="content"><span class="text-danger">*</span> Conteúdo:</label>
                <input name="content" type="text" class="form-control" id="content" placeholder="Conteúdo da mensagem"  value="<?php
                if (isset($valorForm['content'])) {
                    echo $valorForm['content'];
                }
                ?>" required >
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditContactMsg" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>