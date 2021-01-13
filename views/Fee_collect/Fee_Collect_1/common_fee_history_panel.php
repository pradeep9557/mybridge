

<?php if (isset($stu_fee_plan)) { ?>
              <div class="row">
                  <h4 class="page-header ">Previous Fee Plan</h4>
                  <div class="col-lg-12">  

                      <?php
                      echo $stu_fee_plan;
                      ?>
                  </div>
              </div>
<?php } ?>

<?php if (isset($last_fee_record)) { ?>
              <div class="row">
                  <h4 class="page-header ">Previous Fee Records</h4>
                  <div class="col-lg-12">  

                      <?php
                      echo $last_fee_record;
                      ?>
                  </div>
              </div>
<?php } ?>
