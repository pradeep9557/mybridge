<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Update Rooms
             <a href="<?php echo base_url(); ?>rooms/c_room" class="pull-right">
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
            <h3 class="panel-title toggle_custom">Update Rooms
                <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>  

        <div class="panel-body collapse" id="collapseExample">
            <?php foreach ($records as $value) {
           }
        ?>
            <?php
            echo form_open(base_url() . "rooms/c_room/update_data", "id='room_mst'");
            ?>
            <?php echo form_hidden('rid',$value['rid']) ?>
            <div class="row bottom_gap">
                <div class="col-lg-2">Room Code</div>
                <div class="col-lg-4"><?php echo form_input('rcode',$value['rcode'],"class='form-control' Placeholder='Room Code'")  ?></div>
                <div class="col-lg-2">Max. Student</div>
                <div class="col-lg-4"><?php echo form_input('max_students',$value['max_students'],"class='form-control' Placeholder='Max number of Students'")  ?></div>
            </div>   
                <div class="row bottom_gap">
                          <?php echo $update_time_form; ?>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-12">
                    <button type="submit" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Update
                    </button>
                    <button type="reset" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
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
        $Curr_Obj->rooms_list();
        ?>  
    </div> 
  </div>
</div>

  <?php
    $this->load->view("rooms/rooms_validation");
?>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>


<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>


<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
