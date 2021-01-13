<style>
    .table > thead > tr > th, .table > tbody > tr > th, 
    .table > tfoot > tr > th, .table > thead > tr > td, 
    .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 2px;
        line-height: 1;
        vertical-align: top;
        border-top: none;
        font-size: 13px;
    }
    .fix_td_width{
        width: 36%;
    }
</style>
<div id="page-wrapper" style="min-height: 345px;">
<!--    <div class="row padding_left_0px">
        <h4 class="page-header ">All Fee History</h4>
    </div>-->
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
    
</div>
