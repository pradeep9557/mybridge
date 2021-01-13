<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Manage Tax</h4>

            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom"><?php  echo $type?> Tax<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/manage_taxs/index', "id='managebilltype'");
            ?>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="form-group">
                        <input type="hidden" name="_action" value="<?php echo $action ?>">
                         <input type="hidden" name="id" value="<?php  echo @$typedata['id'] ?>">
                        <?php echo form_input("name", @$typedata['name'], array("class" => "'form-control  popover_element1'", "placeholder" => "'Tax Name'")) ?>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Rate<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="form-group">
                        
                        <?php echo form_input("rate", @$typedata['rate'], array("class" => "'form-control  popover_element1'", "placeholder" => "'Tax Rate'")) ?>
                    </div>
                </div>
           
                <div class=" col-lg-4 col-md-4 form-group">
                    <button class="btn btn-sm btn-success" type="submit">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                    <button type="reset" value="Save" class="btn btn-success btn-sm">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
                    </button>
                </div>
            </div>
            <?php
            echo form_close();
            ?>
        </div>

    </div>
<div class="row">  <div class="col-lg-12">
        <h5> Search Result</h5>
        <hr>
    </div>

    <div class="col-lg-12">

        <div class="table-responsive">
            <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="ajax_task_list">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th> 
                        <th>Rate</th> 
                        <th style="width: 100px;">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($btypelist as $each_type) {
                      
                        ?>
                        <tr class="odd gradeX">
                            <td><?= ++$i ?></td> 
                            <td><?= $each_type['name'] ?></td>
                            <td><?= $each_type['rate'] ?></td> 
                            <td>
                                <a href="<?php echo base_url() . "tms/manage_taxs/index" . "/" . $each_type['id'] . "/edit" ?>">
                                    <button type="button" value=""  class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit" title="Edit Tax"></span>
                                    </button>
                                </a>
         
                                <button data-toggle="tooltip" title="Delete" type="button" class="btn btn-danger" onclick="del_type(<?php echo $each_type['id'] ?>)">
                                     <span class="glyphicon glyphicon-trash" title="Delete Tax"></span>
                                </button> 
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
   
</div>

<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>
<script>
  $("#managebilltype").on("submit", function (e) {
                                e.preventDefault();
                                preloader.on();
                                $.ajax({
                                    url: $(this).attr("action"),
                                    type: "POST",
                                    dataType: "JSON",
                                    data: $(this).serialize(),
                                    success: function (result) {
//                                        var msg = display_msg(result._err_codes);
                                        if (result.succ) {
                                            
                                              swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });

                                        } else {
                                            sweetAlert({
                                                title: "Oops...",
                                                text: result._err_codes,
                                                type: "error",
                                                timer: 2500,
                                                html: true
                                            });
                                        }
                                        preloader.off();
                                    }
                                });
                            });
   function del_type(id) { 
        $.ajax({
            type: "POST",
            url: $("#managebilltype").attr('action'),
            data: "_action=del&id="+id,
            dataType: "json",
            success: function (search_data) {
                if (search_data.succ) {
                   
                    swal("Awesome!!", search_data._err_codes, "success");
                } else {
                    swal("Oops!!", search_data._err_codes, "error");
                }

            }
        });
    }                           

</script>
