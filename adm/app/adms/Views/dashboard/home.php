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
                <h2 class="display-4 title">Dashboard</h2>
            </div>                        
        </div>
        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="row mb-3">
            <div class="col-lg-3 col-sm-6 mb-sm-2 card-dash">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x"></i>
                        <h6 class="card-title">Usuários</h6>
                        <h2 class="lead">147</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 card-dash">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <i class="fas fa-eye fa-3x"></i>
                        <h6 class="card-title">Visitas</h6>
                        <h2 class="lead">647</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 card-dash">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <i class="fas fa-comments fa-3x"></i>
                        <h6 class="card-title">Comentários</h6>
                        <h2 class="lead">14</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 card-dash">
                <div class="card bg-danger text-white">
                    <div class="card-body">                                    
                        <i class="far fa-file fa-3x"></i>
                        <h6 class="card-title">Artigos</h6>
                        <h2 class="lead">58</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
