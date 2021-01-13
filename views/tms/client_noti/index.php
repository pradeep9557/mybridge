<?php 
$client_id=  isset($client_noti_by_id['client_id'])?$client_noti_by_id['client_id']:@$_GET['client_id'];
 
?>


<div id="page-wrapper" style="min-height: 345px;">
    
    <div class="row bottom_gap">

     
            <div class="col-md-12">
                <label>Select Client</label>


                <?php 
              
                echo form_dropdown('client_id', $client_list, @$client_id, "class='form-control' onchange='get_client_data(this)'"); ?>
               



            </div>
   
    </div>

    <?php 
        if (isset($_GET['client_id']) && $_GET['client_id'] != '') {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Un-assigned Client Data
                <button type="button" class="btn btn-info pull-right" style="margin-top: -10px;" data-toggle="modal" data-target="#myModal">Constant List</button>
                <a href="<?php echo base_url().'/tms/client_noti/get_client_task?client_id='.$_GET['client_id']?>">   <button type="button" class="btn btn-info pull-right" style="margin: -10px 6px 0px 0px;">Manage Client Task</button>
                </a>
            </h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <?php

 
        echo form_open_multipart(base_url() . 'tms/client_noti/index?client_id='.$_GET['client_id'], "id='save_client_noti'");
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"  data-toggle="collapse" data-target="#add_task">

                        <h3 class="panel-title toggle_custom">Add new Task <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" id="add_task">

                        <div class="row bottom_gap">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="hidden" name="client_id" value="<?php echo $client_id?>">
                                    <input type="hidden" name="noti_mst_id" value="<?php echo isset($client_noti_by_id['noti_mst_id'])?@$client_noti_by_id['noti_mst_id']:''?>">
                                    <input type="text" name="emails" placeholder="Email Id seperated by coma" value="<?php echo @$client_noti_by_id['emails']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" name="mobiles" placeholder="mobile number seperated by coma" value="<?php echo @$client_noti_by_id['mobiles']?>" class="form-control">
                                </div>
                            </div> 

                        </div>


                        <!--End of row-->


                        <div class="row bottom_gap">

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label>Month Day</label>
                                    <?php echo form_dropdown('day', $day, @$client_noti_by_id['day'], "class='form-control'"); ?>
                                </div>
                            </div> 
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label>Time</label>
                                    <?php echo form_dropdown('time', $time, @$client_noti_by_id['time'], "class='form-control'"); ?>
                                </div>
                            </div> 
                             <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Select State</label>
                                    <?php echo form_dropdown('state_id', $client_states, @$client_noti_by_id['state_id'], "class='form-control'"); ?>
                                </div>
                            </div> 
                        </div>

                        <div class="row bottom_gap">

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Monthly</label>
                                    <?php 
                                     echo form_dropdown('monthly',array(1=>"Yes",0=>"Custom Month"),1,"class='form-control'");
                                    ?> 
                                </div>
                            </div>     
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Custom Months</label>  
                                    <?php   
                                     echo form_multiselect('custom_months[]',$month_list,  @explode(",", @$client_noti_by_id['custom_months']), "class='form-control chosen-select'");
                                    ?>
                                </div>
                            </div> 
                            
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" name="subject" placeholder="subject" value="<?php echo @$client_noti['subject']?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Mail Body</label>
                                    <textarea name="mailBody"  class="form-control" id="template"><?php echo @$client_noti_by_id['mailBody']?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row bottom_gap">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Message Body</label>
                                    <textarea name="messageBody"  class="form-control"><?php echo @$client_noti_by_id['messageBody']?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row bottom_gap">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <?php echo form_dropdown('status', array("1" => "Enabled", "0" => "Disabled"), @$client_noti_by_id['status'], "class='form-control'"); ?>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-1">
                                <!--<div class="input-group">-->

                                <?php echo form_submit("Add_Employee", "save", array("class" => "'btn btn-success'")) ?>
                            </div>
                            <div class="col-lg-1">
                                <?php echo form_reset("Reset", "Reset", array("class" => "'btn btn-danger'")) ?>
                            </div>

                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <?php echo form_close(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"  data-toggle="collapse" data-target="#clienttasklist">
                        <h3 class="panel-title toggle_custom"> List  <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" id="clienttasklist">
                        <div class="table-responsive">
                            <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Email Id</th>
                                        <th>Mobile No.</th>
                                        <th>Month - state</th>
                                        <th>Time</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $sno = 0;
                                    if (!empty($client_noti)) {
                                       
                                        ?>
                                        <?php foreach ($client_noti as $client_List) :
//                                            $this->util_model->printr($client_List);
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo ++$sno ?></td>
                                                <td><?php echo $client_List['emails'] ?></td>
                                                <td><?php echo $client_List['mobiles'] ?></td>
                                                <td><?php echo $client_List['day']."-".$client_List['state_name'] ?></td>
                                                <td><?php echo $client_List['time'] ?></td>
                                                <td><?php echo $client_List['subject'] ?></td>
                                                <td><?php echo $client_List['status'] ?></td>
                                                <td>
                                                    <a href="<?php echo base_url().'/tms/client_noti/index?client_id='.$_GET['client_id'].'&id='.$client_List['noti_mst_id']?>">  <button type="button" name="Edit_cilent_noti" title="Edit Basic Details" value="Edit" class="btn btn-success btn-xs">
                                                        <span class="glyphicon glyphicon-edit"></span> 
                                                        </button></a>
                                                        <form>
                                                     
                                                     <input type="hidden" name="_key" value="del_client_noti"/>
                                                       <input type="hidden" name="_title"  value="Delete"/>
                                                <input  type="hidden" value="You want to delete" name="_msg"/>
                                              <input type="hidden" value="<?php echo $client_List['noti_mst_id'] ?>" name="noti_mst_id"/>
                                                <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                    <span class="glyphicon glyphicon-trash"></span> 
                                                </button>
                                            </form>

                                                </td>
                                            </tr>

                                        <?php endforeach; ?>
                                    <?php }
                                    else {
                                        ?>
                                            <tr class="odd gradeX">
                                                
                                                <td><?php echo 'No data for this client';?></td></tr>

        <?php } ?>

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
        <?php }
        ?>

    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Constant List</h4>
                </div>
                <div class="modal-body">
                    <h4>Month:-<?php echo Month ?></h4>
                    <h4>Year:-<?php echo Year ?></h4>
            </div>

        </div>

    </div>
</div>
<link href="<?php echo base_url(); ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>-->
<script src="<?php echo base_url(); ?>js/multi_select/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/multi_select/prism.js" type="text/javascript"></script>

<script src="//cdn.ckeditor.com/4.7.2/basic/ckeditor.js"></script>
<script>
    
function get_client_data(that){
    var client_id=$(that).val();
    window.location.href='<?php echo base_url().'/tms/client_noti/index/?client_id='?>'+client_id;
}

    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }


        CKEDITOR.replace('template');


    </script>
