<div class="col-lg-12" id="basic_details">
    <form id="save_basic_e_details">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" >
        <table class="table  table-striped">
            <tr>
                <td>
                    Branch Code
                </td>
                <td>
                    <?php
                    echo form_dropdown("",array($Enq_Details->BranchCode=>$Enq_Details->BranchCode),$Enq_Details->BranchCode,"class='form-control chosen-select'");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Enquiry Code
                </td>
                <td>
                    <?php echo form_input("E_Code",$Enq_Details->E_Code,"class='form-control' readonly");  ?>
                </td>
            </tr>
            <tr>
                <td>
                    Enquiry Form No
                </td>
                <td>
                    <?php echo form_input("",$Enq_Details->EFormNo,"class='form-control' readonly");  ?>
                </td> 
            </tr>
            <tr>
                <td>
                    Mobile No
                </td>
                <td>
                   <?php echo form_input("Mobile1",$Enq_Details->Mobile1,"class='form-control'");  ?>
                </td> 
            </tr>
            <tr>
                <td>
                    Phone No
                </td>
                <td>
                    <?php echo form_input("Phone1",$Enq_Details->Phone1,"class='form-control'");  ?>
                </td> 
            </tr>
            <tr>
                <td>
                    Email No
                </td>
                <td>
                    <?php echo form_input("Email1",$Enq_Details->Email1,"class='form-control'");  ?>
                </td> 
            </tr>
            <tr>
                <td>
                    Added By
                </td>
                <td>
                    <?php echo form_input("",$Enq_Details->Add_User,"class='form-control'");  ?>
                </td> 
            </tr>
            <tr>
                <td>
                    Added DateTime
                </td>
                <td>
                    <?php echo form_input("",date(DTF, strtotime($Enq_Details->Add_DateTime)),"class='form-control readonly'");  ?>
                </td> 
            </tr>
            
        </table> 
    </div>
    <div class="col-lg-4">
        <table class="table  table-striped">
             <tr>
                <td>DOB</td>
                <td>
                     <div class="form-group">
                      <div class='input-group date bdatepicker' >
                          <input type='text' class="form-control" name="DOB" value="<?= date(DF, strtotime($Enq_Details->DOB)) ?>"/>
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>
                  <script>
             $('.bdatepicker').datetimepicker({
              format: 'DD-MM-YYYY'
        }     );</script>   
            </tr>
            <tr>
                <td>
                    Student Name
                </td>
                <td>
                   <?php echo form_input("StudentName",$Enq_Details->StudentName,"class='form-control'");  ?>
                </td>
            </tr>
            <tr>
                <td>
                    Father's Name
                </td>
                <td>
                    <?php echo form_input("FatherName",$Enq_Details->FatherName,"class='form-control'");  ?>
                </td>
            </tr>
            <tr>
                <td>
                    Mother's Name
                </td>
                <td>
                    <?php echo form_input("MotherName",$Enq_Details->MotherName,"class='form-control'");  ?>
                </td>
            </tr>
           
           
            <tr>
                <td>
                    Gender
                </td>
                <td>
                    <?php echo form_dropdown("Gender",array("Male"=>"Male","Female"=>"Female"),ucfirst($Enq_Details->Gender),"class='form-control chosen-select'"); ?>
                </td>
            </tr>
            <tr>

                <td>
                    H. Quali
                </td>
                <td>
                    <?php echo form_dropdown("Quali",$Quali_list,$Enq_Details->Quali,"class='form-control chosen-select'");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Curr. Doing
                </td>
                <td>
                            <?php echo form_dropdown("CurrentDoing",$c_doing,$Enq_Details->CurrentDoing,"class='form-control chosen-select'"); ?>
                  
                </td>
            </tr>
            <tr>
                <td>
                    Nationality
                </td>
                <td>
                     <?php echo form_dropdown("NID",$nationality_list,$Enq_Details->NID,"class='form-control chosen-select'"); ?>
                   
                </td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4">
        <table class="table  table-striped">
            <tr>
                <td>
                   Gali No
                </td>
                <td>
                    <?php echo form_input("C_Galino",$Enq_Details->C_Galino,"class='form-control'");  ?>
                </td>
            </tr>
            <tr>
                <td>
                  Block
                </td>
                <td>
                    <?php echo form_input("Block",$Enq_Details->Block,"class='form-control'");  ?>
                </td>
            </tr>
            <tr>
                <td>
                    Address
                </td>
                <td>
                    <?php echo form_textarea("C_Add", $Enq_Details->C_Add, array("class" => "'form-control'", "placeholder" => "'Complete Address'"), 3, 3) ?>                               
                </td>
            </tr>
           
             <tr>
                <td>
                    Country
                </td>
                <td>
                     <?php echo form_dropdown("C_Country", $country_list, $Enq_Details->C_Country, "class='form-control chosen-select' onchange=load_states(this.value,'c_state')") ?>
                   
                </td>
            </tr>
            <tr>
                <td>
                    State
                </td>
                <td>
                    <div id="c_state">
                  <?php echo form_dropdown("C_State", $state_list, $Enq_Details->C_State, "class='form-control chosen-select' onchange=load_cities(this.value,'city_id')") ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    City
                </td>
                <td>
                    <div id="city_id">
                    <?php echo form_dropdown("C_City", $City_list, $Enq_Details->C_City, "class='form-control chosen-select' onchange=load_locality(this.value,'locality')") ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Locality
                </td>
                <td>
                    <div id="locality">                        
                    <?php echo form_dropdown("C_Locality", $locality_list, $Enq_Details->C_Locality, "class='form-control chosen-select' onchange=load_sub_locality(this.value,'sublocality')") ?> 
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Sub-Locality
                </td>
                <td>
                    <div id="sublocality">
                    <?php echo form_dropdown("C_SubLocality", array(), $Enq_Details->C_SubLocality, "class='form-control chosen-select'") ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Pincode
                </td>
                <td>
                    <?php echo form_input("C_Pincode",$Enq_Details->C_Pincode,"class='form-control'"); ?>
                    
                </td>
            </tr>
        </table>
    </div>
      <div class="col-lg-12">
          <div class="col-lg-2"><button type="button" class="btn btn-success" onclick="save_form('save_basic_e_details')"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button></div>
      </div>
    </form>
