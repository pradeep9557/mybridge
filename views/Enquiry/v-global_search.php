
<div class="responsive">
    <div class="row">
        <p style="  padding: 4px 20px;">
            <span class="box blink"> Sort Codes Description </span>
            <span class="box"> EC : Enquiry Code </span>
            <span class="box"> V  : Visit </span>
            <span class="box"> EFN : Enquiry Form Number </span>
            <span class="box"> TF : Total Follow ups </span>
            <span class="box"> DOR : Date of Registration </span>
            <span class="box"> ECor : Enquiry Course </span>
            <span class="box"> AdmCor : Admission Course</span>
            <span class="box"> SrcCat : Source Category</span>
        </p>
    </div>
    <table class="table table-striped table-bordered table-hover table-responsive capitalized_word" id="global_enquiry_search">
        <thead>
            <tr>
                <th>S.No</th>
                <th>EC/V/EFN/TF</th>
                <th>DOE</th>
                <th>ECor</th>
                <th>EnrollNo</th>
                <th>DOR</th>
                <th>AdmCor</th>
                <th>SName</th> 
                <th>Mobile</th>
                <th>SrcCat</th>
                <th>Source</th>
                <th>PRO</th>               
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            
            $i = 0;
            foreach ($result as $Enq_Details) {
                          ?>
                          <tr class="odd gradeX">
                              <td><?php echo ++$i; ?></td>
                              <td><?php echo $Enq_Details['E_Code'] . "/" . $Enq_Details['Visit'] . "/" . $Enq_Details['EFormNo'] . "/" . $Enq_Details['total_followups'] ?></td>
                              <td><?php echo date(DF, strtotime($Enq_Details['DOE'])); ?></td>
                              <td><?php echo $Enq_Details['enqCourseCode']; ?></td>
                              <td><?php echo $Enq_Details['EnrollNo']; ?></td>
                              <td><?php echo $Enq_Details['EnrollNo'] != "NA" ? date(DF, strtotime($Enq_Details['DOR'])) : ''; ?></td>
                              <td><?php echo $Enq_Details['admCourseCode']; ?></td>
                              <td><?php echo $Enq_Details['StudentName']; ?></td>
                              <!--<td><?php // echo $Enq_Details['FatherName']; ?></td>-->
                              <td><?php echo $Enq_Details['Mobile1']; ?></td>
                              <td><?php echo $Enq_Details['Src_CatCode']; ?></td>
                              <td><?php echo $Enq_Details['Src_Code']; ?></td>
                              <td><?php echo $Enq_Details['PROCode']; ?></td>
                              <td>
                                  <form class="margin0px">
                                  <a href="<?= base_url() ?>Enquiry/enquiry/edit_enquiry/<?= $Enq_Details['E_Code'] ?>" target="_blank">
                                      <button type="button" name="Edit_Enquiry" title="Edit Enquiry Basic Details" value="Edit" class="btn btn-success btn-xs">
                                          <span class="glyphicon glyphicon-edit"></span> 
                                      </button>
                                  </a>
                                  <a type="button" href="<?= base_url() ?>Enquiry/followups/index/<?= $Enq_Details['E_Code'] ?>" title="Follow Up" target="_blank">
                                      <button type="button" name="Follow_up" value="Follow Up" class="btn btn-info btn-xs">
                                          <span class="glyphicon glyphicon-thumbs-up"></span>
                                      </button>
                                  </a>
                                  <a type="button" href="<?php echo base_url() . "adm/cadm/index/{$Enq_Details['E_Code']}/{$Enq_Details['Visit']}" ?>" target="_blank">
                                      <button type="button"  class="btn btn-info btn-xs" title="Convert Admission">
                                          <span class="glyphicon glyphicon-transfer"></span>
                                      </button>
                                  </a>
                                       <input type="hidden" name="_key" value="del_Enq"/>
                                                        <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($Enq_Details['StudentName']) ?> Enquiry !!" name="_msg"/>
                                                        <input type="hidden" value="<?= $Enq_Details['E_Code'] ?>" name="E_Code"/>
                                                        <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                            <span class="glyphicon glyphicon-trash"></span> 
                                                        </button>
                                  </form>
                              </td>
                              
                              
<!--                              <td><?php echo $Enq_Details['Email1']; ?></td>

                              <td><?php echo $Enq_Details['lcode']; ?></td>-->


                          </tr>
                          <?php
            }
            ?>


        </tbody>
    </table>
</div>
<script>
              $(document).ready(function () {
                  $('#global_enquiry_search').DataTable({
                      responsive: false
                  });

              });
</script>
<script src="<?=  base_url()?>js/custom_js/blink/blinking_effect.js" type="text/javascript"></script>