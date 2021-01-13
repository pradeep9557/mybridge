<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#data_div">
        <h3 class="panel-title toggle_custom">Total Found Result : <span id="tfrcount"><?= count($all_enq_list) ?></span><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body collapse" id="data_div">
        <div class="table-responsive">
            <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>ECode</th>
                        <th>EFromNo</th>
                        <th>TVisit</th>
                        <th>TECoures</th>
                        <th>Name</th>
                        <th>FName</th>
                        <th>Contact No.</th>
                        <th>Add User</th>
                        <th>Modified</th>
                        <th>Edit</th>

<!--<th>Last Modified</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($all_enq_list as $Enq_Details) {
                                  ?>
                                  <tr class="odd gradeX">
                                      <td><?= ++$i ?></td>
                                      <td><?= $Enq_Details->E_Code ?></td>
                                      <td><?= $Enq_Details->EFormNo ?></td>
                                      <td><?= $Enq_Details->t_enq ?></td>
                                      <td><?= $Enq_Details->t_enqc ?></td>
                                      <td><?= $Enq_Details->StudentName ?></td>
                                      <td><?= $Enq_Details->FatherName ?></td>
                                      <td><?php
                                          echo $Enq_Details->Mobile1;
                                          ?></td>
                                      <td><?= $Enq_Details->Add_User ?></td>
                                      <td><?php echo date(DF, strtotime($Enq_Details->Mode_DateTime)); ?></td>
                                      <td><form>
                                              <a href="<?= base_url() ?>Enquiry/enquiry/edit_enquiry/<?= $Enq_Details->E_Code ?>" target="_blank">
                                                  <button type="button" name="Edit_Enquiry" title="Edit Enquiry Basic Details" value="Edit" class="btn btn-success btn-xs">
                                                      <span class="glyphicon glyphicon-edit"></span> 
                                                  </button>
                                              </a>
                                              <a href="<?= base_url() ?>Enquiry/enquiry/Othervisit/<?= $Enq_Details->E_Code ?>" target="_blank">
                                                  <button type="button" name="Edit_Enquiry" title="Add Next Visit" value="Edit" class="btn btn-info btn-xs">
                                                      <span class="glyphicon glyphicon-plus"></span> 
                                                  </button>
                                              </a>
                                              <a href="<?= base_url() ?>Enquiry/followups/index/<?= $Enq_Details->E_Code ?>" title="Follow Up" target="_blank">
                                                  <button type="button" name="Follow_up" value="Follow Up" class="btn btn-info btn-xs">
                                                      <span class="glyphicon glyphicon-thumbs-up"></span>
                                                  </button>
                                              </a>

                                              <input type="hidden" name="_key" value="del_Enq"/>
                                              <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($Enq_Details->StudentName) ?> Enquiry !!" name="_msg"/>
                                              <input type="hidden" value="<?= $Enq_Details->E_Code ?>" name="E_Code"/>
                                              <!--                                              <button type="button"  value="Del" class="btn btn-danger btn-xs ajax_submit" >
                                                                                                <span class="glyphicon glyphicon-trash"></span> 
                                                                                            </button>-->
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
</div>
