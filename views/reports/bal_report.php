<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Balance Report</h4>
        </div>
    </div>
    <form action="<?=  base_url()?>reports/export_report" id="Get_Balance_From" method="POST">
        <div class="row bottom_gap">        
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-2">Starting Date</div>
                    <div class="col-lg-4">
                        <div class="form-group">                  
                            <div class="input-group" id="date_btn">
                                <div class="form-group">
                                    <?php
                                    $str_month_date = date('Y', time()) . "-" . date('m', time()) . "-01";
                                    echo form_input("str_date", date(DF, strtotime($str_month_date)), array("class" => "'form-control DatePicker'", "placeholder" => "'Click to Pick DOR'"))
                                    ?>
                                </div>
                                <span class="input-group-btn">
                                    <button   type="button"  class="btn btn-default btn-md">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </button>
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">Ending Date</div>
                    <div class="col-lg-4">
                        <div class="form-group">                  
                            <div class="input-group" id="date_btn">
                                <div class="form-group">
                                    <?php echo form_input("end_date", date('d-m-Y'), array("class" => "'form-control DatePicker'", "placeholder" => "'Click to Pick DOR'")) ?>
                                </div>
                                <span class="input-group-btn">
                                    <button   type="button"  class="btn btn-default btn-md">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </button>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row bottom_gap">
            <div class="col-lg-12">

                <button   type="button" name="Get_Balance"  id="Get_Report" class="btn btn-primary btn-md">
                    <span class="glyphicon glyphicon-send"></span> Get Balance Report
                </button>
                <button   type="reset"  class="btn btn-info btn-md">
                    <span class="glyphicon glyphicon-refresh"></span> Reset
                </button>

            </div>
        </div>
    
    <div class="row bottom_gap">
        <div class="col-lg-12 text-center">
            <div class="btn-group" role="group" >
                <button type="submit" class="btn btn-primary btn-voilet" name="get_report" value="cvs_bal_report" >Excel(CSV)  <span class="glyphicon glyphicon-download-alt"></span></button>                
            </div>
        </div>
    </div>
    </form>
    <div class="row" id="result_bal">
        <?php 
          $this->load->view('reports/Balance_table_for_bal_report.php');
         ?>
        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
           </div>
    <script>
    $("#Get_Report").click(function(){
             var form_data = $("#Get_Balance_From");
              $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>Ajax/Get_Balance_Report",
                        data: form_data.serialize(),
                        dataType: "html",
                        success: function(result) {
                           $("#result_bal").html(result);    
                        }
                    });
         });   
    </script>

</div>