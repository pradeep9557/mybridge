
<div id="page-wrapper" style="min-height: 345px;">
    <?php
    echo form_open(base_url() . "fees/Fee_Master/scfp");
    ?>
    <div class="row padding_top_label">
        <div class="col-lg-2 col-md-2 padding_top_label">Select Course</div>
        <div class="col-lg-8 col-md-8">
            <?php
            echo form_dropdown("CourseID", $All_Course_List, $CourseID, "class='form-control chosen-select'");
            ?>
        </div>
        <div class="col-lg-2 col-md-2">
            <button type="submit" name="set_fee_plan" value="Get Fee Plan" class="btn btn-success btn-md">
                <span class="glyphicon glyphicon-floppy-disk"></span> Get Fee Plan
            </button>
        </div>
    </div>
    <?php
    echo form_close();
    ?>
    <div class="row">
      
            <h4 class="page-header ">Set Course Fee Plan For CourseCode <?= $CourseCode ?></h4>
            <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
      

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <form action="<?= base_url() . "fees/Fee_Master/save_cfp" ?>" method="POST">
            <table class="table table-bordered table-hover" class="fee_plan" id="fee_plan">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Package</th>
                        <th>Course</th>
                        <th>FeeType</th>
                        <th>Inst Amt.</th>
                        <th>Total Inst.</th>
                        <th>Sort</th>
                        <th>Remarks</th>
                        <th>Add/Remove</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>
                            <?php echo form_dropdown("PackageID[]", $Package_List, '', "class='form-control' readonly"); ?>                         
                        </td>
                        <td>
                            <input type="hidden" name="CourseID[]"  value='<?= $CourseID ?>'/>
                            <input type='text' name='CourseCode[]' class='form-control' value='<?= $CourseCode ?>' readonly/></td>
                        <td>
                            <?php echo form_dropdown("FeeTypeID[]", $FeeTypeID, '', "class='form-control' readonly "); ?>                         
                        </td>
                        <td><input type='text' name='Inst_amt[]' class='form-control' placeholder='Per Installment Amt' required=""/></td>
                        <td><input type='text' name='Total_Inst[]' class='form-control' placeholder='Total Installments' required=""/></td>
                        <td><input type='text' name='Sort[]' class='form-control' placeholder='Sort Order'/></td>
                        <td><input type='text' name='Remarks[]' class='form-control' placeholder='Remarks'/></td>
                        <td> 
                            <button   type='button'   class='btn btn-danger btn-md' onclick="remove_row(this, 'fee_plan', 1);">
                                <span class='glyphicon glyphicon-minus' ></span>
                            </button> 
                        </td> 
                    </tr>
                </tbody>
                <tfoot>
                    <tr><td colspan='8'><button   type='submit' name="save_scfp" value='Save' class='btn btn-success btn-md'>
                                <span class='glyphicon glyphicon-save'></span> Save
                            </button>&nbsp;&nbsp;<button   type='reset'   class='btn btn-primary btn-md'>
                                <span class='glyphicon glyphicon-refresh'></span> Reset</button></td>
                        <td>
                            <button   type='button'   class='btn btn-primary btn-md' onclick="clone_row('fee_plan', 1, 'total_row')">
                                <span class='glyphicon glyphicon-plus'></span>
                            </button>

                        </td>
                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="total_row" value="1" id="total_row"/>
        </form>
    </div>

    <?php echo $all_cfp; ?>

</div>
<script src="<?php echo base_url() ?>js/custom_js/table_manipulation/row_add_remove.js" type="text/javascript"></script>

<script>
$(document).ready(function () {
    $('.fee_plan').dataTable();
});
</script>



<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
