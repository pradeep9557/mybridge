<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header ">Select Admission Form</h4>
                    <?php
                     if(isset($error)){
                         $this->util_model->show_result_error($error);
                     }
                    ?>
               </div>
                <!-- /.col-lg-12 -->
            </div>
    <div class="row">
        <div class="col-lg-12">  
        <?php
        $CourseCategory = "";
        $CourseCategoryCode = "";
        foreach ($All_Course_List as $Course_object) {
            if ($CourseCategory != $Course_object->Category) {
                $CourseCategory = $Course_object->Category;
                $CourseCategoryCode = $Course_object->CategoryCode;
                ?>
        </div>
        <div class="col-lg-12">
               <h5 class="page-header"><?php echo "$CourseCategory($CourseCategoryCode)";?></h5>
               
        </div>
        <div class="col-lg-12">
                <?php
            }
            ?>
            <div class="col-lg-3">
                <span class="glyphicon glyphicon-share"></span><span style="padding-left: 3px"><a href="<?=  base_url()?>admission/new_admission/<?=  $this->util_model->url_encode($Course_object->CourseCode)?>"><?=$Course_object->CourseCode?></a></span>
            </div>
        <?php
            }
        ?>
    </div>
        
</div>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">All Admission</h4>
            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Students List With Advance Filter
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped  table-responsive table-bordered table-hover capitalized_word" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>EnrollNo</th>
                                    <th>DOR </th>
                                    <th>Name</th>
                                    <th>Father's Name</th>
                                    <th>Course</th>
<!--                                            <th>Faculty</th>
                                    <th>Batch</th>-->
                                    <!--<th>Contact No.</th>-->
                                  <!--  <th>Status</th>-->
                                    <th>Add/Mode</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($all_stu_details as $stu) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?= ++$i ?></td>
                                        <td><?= $stu->EnrollNo ?></td>
                                        <td><?php echo date(DF, strtotime($stu->DOR)); ?></td>
                                        <td><?= $stu->StudentName ?></td>
                                        <td><?= $stu->FatherName ?></td>
                                        <td><?= $stu->CourseCode ?></td>
                                        <!--<td><?php //echo $stu->Mobile1; ?></td>-->
                                        <td><?=$stu->Add_User."/".$stu->Mode_User;?></td>
                                        <td>
                                           <form>
                                            <a href="<?=base_url()?>admission/print_admission/<?=$stu->EnrollNo?>" target="_blank">
                                                <button class="btn-xs btn btn-primary" title="Get Hard Copy of <?=$stu->EnrollNo?>" type="button"> <span class="glyphicon glyphicon-print"></span></button>
                                            </a>
                                               <a href="<?=base_url()?>Fee_Master/Fee_collect_form/0/0/<?=$stu->EnrollNo?>/<?= $this->util_model->url_encode($stu->CourseCode) ?>">
                                                    <button class="btn-xs btn btn-info" title="Fee Collect For <?=$stu->EnrollNo?>" type="button"><span class="glyphicon glyphicon-send"></span></button>
                                                </a>
                                            <a href="javascript:void();" onclick="open_page('<?=base_url()?>admission/admission_edit/0/0/<?=$stu->EnrollNo?>', '')">
                                                <button class="btn-xs btn btn-success" title="Edit Details of EnrollNo <?=$stu->EnrollNo?>" type="button"><span class="glyphicon glyphicon-edit"></span></button>
                                                
                                            </a> 
                                                   <!-- delete form start --> 
                                                      <input type="hidden" name="_key" value="del_Student"/>
                                                      <input  type="hidden" value="You want to delete EnrollNo <?=  $stu->EnrollNo?> having Course <?= mysql_real_escape_string($stu->CourseCode)?> Course !!" name="_msg"/>
                                                      <input type="hidden" value="<?=  $this->util_model->url_encode($stu->CourseCode)?>" name="CourseCode"/>
                                                      <input type="hidden" value="<?=  $stu->EnrollNo?>" name="EnrollNo"/>
                                                      <button type="button" value="Del"  class="btn btn-xs btn-danger ajax_submit">
                                                      <span class="glyphicon glyphicon-trash"></span> 
                                                      </button>
                                                       <!-- delete form end -->
                                                 
                                                  </form>
                                           
<!--                                            <a href="<?=base_url()?>admission/Del_Admission/<?=$stu->EnrollNo?>" class="del_confirm">
                                                        <button class="btn-xs btn btn-danger" title="Delete EnrollNo <?=$stu->EnrollNo?>"><span class="glyphicon glyphicon-trash"></span></button>
                                                    </a>-->
                                           
                                                
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
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
</script>
        
<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
