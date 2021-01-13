

<div class="panel red_panel">
    <div class="panel-heading" data-toggle="collapse" data-target="#global_enq_search">
        <h3 class="panel-title toggle_custom">Search Enquiry<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="panel-body <?php echo isset($collapse) ? $collapse : 'collapse'; ?>" id="global_enq_search">
        <div class="col-lg-12">

            <?php
            echo form_open("", "id='enq_searching_form'");
            ?>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">Basic Search</div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?php
                    echo form_dropdown("search_via[]", $Search_List, "", "class='form-control' Placeholder='Select Field' onchange='change_placeholder(this)'");
                    ?>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?php
                    echo form_input("search_via_value[]", "", "class='form-control' id='pl' Placeholder=''");
                    ?>
                </div>


                <!--                <div class="col-lg-2">
                <?php
                echo form_input("E_Code", "", "class='form-control col-lg-2 col-md-2 col-sm-12 col-xs-12' Placeholder='Enq Code'");
                ?>
                                </div>
                                 <div class="col-lg-2">
                <?php
                echo form_input("EF_No", "", "class='form-control col-lg-2 col-md-2 col-sm-12 col-xs-12' Placeholder='Enq Form Number'");
                ?>
                                </div>-->
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <button class="btn btn-success" type="button" name="Search" onclick="search_data()">
                        <span class="glyphicon glyphicon-search"></span>
                        Search</button>          
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <input class="bootswitches"   name="adv_search" type="checkbox"  value="Adv_search"  data-label-text="Advance Search" toggle="yes" toggleid="global_adv_enq_search">
                </div>
            </div>
            <br>
            <div class="row bottom_gap col-lg-offset-4">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="btn-group" role="group" aria-label="..."> 
                        <button type="button" class="btn btn-primary" onclick="export_csv()">Export CSV</button>
                        <button type="button" class="btn btn-primary" onclick="export_xls()">Export XLS</button>
                    </div>
                </div>
            </div>
            <!--            <div class="row bottom_gap">
                            <div class="col-lg-offset-5">
                                      <input class="bootswitches"   name="adv_search" type="checkbox"  value="Adv_search"  data-label-text="Advance Search" toggle="yes" toggleid="global_adv_enq_search">
                            </div>
                        </div>-->
            <div class="row" id="global_adv_enq_search" style="display: none"> 
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    Date Wise
                </div>
                <div class="col-lg-10 row bottom_gap">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <?php
                        echo form_dropdown("DOE_DOR", array("" => "Select date pattern", "DOE" => "DOE Wise", "DOR" => "DOR Wise"), "", "class='form-control chosen-select'");
                        ?>    
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker6'>
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
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class='input-group date'  id='datetimepicker7'>
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
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <input class="bootswitches"   name="todays_enq" type="checkbox"  value="todays_enq"  data-label-text="Today">                                  
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    PRO Wise
                </div>
                <div class='col-lg-10 col-md-10 col-sm-12 col-xs-12 bottom_gap'>

                    <?php
                    echo form_multiselect("PROList[]", $AllPRO, array($Branch_obj->procode => $Branch_obj->procode), "class='form-control chosen-select'");
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    Source Wise
                </div>
                <div class='col-lg-10 col-md-10 col-sm-12 col-xs-12 bottom_gap'>

                    <div class="form-group">
                        <?php
                        echo form_multiselect("SrcList[]", $source_list, array(), "class='form-control  chosen-select'");
                        ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    Course Wise
                </div>
                <div class='col-lg-10 col-md-10 col-sm-12 col-xs-12 bottom_gap'>
                    <?php
                    echo form_multiselect("CourseList[]", $All_Course_List, array(), "class='form-control chosen-select'");
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    Locality Wise
                </div>
                <div class='col-lg-10 col-md-10 col-sm-12 col-xs-12 bottom_gap'>
                    <?php
                    echo form_multiselect("LocalityList[]", $locality_list, array(), "class='form-control chosen-select'");
                    ?>
                </div>
            </div>

            <?php
            echo form_close();
            ?>
        </div>
        <div class="col-lg-12" id="global_enq_search_result">
            <!-- enquiry search ajax will rendered in this div -->         
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker();
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
    function search_data() {
        //    alert("hii");
        //event.preventDefault();
        preloader.on();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Enquiry/enquiry/search_enq",
            data: $("#enq_searching_form").serialize(),
            dataType: "html",
            success: function (search_data) {
                $("#global_enq_search_result").html(search_data);
                preloader.off();
            }
        });
    }


    function change_placeholder(that) {
        $("#pl").attr("placeholder", $(that).children(":selected").text());
    }

    function export_csv() {
        $("#enq_searching_form").attr("action", "<?php echo base_url(); ?>reports/csv_exporter/export_search_enq");
        $("#enq_searching_form").submit();
    }
    function export_xls() {
        $("#enq_searching_form").attr("action", "<?php echo base_url(); ?>reports/xls_exporter/export_search_enq");
        $("#enq_searching_form").submit();
    }

    $(document).ready(function () {
        search_data();
        // console.log("hii");
    });
</script>
