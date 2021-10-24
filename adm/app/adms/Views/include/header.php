<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
?>
<nav class="navbar navbar-expand navbar-dark bg-primary">

    <a class="sidebar-toggle text-light mr-3">
        <span class="navbar-toggler-icon"></span>
    </a>

    <a class="navbar-brand" href="<?php echo URLADM ?>dashboard/index">Celke</a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle menu-header" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                        if (((isset($_SESSION['user_image'])) AND (!empty($_SESSION['user_image']))) AND (file_exists("app/adms/assets/image/users/" . $_SESSION['user_id'] . "/" . $_SESSION['user_image']))) {
                            echo "<img src='" . URLADM . "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/" . $_SESSION['user_image'] . "' class='rounded-circle img-user'>";
                        } else {
                            echo "<img src='" . URLADM . "app/adms/assets/image/users/icon_user.png' class='rounded-circle img-user'>";
                        }

                        echo "&nbsp;<span class='d-none d-sm-inline'>";
                        if(isset($_SESSION['user_name']) AND !empty($_SESSION['user_name'])){
                            $name = explode(" ", $_SESSION['user_name']);
                            echo $name[0];
                        }else{
                            echo "Usuário";
                        }
                        
                        
                        ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo URLADM ?>view-perfil/index"><i class="fas fa-user"></i> Perfil</a>
                    <a class="dropdown-item" href="<?php echo URLADM ?>sair/index"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

