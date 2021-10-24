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
