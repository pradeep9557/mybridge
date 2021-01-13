

<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#global_adm_search">
        <h3 class="panel-title toggle_custom">Search Admission Details<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body " id="global_adm_search">
        <div class="col-lg-12">

            <?php
            echo form_open("", "id='adm_searching_form'");
            ?>
            <div class="row bottom_gap">
                <div class="col-lg-2">Basic Search</div>
                <div class="col-lg-2">
                    <?php
                    echo form_dropdown("search_via[]", $input_fields, "", "class='form-control' Placeholder='Select Field'");
                    ?>
                </div>

                <div class="col-lg-2">
                    <?php
                    echo form_input("search_via_value[]", "", "class='form-control' Placeholder='Mobile Number'");
                    ?>
                </div>



                <div class="col-lg-3">
                    <button class="btn btn-success" type="button" name="Search" onclick="search_adm_data()">
                        <span class="glyphicon glyphicon-search"></span>
                        Search</button> 
                    <?php
                  if(FEE_COLLECT_TYPE==2){
                ?>
                    <button class="btn btn-success" type="button" name="" onclick="calculate_faculty_share()">
                        <span class="glyphicon glyphicon-euro"></span>
                        Calculate</button> 
                    <?php
                  }
                ?>
                </div>
                <div class="col-lg-2">
                    <input class="bootswitches"   name="adv_search" type="checkbox" checked=""  value="Adv_search"  data-label-text="Advance Search" toggle="yes" toggleid="global_adv_adm_search">
                </div>
            </div>
            <!--            <div class="row bottom_gap">
                            <div class="col-lg-offset-5">
                                      <input class="bootswitches"   name="adv_search" type="checkbox"  value="Adv_search"  data-label-text="Advance Search" toggle="yes" toggleid="global_adv_adm_search">
                            </div>
                        </div>-->
            <div class="row" id="global_adv_adm_search" > 
                <div class="row">
                    <div class="col-lg-2">
                        Receipt Date Wise
                    </div>
                    <div class="col-lg-10 row bottom_gap">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class='input-group date' id='datetimepickeradm6'>
                                    <span class="input-group-addon">
                                        From
                                    </span>
                                    <input type='text' class="form-control" name="From" value="<?= date("m/d/Y h:i:s", strtotime(Month . "/01/" . Year)) ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>              
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class='input-group date'  id='datetimepickeradm7'>
                                    <span class="input-group-addon">
                                        To
                                    </span>
                                    <input type='text' class="form-control" name="To" value="<?= date("m/d/Y h:i:s") ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>              
                        </div>
                        <div class="col-lg-2">
                            <input class="bootswitches"   name="todays_adm" type="checkbox"  value="todays_adm"  data-label-text="Today">                                  
                        </div>

                    </div>
                </div>
                <?php
                  if(FEE_COLLECT_TYPE==2){
                ?>
                <div class="row">
                    <div class="col-lg-2">
                        Faculty Share 
                    </div>   
                    <div class="col-lg-2">
                        <?php
                        echo form_dropdown("amount_shared", $amount_share_options, "both", "class='chosen-select form-control'")
                        ?>
                    </div>

                </div>
                  <?php } ?>
                <div class="row text-center">

                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-primary" onclick="export_csv()">Export CSV</button>
                        <button type="button" class="btn btn-primary" onclick="export_xls()">Export XLS</button>
                   </div>
                </div>




            </div>
            <?php
            echo form_close();
            ?>
        </div>
        <div class="col-lg-12" id="global_adm_search_result">
            <!-- admuiry search ajax will rendered in this div -->         
        </div>
    </div>
</div>
<script>
              $(function () {
                  $('#datetimepickeradm6').datetimepicker();
                  $('#datetimepickeradm7').datetimepicker();
                  $("#datetimepickeradm6").on("dp.change", function (e) {
                      $('#datetimepickeradm7').data("DateTimePicker").minDate(e.date);
                  });
                  $("#datetimepickeradm7").on("dp.change", function (e) {
                      $('#datetimepickeradm6').data("DateTimePicker").maxDate(e.date);
                  });
              });

              function search_adm_data() {
                  preloader.on();
                  $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>fees/Fee_Master_1/search_fee_recoreds",
                      data: $("#adm_searching_form").serialize(),
                      dataType: "html",
                      success: function (search_data) {
                          $("#global_adm_search_result").html(search_data);
                          preloader.off();
                          //blink();
                      }
                  });
              }
              function calculate_faculty_share() {
                  $("#adm_searching_form").attr("action", "<?php echo base_url(); ?>fee_share/c_share/calculate_faculty_share");
                  $("#adm_searching_form").submit();
              }
              function export_csv() {
                  $("#adm_searching_form").attr("action", "<?php echo base_url(); ?>reports/csv_exporter/export_all_fee_records");
                  $("#adm_searching_form").submit();
              }
              function export_xls() {
                  $("#adm_searching_form").attr("action", "<?php echo base_url(); ?>reports/xls_exporter/export_all_fee_records");
                  $("#adm_searching_form").submit();
              }

$(document).ready(function(){
              search_adm_data();
});


</script>
