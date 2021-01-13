<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<link href="<?= base_url() ?>css/menus.css" rel="stylesheet" type="text/css"/>
<div class="ajax-data-collector">
    <div class="data-div">
        <div class="top-row row">
            <div class="col-lg-6"></div>  <div onclick="close_data_div();" class="close closediv">
                <img src="<?= base_url() ?>img/closebtn.png" style="width: 30px"/></div>
        </div>
        <div class="data-holder" style="height: 400px; overflow-y: scroll">
            <div class="data-panel" style="">

            </div> 
        </div>
    </div>
</div>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="container-fluid">

        <div class="row">


            <div class="row">
                <!--                         //form her-->
                <div class="col-lg-6">
                    <?php
                    $this->load->view('superadmin/menu/v-add-menu-form');
                    ?> 
                </div>

                <div class="col-lg-6">
                    <?php
                    $this->load->view('superadmin/menu/v-all-menu');
                    ?> 
                    <div class="col-lg-6" id="EditMenuDiv"></div>
                </div>
            </div>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">All Admission</h4>           
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Menu List With Advance Filter
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Module</th>
                                    <th>Type</th>
                                    <th>Controller </th>
                                    <th>Function</th>
                                    <th>Menu Title</th>
                                    <th>Icon Link</th>
                                    <th>Status</th>
                                    <th>Add User</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($All_menu_list as $menu) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= ++$i ?></td>
                                        <td><?= $menu->module_name ?></td>
                                        <td><?= $menu->is_menu==0?"Module":"Menu" ?></td>
                                        <td><?= $menu->controller ?></td>
                                        <td><?= $menu->function ?></td>
                                        <td><?= $menu->menu_title ?></td>
                                        <td><span class="<?= $menu->menu_icon ?>"></span> <?= $menu->menu_link ?></td>
                                        <td><?= $menu->Status ?></td>
                                        <td><?= $menu->Add_User; ?></td>
                                        <td>
                                            <form>
                                                <button type="button" name="Edit Menu" value="Edit" class="btn btn-success btn-xs" onclick="open_page('<?= base_url() ?>designation_controller/Edit_Designation/0/0/<?=$menu->MID?>', '')">
                                                    <span class="glyphicon glyphicon-edit"></span> 
                                                </button>
                                                <input type="hidden" name="_key" value="del_menu"/>
                                                <input type="hidden" value="You want to delete <?= mysql_real_escape_string($menu->menu_title) ?> Menu !!" name="_msg"/>
                                                <input type="hidden" value="<?= $menu->MID ?>" name="MID"/>
                                                <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                    <span class="glyphicon glyphicon-trash"></span> 
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').dataTable();
        });
    </script>

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="<?= base_url() ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>