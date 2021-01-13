

<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#global_bupdate_search">
        <h3 class="panel-title toggle_custom">Search Admission Details<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body <?php echo isset($collapse) ? $collapse : '' ?>" id="global_bupdate_search">
        <div class="col-lg-12">

            <?php
            echo form_open(base_url() . "batch/batch_master/search_batches", "id='bupdate_searching_form'");
            ?>
            
            <!--            <div class="row bottom_gap">
                            <div class="col-lg-offset-5">
                                      <input class="bootswitches"   name="adv_search" type="checkbox"  value="Adv_search"  data-label-text="Advance Search" toggle="yes" toggleid="global_adv_adm_search">
                            </div>
                        </div>-->
            <div class="row" id="global_adv_adm_search" style="display: none"> 
                <div class="col-lg-12 bottom_gap">
                <div class="col-lg-2 padding_left_0px">Basic Search</div>
                <div class="col-lg-2 padding_left_0px">
                    <?php
                    echo form_dropdown("search_via[]", $b_update_searching_option, "", "class='form-control' Placeholder='Select Field'");
                    ?>
                </div>

                <div class="col-lg-2">
                    <?php
                    echo form_input("search_via_value[]", "", "class='form-control' Placeholder='Mobile Number'");
                    ?>
                </div>
                    <div class="col-lg-2">
                              Batch Status
                </div>
                    <div class="col-lg-2">
                             <?php
                              echo form_multiselect("BatchStatusID[]",$All_Batch_Status,array(),"class='form-control chosen-select'");
                             ?>
                </div>
                </div>
                <div class="col-lg-2">
                    Date Wise
                </div>
                <div class="col-lg-10 row bottom_gap">
                    <div class="col-lg-2">
                        <?php
                        echo form_dropdown("DOE_DOR", array("" => "Select date pattern", "DOR" => "DOR Wise"), "", "class='form-control chosen-select'");
                        ?>    
                    </div>
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


                <div class="col-lg-2">
                    Course Wise
                </div>
                <div class='col-lg-10 bottom_gap'>
                    <?php
                    echo form_multiselect("CourseList[]", $All_Course_List, array(), "class='form-control chosen-select'");
                    ?>
                </div>
                
            </div>
            <div class="row bottom_gap">
                 <div class="col-lg-2">
                   Faculty & Batch wise
                </div>
                 <div class="col-lg-2">
                     <input class="bootswitches"   name="via_fac_batch" checked="" type="checkbox"  value="1"  data-label-text="acitve">                                  
                    </div>
                
                <div class='col-lg-2 bottom_gap'>
                    <?php
                    echo form_dropdown("fac_id", $fac_list, array(), "class='form-control chosen-select Get_batches' result_id='search_batches' bname='batchid'");
                    ?>
                </div>
                <div class="col-lg-3" id='search_batches'>
                    <?php
                    echo form_dropdown("batchid", $fac_batch_list, array(), "class='form-control chosen-select'");
                    ?>      
                </div>
                
                <div class="col-lg-3">
                    <button class="btn btn-success" type="button" onclick="search_bupdate_data()" name="Search">
                        <span class="glyphicon glyphicon-search"></span>
                        Search</button>         
                    <input class="bootswitches"   name="adv_search" type="checkbox"  value="Adv_search"  data-label-text="Adv Search" toggle="yes" toggleid="global_adv_adm_search">
                </div>
            </div>
            
            <?php
            echo form_close();
            ?>
        </div>
        <div class="col-lg-12" id="global_bupdate_search_result">
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

              function search_bupdate_data() { 
                  preloader.on();
                  $.ajax({
                      type: "POST",
                      url: $("#bupdate_searching_form").attr('action'),
                      data: $("#bupdate_searching_form").serialize(),
                      dataType: "html",
                      success: function (search_data) {
                          $("#global_bupdate_search_result").html(search_data);
                          preloader.off();
                      }
                  });
              }
//              

   
</script>
