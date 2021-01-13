<?php
$searching_id = "result_tbl" . rand(0, 999999999);
$branch_settings = $this->util_model->check_aready_exits(DB_PREFIX . "branch_settings", array("BranchID" => $Session_Data['IBMS_BRANCHID']), TRUE);
//$this->util_model->printr(unserialize($branch_settings[0]->tes));
?>
<div class="responsive">
    <div class="row">
        <p style="  padding: 4px 20px;">
            <span class="box blink"> Sort Codes Description </span>
<!--            <span class="box"> EC : Enquiry Code </span>
            <span class="box"> V  : Visit </span>
            <span class="box"> EFN : Enquiry Form Number </span>
            <span class="box"> TF : Total Follow ups </span>-->
            <span class="box"> DOR : Date of Registration </span>
<!--            <span class="box"> ECor : Enquiry Course </span>-->
            <span class="box"> AdmCor : Admission Course</span>
            <!--<span class="box"> SrcCat : Source Category</span>-->
        </p>
    </div>
    <table class="table table-striped table-bordered table-hover table-responsive capitalized_word" id="<?php echo $searching_id; ?>">
        <thead>
            <tr>
                <th>S.No</th>
<!--                <th>EC/V/EFN/TF</th>-->
                <!--<th>DOE</th>-->
                <!--<th>ECourse</th>-->
                <th>EnrollNo</th>
                <th>DOR</th>
                <th>AdmCor</th>
                <th>SName</th>
                <th>FName</th>
                <th>Mobile</th>
                <!--<th>SourceCat</th>-->
                <!--<th>Source</th>-->
                <!--<th>PRO</th>-->               
                <th>Action</th>

                <th>Locality</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            //$this->util_model->printr($result);
            foreach ($result as $Enq_Details) {
                          ?>
                          <tr class="odd gradeX">
                              <td><?php echo ++$i; ?></td>
              <!--                              <td><?php echo $Enq_Details['E_Code'] . "/" . $Enq_Details['Visit'] . "/" . $Enq_Details['EFormNo'] . "/" . $Enq_Details['total_followups'] ?></td>
                              <td><?php echo date(DF, strtotime($Enq_Details['DOE'])); ?></td>
                              <td><?php echo $Enq_Details['enqCourseCode']; ?></td>-->
                              <td><?php echo $Enq_Details['EnrollNo']; ?></td>
                              <td><?php echo ($Enq_Details['DOR'] == "" || $Enq_Details['DOR'] == NULL) ? 'Blank' : date(DF, strtotime($Enq_Details['DOR'])); ?></td>
                              <td><?php echo $Enq_Details['admCourseCode']; ?></td>
                              <td><?php echo $Enq_Details['StudentName']; ?></td>
                              <td><?php echo $Enq_Details['FatherName']; ?></td>
                              <td><?php echo $Enq_Details['Mobile1']; ?></td>
              <!--                              <td><?php echo $Enq_Details['Src_CatCode']; ?></td>
                              <td><?php echo $Enq_Details['Src_Code']; ?></td>-->
                              <!--<td><?php echo $Enq_Details['PROCode']; ?></td>-->
                              <td>
                                  <a target="_blank" href="<?php echo base_url() . "adm/cadm/edit_adm/{$Enq_Details['Stu_ID']}" ?>"><button class="btn btn-success btn-xs" title="Edit Admission Details">
                                          <span class="glyphicon glyphicon-edit"></span>
                                      </button>
                                  </a>
                                  <a href="<?php
                                          if (FEE_COLLECT_TYPE == 1) {
                                                        echo base_url() . FEE_COLLECT_TYPE1_URL . "/index/{$Enq_Details['Stu_ID']}/{$Enq_Details['admCourseID']}/{$branch_settings[0]->default_fee_type}";
                                          } elseif (FEE_COLLECT_TYPE == 2) {
                                                        echo base_url() . FEE_COLLECT_TYPE2_URL . "/index/{$Enq_Details['Stu_ID']}/{$Enq_Details['admCourseID']}/{$branch_settings[0]->default_fee_type}";
                                          } else {

                                          } ?>"><button class="btn btn-info btn-xs" title="Fee Collect">
                                          <span class="glyphicon glyphicon-send"></span>
                                      </button>
                                  </a>
                              </td>
              <!--                              <td><?php echo $Enq_Details['Email1']; ?></td>-->

                              <td><?php echo $Enq_Details['lcode']; ?></td>


                          </tr>
              <?php
}
?>


        </tbody>
    </table>
</div>
<script>
              $(document).ready(function () {
                  $('#<?php echo $searching_id; ?>').DataTable();

              });
</script>
<script src="<?= base_url() ?>js/custom_js/blink/blinking_effect.js" type="text/javascript"></script>