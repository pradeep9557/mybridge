<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">

        <div class="col-lg-12">
            <h4 class="page-header ">Manage Billing Services</h4>
            <?php
            if($msg!=""){
               echo "<div class='well'>$msg</div>";    
            }
            
            ?>

        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">

    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title toggle_custom">
                <?php echo (isset($ser_Codelist) && !empty($ser_Codelist)) ? "Update Bill Services" : "Create Bill Services" ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body"> 
            <?php echo form_open(); ?>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Select Work Category<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_dropdown("ttm_id", $taskCatList, @$ser_details[0]['ttm_id'], "class='form-control'"); ?>
                        <input type="hidden"  name="bill_ser_id" value="" />
                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Status<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group">
                        <?php
                        echo form_dropdown("status", array("1" => "Enable", "0" => "Disable"), @$ser_details[0]['status'], "class='form-control'");
                        ?>
                    </div> 
                </div>
                <!-- /input-group -->               

            </div> <!--End of row-->
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Service Template Code<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group">
                        <input type="text"  list="serCatName" name="serCatCode"
                               value="<?php echo @$ser_details[0]['serCatCode']; ?>" 
                               class="form-control" placeholder="Server Category Name" />
                        <datalist id="serCatCode">
                            <?php
                            foreach ($ser_Codelist as $eachSer) {
                                echo "<option value='{$eachSer}'>";
                            }
                            ?>
                        </datalist>
                    </div> 
                </div> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Service Template Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group">
                        <input type="text"  list="serCatName"
                               name="serCatName" 
                               value="<?php echo @$ser_details[0]['serCatName']; ?>" 
                               class="form-control" placeholder="Server Category Name"/>
                        <datalist id="serCatName">
                            <?php
                            foreach ($ser_list as $eachSer) {
                                echo "<option value='{$eachSer}'>";
                            }
                            ?>
                        </datalist>
                    </div> 
                </div> 
            </div> <!--End of row-->
            <div class="server_container">
                <?php
                $i = 1;
                if (isset($ser_details)) {
                    foreach ($ser_details as $eacSer) {
                        ?>
                        <div class="row bottom_gap single_ser_box"> 
                            <div class="col-md-12">
                                <h4>
                                    <span class="sub_task_num" id="<?php echo $eacSer['serCatCode'] . $i ?>"># Services <?php echo $i; ?></span>
                                </h4>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Service Name<span class="Compulsory">*</span></div>
                            <div class="col-lg-4 col-md-4 col-sm-8"> 
                                <div class="form-group">
                                    <textarea type="text" class="form-control" name="service_name[]" placeholder="Enter Service"/><?php echo $eacSer['service_name']; ?></textarea>
                                </div> 
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Amount<span class="Compulsory">*</span>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="service amount" name="amt[]" value="<?php echo $eacSer['amt']; ?>"/>
                                </div> 
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2"> 
                                Sort
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Sort" name="sort[]" <?php echo $eacSer['sort']; ?>/>
                                </div> 
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2"> 
                                <button type="button" class="add_ser btn btn-danger btn-md">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                <button type="button" class="remove_ser  btn btn-success btn-md">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </div>
                        </div>
                    <?php }
                } else {
                    ?>
                    <div class="row bottom_gap single_ser_box"> 
                        <div class="col-md-12">
                            <h4>
                                <span class="sub_task_num" id="subtask2"># Services</span>
                            </h4>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Service Name<span class="Compulsory">*</span></div>
                        <div class="col-lg-4 col-md-4 col-sm-8"> 
                            <div class="form-group">
                                <textarea type="text" class="form-control" name="service_name[]" placeholder="Enter Service"/></textarea>
                            </div> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Amount<span class="Compulsory">*</span>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="service amount" name="amt[]"/>
                            </div> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2"> 
                            Sort
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Sort" name="sort[]"/>
                            </div> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2"> 
                            <button type="button" class="add_ser  btn btn-danger btn-md">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                            <button type="button" class="remove_ser  btn btn-success btn-md">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                        </div>
                    </div> <!--End of row-->
<?php } ?>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 "> </div>
                <div class="col-lg-4 col-md-4 col-sm-8 "> 
                    <button class="btn btn-primary">
                        <?php
                                        
                        if (isset($ser_details) && !empty($ser_details)) {
                            echo "Update";
                        } else {
                            echo "Create";
                        }
                        ?>
                    </button>
                </div>
            </div>
<?php echo form_close(); ?>
        </div>

    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title ">
                All Services
            </h3>
        </div>
        <div class="panel-body" id="collapseExample"> 
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>S.no</td>
                            <td>Service Cat Code</td>
                            <td>Service Cat Name</td>
                            <td>Action</td>
                        </tr>
                        <?php
//$this->util_model->printr($ser_details);
                        $s_no = 1;
                        foreach ($last_ser as $eachSer) {
                            ?>
                            <tr>
                                <td><?php echo $s_no++; ?></td>
                                <td><?php echo $eachSer['serCatCode']; ?></td>
                                <td><?php echo $eachSer['serCatName']; ?></td>
                                <td>
                                    <a href="<?php echo base_url("tms/invoice_mst/add_billing_servics/edit/{$eachSer['serCatCode']}"); ?>">
                                        <button class="btn btn-md btn-primary">Edit</button>
                                    </a>
                                    <a href="<?php echo base_url("tms/invoice_mst/add_billing_servics/delete/{$eachSer['serCatCode']}"); ?>">
                                        <button class="btn btn-md btn-danger">Delete</button>
                                    </a>
                                </td>
                            </tr>          
                        <?php }
                        ?>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
<div class="hidden dummy_content">
    <div class="row bottom_gap single_ser_box"> 
        <div class="col-md-12">
            <h4>
                <span class="sub_task_num" id="subtask2"># Services</span>
            </h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Service Name<span class="Compulsory">*</span></div>
        <div class="col-lg-4 col-md-4 col-sm-8"> 
            <div class="form-group">
                <textarea type="text" class="form-control" name="service_name[]" placeholder="Enter Service"/></textarea>
            </div> 
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Amount<span class="Compulsory">*</span>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="service amount" name="amt[]"/>
            </div> 
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2"> 
            Sort
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Sort" name="sort[]"/>
            </div> 
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2"> 
            <button type="button" class="add_ser  btn btn-danger btn-md">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
            <button type="button" class="remove_ser  btn btn-success btn-md">
                <span class="glyphicon glyphicon-minus"></span>
            </button>
        </div>
    </div> <!--End of row-->
</div>



<script>
    function init() {
        var count = 0;
        $.each($('.server_container').find(".single_ser_box"), function () {
            $(this).find(".sub_task_num").html("# Services " + ++count);
            $(this).find(".sub_task_num").attr("id", "subtask" + count);

        });

        $('html, body').animate({
            scrollTop: $('#subtask' + count).offset().top - 50
        }, 500);

        $.each($(document).find(".add_ser"), function () {
            $(this).unbind();
        });
        $.each($(document).find(".remove_ser"), function () {
            $(this).unbind();
        });

        $(".add_ser").on("click", function () {
            $(this).parents(".single_ser_box").after($(".dummy_content").html());
            init();
        });

        $(".remove_ser").on("click", function () {
            console.log($('.server_container').find(".single_ser_box").length);
            if ($('.server_container').find(".single_ser_box").length <= 1) {
                alert("This Can't be deleted!!");
            } else {
                $(this).parents(".single_ser_box").remove();
                init();
            }
        });


    }

    $(document).ready(function () {
        init();
    });

</script>