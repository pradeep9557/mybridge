<div class="col-lg-12">
    <div class="row">
        <?php 
//         print_r($Fee_Plan_Details);
        ?>
        <div class="col-lg-12">
            <h4 class="page-header ">Set Fee Plan For <?= $Fee_Plan_Details[0]->EnrollNo ?> and CourseCode <?= $Fee_Plan_Details[0]->CourseCode ?></h4>
            <?php
            if (isset($error))
                $this->util_model->show_result_error($error, SUCCESS_MSG, ERROR_MSG);
            ?>
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <form action="<?= base_url() . "Fee_Master/save_update_fee_plan" ?>" method="POST">
            <table class="table table-bordered table-hover" class="fee_plan" id="fee_plan">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>EnrollNo</th>
                        <th>CourseCode</th>
                        <th>Inst Amt.</th>
                        <th>Total Inst.</th>
                        <th>Total Paid</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tr>
                    <td>1.</td>
                    <td><input type='text' name='EnrollNo1' class='form-control' value='<?= $Fee_Plan_Details[0]->EnrollNo ?>' readonly=""/></td>
                    <td><input type='text' name='CourseCode1' class='form-control' value='<?= $Fee_Plan_Details[0]->CourseCode ?>' readonly=""/></td>
                    <td><input type='text' name='Inst_amt1' class='form-control' placeholder='Per Installment Amt' value='<?= $Fee_Plan_Details[0]->Inst_amt ?>' /></td>
                        <td><input type='text' name='Total_Inst1' class='form-control' placeholder='Total Installments' value='<?= $Fee_Plan_Details[0]->Total_Inst ?>' id="Total_Inst"/></td>
                    <td><input type='text' name='Total_Paid1' class='form-control' placeholder='Paid Installments' value='<?= $Fee_Plan_Details[0]->Total_paid ?>'  id="Total_paid" readonly="" /></td>
                    <td><input type='text' name='Remarks1' class='form-control' placeholder='Remarks' value='<?= $Fee_Plan_Details[0]->Remarks ?>' /></td>
                </tr>
                <tr><td colspan='10'><button   type='submit' name="Add_indi_fee_paln" value='Update' class='btn btn-success btn-md'>
                            <span class='glyphicon glyphicon-save'></span>Update
                        </button>&nbsp;&nbsp;<button   type='reset'   class='btn btn-primary btn-md'>
                            <span class='glyphicon glyphicon-refresh'></span>Reset</button></td></tr>
            </table>
            <input type="hidden" name="Fee_Plan_ID" value="<?=$Fee_Plan_Details[0]->ID?>"/>
            <input type="hidden" name="Add_User" value="<?= $Fee_Plan_Details[0]->Add_User ?>"/>
            <input type="hidden" name="Mode_User" value="<?= $Session_Data['IBMS_USER_ID'] ?>"/>
            <input type="hidden" name="total_row" value="1" id="total_row"/>
        </form>
    </div>
</div>
<script>
    $("#Total_Inst").change(function(){
        check_greater_smaller_validation("Total_Inst","Total_paid","Total Installment can't be Less then Paid Installments");
    });
//    $("Total_Paid").keyup(function(){
//        check_greater_smaller_validation("Total_Inst","Total_Paid");
//     });
    function check_greater_smaller_validation(g_id,s_id,_errmsg){
        var should_be_grater = $("#"+g_id).val();
        if(should_be_grater!=""){
        var should_be_smaller = $("#"+s_id).val();
        if(should_be_grater<should_be_smaller){
             sweetAlert("Oops...", _errmsg, "error");
        }
    }
    }
</script>