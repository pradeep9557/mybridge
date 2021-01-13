<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Edit Expenses
                <a href="<?php echo base_url(); ?>rooms/c_expense" class="pull-right">
                    <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                        <span class="glyphicon glyphicon-backward"></span> Back
                    </button></a>
            </h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
                    <h3 class="panel-title toggle_custom">Edit Expenses
                        <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
                </div>  

                <div class="panel-body collapse" id="collapseExample">
                    <?php
                    $c_data = array($edit_data->ex_id,);
                    echo form_open(base_url() . "expense/c_expense/update_expense/$edit_data->ex_id", "id='expense_mst'");
                    ?>
                    <div class="row bottom_gap">

                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Date of Expense</div>
                        <div class="col-lg-4 col-md-4 col-sm-8">
                            <div class='input-group date bdatetimepicker' >
                                <input type='text' class="form-control" name="ex_date" value="<?= date(DTF, strtotime($edit_data->ex_date)) ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>



                        <div class="col-lg-2">Expense Type</div>
                        <div class="col-lg-4"> <?php echo form_dropdown('ex_type_id', $ex_type, $edit_data->ex_type_code, "class='form-control chosen-select'") ?></div>

                    </div>   

                    <div class="row bottom_gap">
                        <div class="col-lg-2">Expense Amount (Rs.)</div>
                        <div class="col-lg-4"><?php echo form_input('ex_amt', $edit_data->ex_amt, "class='form-control'") ?></div>
                        <div class="col-lg-2">Expense By</div>
                        <div class="col-lg-4"> <?php echo form_dropdown('ex_by', $emp_list, $edit_data->ex_by, "class='form-control chosen-select'") ?></div>     
                    </div>

                    <div class="row bottom_gap">
                        <div class="col-lg-2">Description</div>
                        <div class="col-lg-4"><?php echo form_textarea('ex_des', $edit_data->ex_des, "class='form-control'") ?></div>     
                    </div>



                    <div class="row bottom_gap">
                        <div class="col-lg-12">
                            <button type="submit" value="Update" class="btn btn-success btn-md">
                                <span class="glyphicon glyphicon-floppy-disk"></span> Update
                            </button>
                        </div>
                    </div> 

                </div>
                <?php
// closing the form
                echo form_close();
                ?> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php
            $Curr_Obj = & get_instance();
            $Curr_Obj->list_all_expenses();
            ?>  
        </div> 
    </div>
</div>
<?php 
   $this->load->view("expense/expense_validation");
 ?>