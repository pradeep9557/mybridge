<?php if ($Stu_ID != "") { ?>
              <div class="fee_history_icon" id="fee_history_icon" onclick="load_fee_history(<?php echo $Stu_ID; ?>,''<?php //echo $CourseID; ?>, 'fees_history_data','fee_history_div','fee_history_icon')">
                  <span class="glyphicon glyphicon-eye-open"> </span> Fee History
              </div>

              <div class="fee_history_div hidden" id="fee_history_div">
                  <span class="fee_history_div_title">Fee History</span>
                  <button class="btn btn-sm btn-danger pull-right" onclick="close_fee_history_div('fee_history_div','fee_history_icon')">
                      <span class="glyphicon glyphicon-remove"></span>  Close
                  </button>
                  <div class="col-lg-12">
                      <div id="fees_history_data">
                      </div>       
                  </div>
              </div>
<?php } ?>