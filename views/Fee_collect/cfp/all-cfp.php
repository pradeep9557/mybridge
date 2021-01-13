<div class="row">
    <span  class="box blink">
        For Edit Fee Plan First delete all fee plan then re-insert !! 
    </span>
    <h4 class="page-header ">Fee Plan For <?php echo $CourseCode ?>
        <a href="<?php echo base_url(); ?>courses" class="pull-right">
            <button type="button" name="Add_CourseCat" value="Save" class="btn btn-success btn-md margin_top-10px">
                <span class="glyphicon glyphicon-plus"></span> Manage Course
            </button></a>
    </h4>
    <?php
    //$this->util_model->printr($cfp);
    ?>
    <table class="table table-bordered table-hover cfp_tbl" class="cfp">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Branch</th>
                <th>Package</th>
                <th>Course</th>
                <th>FeeType</th>
                <th>Inst Amt.</th>
                <th>Total Inst.</th>
                <th>Sort</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Add/Remove</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $s_no = 1;
            foreach ($cfp as $row) {
                          ?>          
                          <tr>
                              <td><?php echo $s_no++; ?></td>
                              <td><?php echo $row->BranchCode; ?></td>
                              <td><?php echo $row->PackageCode; ?></td>
                              <td><?php echo $row->CourseCode; ?></td>
                              <td><?php echo $row->FeeType_Code; ?></td>
                              <td><?php echo $row->Inst_amt; ?></td>
                              <td><?php echo $row->Total_Inst; ?></td>
                              <td><?php echo $row->Sort; ?></td>
                              <td><?php echo $row->Status ? "Active" : "Deactive"; ?></td>
                              <td><?php echo $row->Remarks; ?></td>
                              <td>
                                  <form>
              <!--                                      <button type="button"   class="btn-xs btn btn-success" onclick="open_page('<?= base_url() ?>courses/Edit_Course/<?= ($row->CourseID) ?>', '')" title="Edit <?= mysql_real_escape_string($row->CourseCode) ?>">
                                          <span class="glyphicon glyphicon-edit"></span>
                                      </button>-->
                                      <input type="hidden" name="_key" value="del_cfp"/>
                                      <input  type="hidden" value="You want to delete <?= $row->Inst_amt . "x" . $row->Total_Inst ?> Plan !!" name="_msg"/>
                                      <input type="hidden" value="<?= $row->CourseID ?>" name="CID"/>
                                      <input type="hidden" value="<?= $row->PackageID ?>" name="PackageID"/>
                                      <input type="hidden" value="<?= $row->BranchID ?>" name="BranchID"/>
                                      <button type="button" value="Del"  class="btn btn-xs btn-danger ajax_submit">
                                          <span class="glyphicon glyphicon-trash"></span> 
                                      </button>
                                  </form>
                              </td>

                          </tr>
            <?php } ?>
        </tbody>
    </table>
</div><script>
              $(document).ready(function () {
                  $('.cfp_tbl').dataTable();
              });
</script>