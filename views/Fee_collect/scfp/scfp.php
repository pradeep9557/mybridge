<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">

        <h4 class="page-header ">Set Fee Plan For <?= $EnrollNo ?> and CourseCode <?= $CourseCode ?></h4>
        <?php
        if (isset($error)) {
                      $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
        }
        ?>

        <!-- /.col-lg-12 -->
    </div>
    <?php if (!empty($FeeTypeID)) { ?>
                  <div class="row">
                      <form action="<?= base_url() . "fees/Fee_Master/save_sscfp" ?>" method="POST">
                          <table class="table table-bordered table-hover" class="stu_cfp" id="stu_cfp">
                              <thead>
                                  <tr>
                                      <th>S.No.</th>
                                      <th>EnrollNo</th>
                                      <th>Course</th>
                                      <th>FeeType</th>
                                      <th>Inst Amt.</th>
                                      <th>Total Inst.</th>
                                      <th>Sort</th>
                                      <th>Remarks</th>
                                      <th>Add/Remove</th>

                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  if ($EnrollNo == "") {
                                                echo "<span class='box blink'>Sorry this student doesn't blong to your branch !!</span>";
                                  }
                                  if (empty($this_cfp)) {
                                                ?>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>
                                                        <input type='text' class='form-control' value='<?= $EnrollNo ?>' required="" placeholder="Enrollno"/></td>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="CourseID[]"  value='<?= $CourseID ?>'/>
                                                        <input type="hidden" name="Stu_ID[]"  value='<?= $Stu_ID ?>'/>
                                                        <input type='text' class='form-control' value='<?= $CourseCode ?>' required=""  placeholder="Course Code"/></td>
                                                    <td>
                                                        <?php echo form_dropdown("FeeTypeID[]", $FeeTypeID, '', "class='form-control' required"); ?>                         
                                                    </td>
                                                    <td><input type='text' name='Inst_amt[]' class='form-control' value="" placeholder='Per Installment Amt' required/></td>
                                                    <td><input type='text' name='Total_Inst[]' class='form-control' value="" placeholder='Total Installments' required/></td>
                                                    <td><input type='text' name='Sort[]' class='form-control' value="" placeholder='Sort Order'/></td>
                                                    <td><input type='text' name='Remarks[]' class='form-control' placeholder='Remarks' value=""/></td>
                                                    <td> 
                                                        <button   type='button'   class='btn btn-danger btn-md' onclick="remove_row(this, 'stu_cfp', 1);">
                                                            <span class='glyphicon glyphicon-minus' ></span>
                                                        </button> 
                                                    </td> 
                                                </tr>
                                                <?php
                                  } else {
                                                foreach ($this_cfp as $cfp) {
                                                              ?>
                                                              <tr>
                                                                  <td>1.</td>
                                                                  <td>
                                                                      <input type='text' class='form-control' value='<?= $EnrollNo ?>'/></td>
                                                                  </td>
                                                                  <td>
                                                                      <input type="hidden" name="CourseID[]"  value='<?= $CourseID ?>'/>
                                                                      <input type="hidden" name="Stu_ID[]"  value='<?= $Stu_ID ?>'/>
                                                                      <input type='text' class='form-control' value='<?= $CourseCode ?>'/></td>
                                                                  <td>
                                                                      <?php echo form_dropdown("FeeTypeID[]", $FeeTypeID, $cfp->FeeTypeID, "class='form-control' required"); ?>                         
                                                                  </td>
                                                                  <td><input type='text' name='Inst_amt[]' class='form-control' value="<?php echo $cfp->Inst_amt; ?>" placeholder='Per Installment Amt' required/></td>
                                                                  <td><input type='text' name='Total_Inst[]' class='form-control' value="<?php echo $cfp->Total_Inst; ?>" placeholder='Total Installments' required/></td>
                                                                  <td><input type='text' name='Sort[]' class='form-control' value="<?php echo $cfp->Sort; ?>" placeholder='Sort Order'/></td>
                                                                  <td><input type='text' name='Remarks[]' class='form-control' placeholder='Remarks' value="<?php echo $cfp->Remarks; ?>"/></td>
                                                                  <td> 
                                                                      <button   type='button'   class='btn btn-danger btn-md' onclick="remove_row(this, 'stu_cfp', 1);">
                                                                          <span class='glyphicon glyphicon-minus' ></span>
                                                                      </button> 
                                                                  </td> 
                                                              </tr>
                                                <?php
                                                }
                                  }
                                  ?>
                              </tbody>
                              <tfoot>
                                  <tr><td colspan='8'><button   type='submit' name="save_scfp" value='Save' class='btn btn-success btn-md'>
                                              <span class='glyphicon glyphicon-save'></span> Save
                                          </button>&nbsp;&nbsp;<button   type='reset'   class='btn btn-primary btn-md'>
                                              <span class='glyphicon glyphicon-refresh'></span> Reset</button></td>
                                      <td>
                                          <button   type='button'   class='btn btn-primary btn-md' onclick="clone_row('stu_cfp', 1, 'total_row')">
                                              <span class='glyphicon glyphicon-plus'></span>
                                          </button>

                                      </td>
                                  </tr>
                              </tfoot>
                          </table>
                          <input type="hidden" name="total_row" value="<?php echo empty($this_cfp) ? 1 : count($this_cfp) ?>" id="total_row"/>
                      </form>
                  </div>

                  <div class="row bottom_gap">
                      <h4 class="group_title">Previous Set Fee Plan/s 
                          <a href="<?= base_url() ?>fees/Fee_Master/sscfp/<?= $Stu_ID ?>/<?= $CourseID ?>">
                              <button class="btn btn-md btn-info">
                                  <span class="glyphicon glyphicon-refresh"></span> Refresh
                              </button></a>
                          <a href="<?= base_url() . 'fees/Fee_Master/index/' . $Stu_ID . "/" . $CourseID ?>">
                              <button   type='button' class='btn-md btn btn-info ' title="Fee Collect">
                                  <span class='glyphicon glyphicon-send'></span> Fee Collect
                              </button>
                          </a>
              <!--            <a href="<?= base_url() . 'fees/Fee_Master/index/' . $Stu_ID . "/" . $CourseID ?>">
                              <button   type='button' class='btn-md btn btn-info ' title="Fee Collect">
                                  <span class='glyphicon glyphicon-edit'></span> Edit
                              </button>
                          </a>-->
                      </h4>
                  </div>
                  <script src="<?php echo base_url() ?>js/custom_js/table_manipulation/row_add_remove.js" type="text/javascript"></script>
                  <!-- fee plan -->
                  <?php echo $stu_fee_plan; ?>
                  <!-- end of fee plan -->
<?php } else { ?>
                  <div class="well well-sm bg-danger">
                      Sorry you need to create Fee Type first !! <a href="<?php echo base_url(); ?>fees/fee_type">Manage Fee Type</a>
                  </div>
<?php } ?>
</div>

