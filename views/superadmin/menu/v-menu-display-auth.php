 <div class="cf nestable-lists">
        <div class="dd" id="nestable">
            <?php
            $i = 0;
            //$this->util_model->printr($menu_location_list);
            function show_menu($Menu, $i) {
                echo "<ol class='dd-list'>";
                if ($Menu != NULL) {
                    foreach ($Menu as $mrow) {
                        echo "<li data-id='{$mrow['Parent']['MID']}' data-name='{$mrow['Parent']['menu_title']}' id='{$mrow['Parent']['MID']}AXD' class='dd-item'>";
                        ?>    
                        <div class=" dd-handle" id="UpdateDiv<?= $mrow['Parent']['MID'] ?>"> 
                            <div>
                                <?= $mrow['Parent']['menu_title'] ?>
                                <input onclick="checkMyChild(this)"  type="checkbox" name="MID[]" <?=$mrow['Parent']['Allowed']=="1" ? "checked='true'" :"" ?> value="<?= $mrow['Parent']['MID'] ?>" class="checkbox  checkbox-inline" />
                            </div>
                        </div>
 
                      
                       

                        <?php
                        $i++;
                        show_menu($mrow['Child'], $i);
                        echo "</li>";
                    }
                }
                echo "</ol>";
            }

            show_menu($MenuList, $i);
            ?>

        </div>
     <input type="hidden" name="BranchID" value="<?=$BranchID?>"/>
     <input type="hidden" name="UTID" value="<?=$UTID?>"/>
    </div>