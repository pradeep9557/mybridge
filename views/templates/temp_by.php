<?php

$base_url = base_url();
foreach ($MenuList as $Menu) {
    echo "<li><a href='$base_url{$Menu['Parent']['menu_link']}' target='{$Menu['Parent']['tab']}'><span class='{$Menu['Parent']['menu_icon']}'></span> {$Menu['Parent']['menu_title']}";
    if (!empty($Menu['Child'])) {
        echo "<span class='fa arrow'></span>";
    }
    echo "</a>";
    if (!empty($Menu['Child'])) {
        echo "<ul class='nav nav-second-level'>";
        foreach ($Menu['Child'] as $l1_menu) {
            echo "<li><a href='$base_url{$l1_menu['Parent']['menu_link']}' target='{$l1_menu['Parent']['tab']}'><span class='{$l1_menu['Parent']['menu_icon']}'></span> {$l1_menu['Parent']['menu_title']}";
            if (!empty($l1_menu['Child'])) {
                echo "<span class='fa arrow'></span>";
            }
            echo "</a>";
            if (!empty($l1_menu['Child'])) {
                echo "<ul class='nav nav-third-level'>";
                foreach ($l1_menu['Child'] as $l2_menu) {
                    echo "<li><a href='$base_url{$l2_menu['Parent']['menu_link']}' target='{$l2_menu['Parent']['tab']}'><span class='{$l2_menu['Parent']['menu_icon']}'></span> {$l2_menu['Parent']['menu_title']}";
                    if (!empty($l2_menu['Child'])) {
                        echo "<span class='fa arrow'></span>";
                    }
                    echo "</a>";
                }
                echo "</ul>";
            }
        }
        echo "</ul>";
    }
    echo "</li>";
}
?>