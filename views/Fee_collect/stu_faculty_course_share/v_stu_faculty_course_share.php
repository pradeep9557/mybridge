<div class="col-lg-12">
    <h4 class="page-header">Mange Course Faculty Share
        <?php if (empty($faculty_course_share)): ?>
                      <a href="<?php echo base_url(); ?>adm/cadm/insert_course_faculty_share/<?php echo $basic_details->Stu_ID; ?>" class="pull-right">
                          <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                              <span class="glyphicon glyphicon-send"></span> Getting Started
                          </button></a>
        <?php else: ?>
                      <a href="<?php echo base_url(); ?>adm/cadm/sync_faculties/<?php echo $basic_details->Stu_ID; ?>" class="pull-right">
                          <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                              <span class="glyphicon glyphicon-send"></span> Syn with batch faculty
                          </button></a>  
        <?php endif; ?>
        <a href="<?php echo base_url(); ?>adm/cadm/edit_adm/<?php echo $basic_details->Stu_ID; ?>/#sectionD" class="pull-right">
            <button type="button" name="link" value="Save" class="btn btn-primary btn-md margin_top-10px">
                <span class="glyphicon glyphicon-refresh"></span> Refresh
            </button></a>
        <a href="<?php echo base_url(); ?>fees/Fee_Master_1/sscfp/<?php echo $basic_details->Stu_ID; ?>/#sectionD" class="pull-right">
            <button type="button" name="link" value="Save" class="btn btn-info btn-md margin_top-10px">
                <span class="glyphicon glyphicon-send"></span> Manage Fee Plan
            </button></a>
        <a href="<?php echo base_url(); ?>fees/faculty_share/" class="pull-right" target="_blank">
            <button type="button" name="link" value="Save" class="btn btn-primary btn-md margin_top-10px">
                <span class="glyphicon glyphicon-send"></span> Manage Faculty shares
            </button></a>
        <a href="<?php echo base_url(); ?>batch/batch_master/update_indiviual_batch/<?php echo $basic_details->Stu_ID; ?>" class="pull-right" target="_blank">
            <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                <span class="glyphicon glyphicon-refresh"></span> Batch Update
            </button></a>
    </h4>
</div>
<div class="col-lg-12">
    <div class="">
        <?php
        echo form_open(base_url() . "adm/cadm/update_course_faculty_share");
        echo form_hidden("Stu_ID_Hidden", $basic_details->Stu_ID);
        ?>
        <table class="table table-bordered" id="faculty_share_tb">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Course & Subject</th>
                    <th>ActualFee</th>
                    <th>Discount Amt</th>
                    <th>Distd Fee</th>
                    <th>FacultyCode</th>
                    <th>Share</th>
                    <th>Weightage</th>
                    <th>Update</th>
                </tr>         
            </thead>     
            <tbody>
                <?php
                $s_no = 1;
                $total_fees = 0;
                $totalDisFee = 0;
                $total_Dis = 0;
//                $this->util_model->printr($faculty_course_share);
                foreach ($faculty_course_share as $each_row):
                              $total_fees += $each_row->CourseFee;
                              ?>
                              <tr>
                                  <td><?php
                                      echo $s_no++;
                                      echo form_hidden("Stu_ID[]", $each_row->Stu_ID);
                                      ?></td>
                                  <td><?php
                                      echo "<a href='" . base_url() . "courses/Edit_Course/" . $each_row->CourseID . "' target='_blank' title='Edit Course Fee'>" . $each_row->CourseCode . "</a>";
                                      echo form_hidden("CourseID[]", $each_row->CourseID);
                                      ?></td>
                                  <td class="course_fee_col"><?php echo form_input("ActuallFee[]", $each_row->CourseFee, array("class" => "'form-control actual_fee'", "placeholder" => "Actuall Fees", "readonly" => TRUE)); ?></td>

                                  <td class="dis_col">
                                      <input type="text" class="form-control course_discount" id="dis_amt" name="Dis[]" placeholder="Discount amt" onblur="amount_validation(<?php echo $each_row->CourseFee; ?>, this.value, this)" value="<?php
                                      $dis = $each_row->Dis * $each_row->CourseFee / 100;
                                      $total_Dis+=$dis;
                                      echo $dis;
                                      ?>">
                                  </td>
                                  <td class="dis_fee_col"><input type="text" class="form-control dis_fee" value="<?php
                                      echo $each_row->DisFee;
                                      $totalDisFee+=$each_row->DisFee;
                                      ?>"></td>

                                  <td>
                                                
                                                <?php echo $All_Faculty_Code[$each_row->FacultyID];
                                                echo form_hidden("FacultyID[]",$each_row->FacultyID);
//                                                form_dropdown("FacultyID[]", $All_Faculty_Code, $each_row->FacultyID, "class='form-control chosen-select'"); ?></td>
                                  <td>
                                      <?php
                                      if(!$each_row->Share){
                                          echo "<a href='".  base_url()."fees/faculty_share/index/".$each_row->FacultyID."/".$each_row->CourseID."' target='_blank'>Set Incentive</a>";
                                      }
                                      echo form_input("FacultyShare[]", $each_row->FacultyShare?$each_row->FacultyShare:$each_row->Share, array("class" => "form-control", "placeholder" => "Faculty Share")); ?></td>
                                  <td><?php echo form_input("Weightage[]", $each_row->Weightage, array("class" => "form-control", "placeholder" => "Share %")); ?></td>
                                  <td><?php echo form_checkbox("Update[]", $each_row->cisID,"checked"); ?></td>        
                              </tr>     
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total Actual Fee</th>
                    <th><?php echo form_input("Total Fees", $total_fees, array("class" => "'form-control total_fees'", "placeholder" => "Total Fees", "readonly" => TRUE)); ?></th>
                    <th>
                        <input type="text" class="form-control total_dis_amt" onkeyup="copy_dis_into_all('faculty_share_tb', this)" onblur="copy_dis_into_all('faculty_share_tb', this)" placeholder="Total discount" value="<?php echo $total_Dis; ?>">
            <div id='chkDis'>
                <input id="dis_chk" name="dis_chk" type="checkbox" val="chk" checked="" class="checkbox">
                Update
            </div>
            </th>   
            <th><?php echo form_input("totalDisFee", $totalDisFee, array("class" => "'form-control total_dis_fee'", "placeholder" => "Total Fees", "readonly" => TRUE)); ?></th>

            <th colspan="4"><button type="submit" class="btn btn-primary">Update</button></th>
            </tr>          
            </tfoot>
        </table> 
        <?php echo form_close(); ?>
    </div>
    <!-- /.col-lg-12 -->
    <div class="row">
        <button class="btn btn-danger">
            Note : If Faculty Code is not coming, It means you haven't allocated batch for that subject.
        </button>
        <br>
        <br>
        <button class="btn btn-danger">
            Note : If course amount is not coming, it means you haven't entered the amount for that course, to set please click on that course. and after enter, come back and simple refresh the page.
        </button>
    </div>
</div>                 
<?php $this->load->view("Fee_collect/stu_faculty_course_share/calculate_js"); ?>

