<?php
$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';
?>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row bottom_gap">


        <div class="col-md-12">
            <label>Select Client</label>


            <?php echo form_dropdown('client_id', $client_list, @$client_id, "class='form-control' onchange='get_client_data(this)'"); ?>




        </div>

    </div>
    <?php
    if (isset($_GET['client_id']) && $_GET['client_id'] != '') {

        echo form_open_multipart(base_url() . 'tms/client_noti/get_client_state?client_id=' . $_GET['client_id'], "id='save_client_task'");
        ?>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"  data-toggle="collapse" data-target="#add_task">

                        <h3 class="panel-title toggle_custom">Manage Client Task<span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" id="add_task">
                        <input type="hidden" name="client_id" value="<?php echo $client_id ?>">
                        <?php if (!empty($state_list)):
                            ?>
                        <ul style="list-style-type: none; ">
                                <?php foreach ($state_list as $value) : ?>
                            <li style="float: left;width: 300px;"> <input type="checkbox" <?php echo $value['task_id'] != '' ? 'checked' : '' ?> name="state_id[]" value="<?php echo $value['state_id'] ?>"><?php echo $value['name'] ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="row">
                                <div class="col-lg-1">
                                    <!--<div class="input-group">-->

                                    <?php echo form_submit("Add_Employee", "save", array("class" => "'btn btn-success'")) ?>
                                </div>
                                

                            </div>
                        <?php endif; ?>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <?php echo form_close(); ?>
    </div>
<?php } ?>
<script>
    function get_client_data(that) {
        var client_id = $(that).val();
        window.location.href = '<?php echo base_url() . '/tms/client_noti/get_client_state/?client_id=' ?>' + client_id;
    }

</script>