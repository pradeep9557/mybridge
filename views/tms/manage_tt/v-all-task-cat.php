<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">All Task Category
                <?php
                if (isset($error)) {
                    $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
                }
                ?>
                <a href='<?= base_url() ?>tms/manage_tt/index/create' class="pull-right margin_top-10px">
                    <button type="button" value="Del"  class="btn btn-md btn-primary">
                        <span class="glyphicon glyphicon-plus"></span> Create
                    </button>
                </a>    

            </h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#allfaqmenu">
                    <h3 class="panel-title toggle_custom">Task Category List with advance filter
                        <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="allfaqmenu">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-faq-menu">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Task Name</th>
                                    <th>Task Code</th>
                                    <th>Under</th>
                                    <th>Status</th>
                                    <th>AddUser</th>
                                    <th>ModeUser</th>
                                    <th>LastModified</th> 
                                    <th style="width: 80px;">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($taskCatList as $List) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= ++$i ?></td>
                                        <td><?= $List->ttm_name ?></td>
                                        <td><?= $List->ttm_code ?></td>
                                        <td><?= $List->PCatName ?></td>
                                        <td><?= ($List->status) ? "Enable" : "Disabled" ?></td> 
                                        <td><?= $List->AddUserCode ?></td>
                                        <td><?= $List->ModeUserCode ?></td>
                                        <td><?php echo date(DTF, strtotime($List->Mode_DateTime)); ?></td>
                                        <td style="width: 80px;">

                                            <form>
                                                <a href='<?= base_url() ?>tms/manage_tt/index/create/<?= $List->ttm_id ?>'>
                                                    <button type="button" value="Del"  class="btn btn-xs btn-primary">
                                                        <span class="glyphicon glyphicon-edit"></span> 
                                                    </button>
                                                </a>
                                                <input type="hidden" name="_key" value="del_tt_id">
                                                <input type="hidden" name="_title" value="task-type-category">
                                                <input type="hidden" value="You want to delete this Task-Type Category, please delete this at your Own risk all sub task associative with this category will be effected !!" name="_msg">
                                                <input type="hidden" value="<?php echo $List->ttm_id ?>" name="ID">
                                                <button type="button" value="Del" class="btn btn-xs btn-danger ajax_submit">
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
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function () {
        $('#dataTables-faq-menu').dataTable();
    });


</script>
