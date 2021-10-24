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
                    echo "<a href='#submenu$id_itm_men' data-toggle='collapse'><i class='$icon_itm_men'></i> $name_itm_men</a>";
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
    ?>
</nav>
