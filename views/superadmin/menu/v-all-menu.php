<div class="col-lg-12">
    <h4 class="page-header ">Manus Ordering 
        <button type="button" class="btn btn-sm btn-success pull-right" id="save_changes">
            <span class="glyphicon glyphicon-save"></span> Save Changes
        </button></h4>
</div>
<div class="col-lg-12">
    <div class="cf nestable-lists">
        <div class="dd" id="nestable">
            <?php
            $i = 0;
//            $this->util_model->printr($MenuTable);
            function show_menu($Menu, $i, $menu_location_list) {
                echo "<ol class='dd-list'>";
                if ($Menu != NULL) {
                    foreach ($Menu as $mrow) {
                        echo "<li data-id='{$mrow['Parent']['MID']}' data-name='{$mrow['Parent']['menu_title']}' id='{$mrow['Parent']['MID']}AXD' class='dd-item'>";
                        ?>    
                        <div class=" dd-handle" id="UpdateDiv<?= $mrow['Parent']['MID'] ?>"> 
                            <div>
                                <?= $mrow['Parent']['menu_title'] ?>
                            </div>
                        </div>
            <!--            <div class="MenuUpdater col-lg-10" id="UpdateForm<?= $mrow['Parent']['MID'] ?>">
                            <form class="MenuUpdate_Forms">
                                <div class="col-lg-12 form-group">
                                    
                                </div>
                            </form>
            </div>-->
                        <div class="MenuUpdater col-lg-10" id="UpdateForm<?= $mrow['Parent']['MID'] ?>">
                            <form class="MenuUpdate_Forms">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label style="" class="MenuUpdateLabel">Menu Title</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control input input-small " name="menu_title" value="<?= $mrow['Parent']['menu_title'] ?>" />   
                                        <input type="hidden" class="form-control input input-small " name="MID" value="<?= $mrow['Parent']['MID'] ?>" />   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label style="" class="MenuUpdateLabel">Icon</label>     
                                    </div>
                                    <div class="col-lg-8">
                                        <label class="icon_choose col-lg-12 form-group" style="cofr: rgb(249, 76, 76);">
                                            <input name="menu_icon" value="<?= $mrow['Parent']['menu_icon'] ?>" id="" class="icon_id form-control " type="hidden">
                                            <span style="background: rgb(227, 228, 229);padding: 2px;margin: 2px -13px;font-size: 25px;" class="<?= $mrow['Parent']['menu_icon'] ?>"></span>
                                        </label> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label style="" class="MenuUpdateLabel">Meta Keyword</label> 
                                    </div>
                                    <div class="col-lg-8">
                                        <input name="Meta_keywords" type="text" value="<?= $mrow['Parent']['Meta_keywords'] ?>" class="form-control input-sm"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label style="" class="MenuUpdateLabel">Link</label> 
                                    </div>
                                    <div class="col-lg-8">
                                        <input name="menu_link" type="text" value="<?= $mrow['Parent']['menu_link'] ?>" class="form-control input-sm"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label style="" class="MenuUpdateLabel">Open In</label> 
                                    </div>
                                    <div class="col-lg-8">
                                        <?php
                                        echo form_dropdown("tab", array("_self" => "Same Tab", "_blank" => "New Tab"), $mrow['Parent']['tab'], "class='form-control chosen-select'");
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label style="" class="MenuUpdateLabel">Location</label> 
                                    </div>
                                    <div class="col-lg-8">
                                        <?php
                                        echo form_dropdown("menulocation_id", $menu_location_list, $mrow['Parent']['menulocation_id'], "class='form-control chosen-select'");
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label style="" class="MenuUpdateLabel">Status</label> 
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="bootswitches"  name="Status" type="checkbox" value="1" checked="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 form-group">
                                        <button class="btn btn-sm btn-success" type="submit">
                                            <span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                                    </div>
                                    <div class="col-lg-2 form-group ">
                                        <button class="btn btn-sm btn-danger cancelBtn" type="button"><span class="glyphicon glyphicon-remove-sign"></span>Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="menueditbtn">
                            <a style="" href="javascript:;" onclick="update_menu('<?= $mrow['Parent']['MID'] ?>', 'UpdateForm<?= $mrow['Parent']['MID'] ?>', 'UpdateDiv<?= $mrow['Parent']['MID'] ?>');" class="menueditbtn col-lg-1">
                                <span class='glyphicon glyphicon-edit'></span>
                                Edit
                            </a>
                            <a style="color: red" href="javascript:;" onclick="deleteMenu('<?= $mrow['Parent']['MID'] ?>', '<?= $mrow['Parent']['MID'] ?>AXD')" class="menueditbtn col-lg-1" >
                                <span class='glyphicon glyphicon-warning-sign'></span>
                                Delete
                            </a>

                        </div>                                


                        <?php
                        $i++;
                        show_menu($mrow['Child'], $i, $menu_location_list);
                        echo "</li>";
                    }
                }
                echo "</ol>";
            }

            show_menu($MenuTable, $i, $menu_location_list);
            ?>

        </div>
    </div>

</div>



<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>



<script src="<?= base_url() ?>js/sort/jquery.nestable.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/menus.js" type="text/javascript"></script>