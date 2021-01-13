<!--<div id="page-wrapper" style="min-height: 345px;">

<div class="row bottom_gap">
        
        <h4 class="page-header">Search Your Student</h4>
        <form action="" method="POST" role="from" id="Search_Form">
            <div class="col-lg-2 padding_top_label">Enrollment Number</div>
            <div class="col-lg-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="Search_EnrollNo" placeholder="Enroll No or Receipt No" id="Search_EnrollNo"/>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="padding_top_label">
                    <input type="radio" name="Searching_option" checked="" class="vertical_align_top" value="EnrollNo"/>&nbsp; <span class="vertical_align_top">EnrollNo</span>
                </label>
                <label class="padding_top_label">
                    <input type="radio" name="Searching_option" class="vertical_align_top" value="Receipt_Number"/>&nbsp;<span class="vertical_align_top">Receipt No</span>
                </label>
                <label class="padding_top_label">
                    <input type="radio" name="Searching_option" class="vertical_align_top" id="btw_dates_checkbox" onclick="show_this('btw_dates')" value="Between_Dates"/>&nbsp;<span class="vertical_align_top">Between Date</span>
                </label>
                <div id="btw_dates" class="hidden">
                <fieldset>
                  <div class="control-group">
                    <div class="controls">
                     <div class="input-group">
                       <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                       <input type="text" name="between_dates" id="reservation" class="form-control" value="<?=date('m/d/Y',strtotime('-7 days'))?> - <?=date('m/d/Y',time())?>" /> 
                       <span class="add-on input-group-addon" onclick="hide_this('btw_dates')"><i class="glyphicon glyphicon-minus fa fa-minus"></i></span>
                     </div>
                    </div>
                  </div>
                 </fieldset>
                 </div>
                <script type="text/javascript">
               $(document).ready(function() {
                  $('#reservation').daterangepicker(null, function(start, end, label) {
                    console.log(start.toISOStrinig(), end.toISOString(), label);
                  });
               });
               
               </script>
                <label class="padding_top_label">
                    <input type="radio" name="Searching_option" class="vertical_align_top" onclick="show_this('avn_search')" value="Advance_Search"/>&nbsp;<span class="vertical_align_top">Advance Search</span>
                </label>
               <div class="col-lg-12 hidden" id="avn_search">
                    <div class="col-lg-6">Advance Search</div>
                    <div class="col-lg-6">
                        <span class="add-on input-group-addon" onclick="hide_this('avn_search')"><i class="glyphicon glyphicon-minus fa fa-minus"></i></span>
                    </div>
                        <div class="col-lg-6">Student Name</div>
                        <div class="col-lg-6"><input type="text" name="Name" placeholder="Student Name" class="form-control"/></div>
                        <div class="col-lg-6">Father's Name</div>
                        <div class="col-lg-6"><input type="text" name="FatherName" placeholder="Father's Name" class="form-control"/></div>
                        <div class="col-lg-6">Batch Code</div>
                        <div class="col-lg-6"><input type="text" name="BatchCode" placeholder="Batch Code" class="form-control"/></div>
                        <div class="col-lg-6">Faculty Code</div>
                        <div class="col-lg-6"><input type="text" name="FacultyCode" placeholder="Faculty Code" class="form-control"/></div>
                    
                </div>
            </div>
            <div class="col-lg-2">
                <button type="button" name="Search" value="Save" class="btn btn-success btn-md" id="search_student">
                    <span class="glyphicon glyphicon-search"></span> Search
                </button>
                
            </div>
        </form>
          to search fee records 
    </div>
    <div class="row hidden bottom_gap" id="Searching_Result">
        Result Div 
       <div class="progress hidden" style="margin: 8px 14px;" id="progress_bar">
  <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
    <span class="sr-only">45% Complete</span>
  </div>
</div>
    </div>-->