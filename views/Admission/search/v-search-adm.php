

<div class="panel panel-primary">
    <div class="panel-heading" data-toggle="collapse" data-target="#global_adm_search">
        <h3 class="panel-title toggle_custom">Search Admission Details<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body <?php echo isset($collapse) ? $collapse : '' ?>" id="global_adm_search">
        <div class="col-lg-12">

            <?php
            echo form_open(base_url() . "adm/cadm/search_adm", "id='adm_searching_form'");
            ?>
            <div class="row bottom_gap">
                <div class="col-lg-2">Basic Search</div>
                <div class="col-lg-2">
                    <?php
                    echo form_dropdown("search_via[]", $AdmSearch_List, "", "class='form-control' Placeholder='Select Field'");
                    ?>
                </div>

                <div class="col-lg-2">
                    <?php
                    echo form_input("search_via_value[]", "", "class='form-control' Placeholder='Mobile Number'");
                    ?>
                </div>
                <div class="col-lg-4">
                    <div class="btn-group" role="group" aria-label="...">
                        <button class="btn btn-success" type="button" name="Search" onclick='search_adm_data()'>
                            <span class="glyphicon glyphicon-search"></span>
                            Search</button> 
                        <button type="button" class="btn btn-primary" onclick="export_csv()">Export CSV</button>
                        <button type="button" class="btn btn-primary" onclick="export_xls()">Export XLS</button>
                    </div>
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
                <div class="col-lg-2">
                    Date Wise
                </div>
                <div class="col-lg-10 row bottom_gap">
                    <div class="col-lg-2">
                        <?php
                        echo form_dropdown("DOE_DOR", array("" => "Select date pattern", "DOR" => "DOR Wise"), "DOR", "class='form-control chosen-select'");
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
                <div class="col-lg-2">
                    Locality Wise
                </div>
                <div class='col-lg-10 bottom_gap'>
                    <?php
                    echo form_multiselect("LocalityList[]", $locality_list, array(), "class='form-control chosen-select'");
                    ?>
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
            url: $("#adm_searching_form").attr('action'),
            data: $("#adm_searching_form").serialize(),
            dataType: "html",
            success: function (search_data) {
                $("#global_adm_search_result").html(search_data);
                preloader.off();
                //blink();
            }
        });
    }
//              

    function export_csv() {
        $("#adm_searching_form").attr("action", "<?php echo base_url(); ?>reports/csv_exporter/export_search_adm");
        $("#adm_searching_form").submit();
    }
    function export_xls() {
        $("#adm_searching_form").attr("action", "<?php echo base_url(); ?>reports/xls_exporter/export_search_adm");
        $("#adm_searching_form").submit();
    }
    // search_adm_data();
    $(document).ready(function(){
       search_adm_data();      
       console.log("hii");
    });
</script>
