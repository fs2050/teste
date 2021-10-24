<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
$sidebar_active = "";
if (isset($this->dados['sidebarActive'])) {
    $sidebar_active = $this->dados['sidebarActive'];
}
?>
<nav class="sidebar">
    <ul class="list-unstyled">
        <li class="<?php
        if ($sidebar_active == "dashboard") {
            echo 'active';
        }
        ?>"><a href="<?php echo URLADM; ?>dashboard/index"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>

        <li>
            <a href="#submenu4" data-toggle="collapse"><i class="fas fa-user"></i> Usuário</a>
            <ul id="submenu4" class="list-unstyled collapse">
                <li class="<?php
                if ($sidebar_active == "list-users") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>list-users/index"><i class="fas fa-users"></i> Usuários</a></li>
                <li class="<?php
                if ($sidebar_active == "list-sits-users") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>list-sits-users/index"><i class="fas fa-user-lock"></i> Situação Usuário</a></li>
                <li class="<?php
                if ($sidebar_active == "list-access-levels") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>list-access-levels/index"><i class="fas fa-key"></i> Nível de Acesso</a></li>
            </ul>
        </li>


        <li>
            <a href="#submenu5" data-toggle="collapse"><i class="fas fa-cogs"></i> Configurações</a>
            <ul id="submenu5" class="list-unstyled collapse">
                <li class="<?php
                if ($sidebar_active == "list-colors") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>list-colors/index"><i class="fas fa-palette"></i> Cores</a></li>
                <li class="<?php
                if ($sidebar_active == "list-conf-emails") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>list-conf-emails/index"><i class="fas fa-envelope"></i> Configuração de E-mail</a></li>
                <li class="<?php
                if ($sidebar_active == "view-levels-forms") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>view-levels-forms/index"><i class="fas fa-user-cog"></i> Formulário Usuário</a></li>
                <li class="<?php
                if ($sidebar_active == "list-types-pages") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>list-types-pages/index"><i class="fas fa-file-alt"></i> Tipos de Página</a></li>
                <li class="<?php
                if ($sidebar_active == "list-sits-pages") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>list-sits-pages/index"><i class="far fa-file-alt"></i> Situação de Página</a></li>
                <li class="<?php
                if ($sidebar_active == "list-groups-pages") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>list-groups-pages/index"><i class="far fa-file-alt"></i> Grupo de Página</a></li>
                <li class="<?php
                if ($sidebar_active == "list-pages") {
                    echo 'active';
                }
                ?>"><a href="<?php echo URLADM; ?>list-pages/index"><i class="far fa-file-alt"></i> Listar Páginas</a></li>
            </ul>
        </li>

        <li class="<?php
        if ($sidebar_active == "view-perfil") {
            echo 'active';
        }
        ?>"><a href="<?php echo URLADM; ?>view-perfil/index"><i class="far fa-user"></i> Perfil</a></li>
        <li><a href="<?php echo URLADM; ?>sair/index"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
    </ul>
    <?php
    if (isset($this->dados['menu']) AND ($this->dados['menu'])) {
        echo '<ul class="list-unstyled">';
        $count_drop_start = 0;
        $count_drop_end = 0;
        foreach ($this->dados['menu'] as $item_menu) {
            extract($item_menu);

            $active = "";
            if ($sidebar_active == $menu_controller) {
                $active = 'active';
            }

            if ($dropdown == 1) {
                if ($count_drop_start != $id_itm_men) {
                    if (($count_drop_end == 1) AND ($count_drop_start != 0)) {
                        echo "</ul>";
                        echo "</li>";
                        $count_drop_end = 0;
                    }
                    echo "<li>";
                    echo "<a href='#submenu$id_itm_men' data-toggle='collapse'><i class='$icon_itm_men'></i> $name_itm_men - $id_itm_men</a>";
                    echo "<ul id='submenu$id_itm_men' class='list-unstyled collapse'>";
                }
                echo "<li class='$active'><a href='" . URLADM . "$menu_controller/$menu_metodo'><i class='$icon'></i> $name_page</a></li>";
                $count_drop_start = $id_itm_men;
                $count_drop_end = 1;
            } else {
                if ($count_drop_end == 1) {
                    echo "</ul>";
                    echo "</li>";
                    $count_drop_end = 0;
                }
                echo "<li class='$active'><a href='" . URLADM . "$menu_controller/$menu_metodo'><i class='$icon'></i> $name_page</a></li>";
            }
        }

        if ($count_drop_end == 1) {
            echo "</ul>";
            echo "</li>";
            $count_drop_end = 0;
        }
        echo "</ul>";
    }


    if (isset($this->dados['menu']) AND ($this->dados['menu'])) {
        /* foreach ($this->dados['menu'] as $item_menu) {
          extract($item_menu);
          echo "<span class='text-white'>ID: $id_lev_pag</span><br>";
          echo "<span class='text-white'>Controller: $menu_controller</span><br>";
          echo "<span class='text-white'>Método: $menu_metodo</span><br>";
          echo "<span class='text-white'>Página: $name_page</span><br>";
          echo "<hr>";
          } */

        echo '<ul class="list-unstyled">';
        foreach ($this->dados['menu'] as $item_menu) {
            extract($item_menu);
            $active = "";
            if ($sidebar_active == $menu_controller) {
                $active = 'active';
            }
            echo "<li class='$active'><a href='" . URLADM . "$menu_controller/$menu_metodo'><i class='$icon'></i> $name_page</a></li>";
        }
        echo "</ul>";
    }
    ?>
</nav>
