            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">All Fee Type</h4>
                    <?php 
//                      if (isset($error)) {
//                      $this->util_model->show_result_error($error,DEL_SUCCESS_MSG,DEL_ERROR_MSG);
//                      }?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Fee Type List With Advance Filter
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Fine</th>
                                            <th>Relax</th>
                                            <th>Tax</th>
                                            <th>Status</th>
                                            <th>Add User</th>
                                            <th>Modified</th>
                                            <th>Edit</th>
                                           </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i=0;
                                         foreach ($All_Fee_Type_List as $Fee_Type_List) {
                                          ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo ++$i?></td>
                                            <td><?php echo $Fee_Type_List->FeeType_Code?></td>
                                            <td><?php echo wordwrap($Fee_Type_List->FeeType_Name,15)?></td>
                                             <td><?php echo $Fee_Type_List->Late_Payment_Fee?></td>
                                             <td><?php echo $Fee_Type_List->Fine_Day_Limit?></td>
                                            <td><?php echo $Fee_Type_List->tax_enabled==1?"Actived":"Deactived"?></td>  
                                            <td><?php echo $Fee_Type_List->Status==1?"Actived":"Deactived"?></td>  
                                            <td><?php echo $Fee_Type_List->Add_UserCode?></td>
                                              <td><?php echo date(DF,  strtotime($Fee_Type_List->Mode_DateTime)); ?></td>
                                              <td>
                                               <form>
                                            <button type="button" name="Edit_FeeType_Code" value="Edit" class="btn btn-success btn-xs" onclick="open_page('<?php echo base_url()?>fees/fee_type/Edit_FeeType/<?php echo   $Fee_Type_List->FeeTypeID; ?>','')">
                                                <span class="glyphicon glyphicon-edit"></span> 
                                            </button>
                                            <input type="hidden" name="_title" value="Fee Type"/>
                                            <input type="hidden" name="_key" value="del_FeeType_Code"/>
                                            <input type="hidden" value="You want to delete <?php echo  mysql_real_escape_string($Fee_Type_List->FeeType_Code) ?> Fee Code !!" name="_msg"/>
                                            <input type="hidden" value="<?php echo $Fee_Type_List->FeeTypeID?>" name="FeeType_ID"/>
                                            <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
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

 <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>

<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>