</div>

<script>
            function save_form(form_id){
                preloader.on();
                form_data = $("#"+form_id);          
                swal({
                title: "Are you sure?",
                text: "Wanna Save Filled details",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes !',
                cancelButtonText: "No, cancel Please!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>Enquiry/enquiry/save_basic_details",
                        data: form_data.serialize(),
                        dataType: "json",
                        success: function(result) {
                            if (result['success']) {
                                swal("Updated !!", "Your Enquiry Details  has been Saved Successfully !", "success");
                                show_updated_basic_details(result['E_Code'],'collapseExample');
                            } else {
                                var _err_msg = result['_err_msg'];
                                if (_err_msg != "")
                                    swal("Cancelled", _err_msg, "error");
                                else
                                    swal("Cancelled", "Sorry Error Occurred !! :)", "error");
                            }
                            //                            .animate({opacity: "hide"}, "slow").remove();
                        }
                    });
                } else {
                    swal("Cancelled", "Your Details are safe :)", "error");
                }
            });
            preloader.off();
            }
             function show_updated_basic_details(E_Code,resultDiv){
             preloader.on();
             $.ajax({
                      url: "<?= base_url() . "Enquiry/enquiry/show_updated_basic_details/" ?>" + E_Code,
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {
                          $("#" + resultDiv).html(data);
                      },
                      complete: function (jqXHR, textStatus) {

                      },
                      error: function (jqXHR, textStatus, errorThrown) {

                      }
                  });
                  preloader.off();
              }
              </script>
   <?php
    $this->load->view("Enquiry/others/area_locality_ajax_func");
   ?>           