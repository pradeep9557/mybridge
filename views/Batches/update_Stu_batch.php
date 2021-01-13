<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Update Students Batch
              <a href="<?php echo base_url(); ?>batch/batch_master" class="pull-right">
                <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                    <span class="glyphicon glyphicon-plus"></span> Create New Batch
                </button></a>
                <a href="<?php echo base_url(); ?>employee" class="pull-right">
                <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                    <span class="glyphicon glyphicon-plus"></span> Create New Faculty
                </button></a> 
                
            </h4>
            <?php
            if (isset($error) && !isset($del_op))
                          $this->util_model->show_result_error($error, SUCCESS_MSG, ERROR_MSG);
            ?>
            <h4>Search Student</h4>
            <?php
            echo $bupdate_search_template;
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
    //for normal form
    //  echo form_open('/dashboard/new_admission',$attributes);
    //echo form_open(base_url() . 'batch_master/batch_save_update', $attributes);
    ?>
    <!-- Nav tabs -->


</div>


</div>  




<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
              $(document).ready(function () {
                  $('#dataTables-example').dataTable();
              });

//    function on()
//    {
//        var FacultyCode = $("").val();
//        var BatchCode = $("").val();
//        var page = "<?php // base_url()  ?>Ajax/Student_List_For_Batch_update";
//        $("#Searching_Result").removeClass('hidden');
//        $("#progress_bar").removeClass('hidden');
//        $.ajax({
//            type: "POST",
//            url: page,
//            data: "FacultyCode=" + FacultyCode + " & BatchCode=" + BatchCode,
//            success: function (result) {
//                $("#Searching_Result").html(result);
//                $('#dataTables-example').dataTable();
//            }});
//
//    }
</script>

</div>
