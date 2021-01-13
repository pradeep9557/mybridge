 <div class="row" id="basic_details">
                              <div class="col-lg-12">
                                  <button onclick="edit_basic_details('<?= $Enq_Details->E_Code ?>', 'collapseExample')" class="btn btn-success btn-xs pull-right" style="position: relative;  bottom: 4px;  right: 10px;"><span class="glyphicon glyphicon-edit"></span> Edit</button>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                  <table class="table table-responsive table-striped">
                                      <tr>
                                          <td>
                                              Branch Code
                                          </td>
                                          <td>
                                              <?= strtoupper($Enq_Details->BranchCode) ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Enquiry Code
                                          </td>
                                          <td>
                                              <?= $Enq_Details->E_Code ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Enquiry Form No
                                          </td>
                                          <td>
                                              <?= $Enq_Details->EFormNo ?>
                                          </td> 
                                      </tr>
                                      <tr>
                                          <td>
                                              Mobile No
                                          </td>
                                          <td>
                                              <?= $Enq_Details->Mobile1 ?>
                                          </td> 
                                      </tr>
                                      <tr>
                                          <td>
                                              Phone No
                                          </td>
                                          <td>
                                              <?= $Enq_Details->Phone1 ?>
                                          </td> 
                                      </tr>
                                      <tr>
                                          <td>
                                              Email No
                                          </td>
                                          <td>
                                              <?= $Enq_Details->Email1 ?>
                                          </td> 
                                      </tr>
                                      <tr>
                                          <td>
                                              Added By
                                          </td>
                                          <td>
                                              <?= $Enq_Details->Add_User ?>
                                          </td> 
                                      </tr>
                                      <tr>
                                          <td>
                                              Modified by
                                          </td>
                                          <td>
                                              <?= $Enq_Details->Mode_User ?>
                                          </td> 
                                      </tr>
                                      <tr>
                                          <td>
                                              Added DateTime
                                          </td>
                                          <td>
                                              <?= date(DTF, strtotime($Enq_Details->Add_DateTime)) ?>
                                          </td> 
                                      </tr>
                                      <tr>
                                          <td>
                                              Last Modified
                                          </td>
                                          <td>
                                              <?= date(DTF, strtotime($Enq_Details->Mode_DateTime)) ?>
                                          </td> 
                                      </tr>
                                  </table> 
                              </div>
                              <div class="col-lg-4">
                                  <table class="table table-responsive table-striped">
                                      <tr>
                                          <td>
                                              Student Name
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->StudentName) ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Father's Name
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->FatherName) ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Mother's Name
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->MotherName) ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>DOB</td>
                                          <td><?= date(DF, strtotime($Enq_Details->DOB)) ?></td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Gender
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->Gender) ?>
                                          </td>
                                      </tr>
                                      <tr>

                                          <td>
                                              H. Quali
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->Qname) ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Curr. Doing
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->CurrDoingCode) ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Nationality
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->Nname) ?>
                                          </td>
                                      </tr>
                                  </table>
                              </div>
                              <div class="col-lg-4">
                                  <table class="table table-responsive table-striped">
                                      <tr>
                                          <td>
                                              Gali No.
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->C_Galino) ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Block
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->Block) ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Address
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->C_Add) ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Locality
                                          </td>
                                          <td>
                                              <?php
                                              echo ucfirst(isset($locality_list[$Enq_Details->C_Locality])?$locality_list[$Enq_Details->C_Locality]:"");?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Sub-Locality
                                          </td>
                                          <td>
                                              <?= ucfirst(isset($locality_list[$Enq_Details->C_SubLocality])?$locality_list[$Enq_Details->C_SubLocality]:"") ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              State
                                          </td>
                                          <td>
                                              <?= ucfirst(isset($state_list[$Enq_Details->C_State])?$state_list[$Enq_Details->C_State]:"") ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              City
                                          </td>
                                          <td>
                                              <?= ucfirst(isset($city_list[$Enq_Details->C_City])?$city_list[$Enq_Details->C_City]:"") ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Country
                                          </td>
                                          <td>
                                              <?= ucfirst(isset($country_list[$Enq_Details->C_Country])?$country_list[$Enq_Details->C_Country]:"") ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              Pincode
                                          </td>
                                          <td>
                                              <?= ucfirst($Enq_Details->C_Pincode) ?>
                                          </td>
                                      </tr>
                                  </table>
                              </div>
                          </div>
<script>
 // to edit basic details !!
              function edit_basic_details(E_Code, resultDiv) {
                  preloader.on();
                  $.ajax({
                      url: "<?= base_url() . "Enquiry/enquiry/edit_ebasic_details/" ?>" + E_Code,
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {
                          $("#" + resultDiv).html('<?=  AJAXPRELOADER?>');           
                          $("#" + resultDiv).html(data);
                          var config = {
                              '.chosen-select': {},
                              '.chosen-select-deselect': {allow_single_deselect: true},
                              '.chosen-select-no-single': {disable_search_threshold: 10},
                              '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                              '.chosen-select-width': {width: "95%"}
                          }
                          for (var selector in config) {
                              $(selector).chosen(config[selector]);
                          }
                      },
                      complete: function (jqXHR, textStatus) {

                      },
                      error: function (jqXHR, textStatus, errorThrown) {

                      }
                  });
                  preloader.off();
              }
</script>