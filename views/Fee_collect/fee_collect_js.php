<script>
              $(document).ready(function () {
                  $('#Search_Form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          Search_EnrollNo: {
                              validators: {
                                  notEmpty: {
                                      message: 'EnrollNo is required and can\'t be empty'
                                  }
                              }
                          }
                      }});
              });
              $(document).ready(function () {
                  $('#Fee_collect_EnrollNo_Form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          EnrollNo: {
                              validators: {
                                  notEmpty: {
                                      message: 'EnrollNo is required and can\'t be empty'
                                  }
                              }
                          }
                      }});
              });
              //      Form Validation           
              $(document).ready(function () {
                  $('#fee_collect_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          ChDate: {
                              validators: {
                                  date: {
                                      format: 'DD-MM-YYYY',
                                      message: 'The value is not a valid date'
                                  }
                              }
                          }, ReceiptDate: {
                              validators: {
                                  notEmpty: {
                                      message: 'Receipt Date required and can\'t be empty'
                                  },
                                  date: {
                                      format: 'DD-MM-YYYY',
                                      message: 'The value is not a valid date'
                                  }
                              }
                          }, BalDueDate: {
                              validators: {
                                  date: {
                                      format: 'DD-MM-YYYY',
                                      message: 'The value is not a valid date'
                                  }
                              }
                          }, NextDueDate: {
                              validators: {
                                  date: {
                                      format: 'DD-MM-YYYY',
                                      message: 'The value is not a valid date'
                                  }
                              }
                          }, AfterNextDueDate: {
                              validators: {
                                  date: {
                                      format: 'DD-MM-YYYY',
                                      message: 'The value is not a valid date'
                                  }
                              }
                          }, TotalAmt: {
                              message: 'Total Amount is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'Total amount is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                              }
                          }, ProspectusCostAmt: {
                              message: 'Prospectus Cost Amt is not valid',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                              }
                          }, RegFeeAmt: {
                              message: 'Wrong amount',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                              }
                          }, MonthlyChargeAmt: {
                              message: 'Wrong amount',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                              }
                          }, LatePaymentAmt: {
                              message: 'Wrong amount',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                              }
                          }, StudyMaterialCostAmt: {
                              message: 'Wrong amount',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                              }
                          }, OtherAmt: {
                              message: 'Wrong amount',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                              }
                          }, DisAmt: {
                              message: 'Wrong amount',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_DIS_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_DIS_AMT; ?> Amount'
                                  }
                              }
                          }, BalanceDetails: {
                              message: 'Wrong balance details',
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9.'\s]+$/,
                                      message: 'Wrong balance details'
                                  }
                              }
                          }, NextInstAmt: {
                              message: 'Wrong amount',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                              }
                          }, AfterNextInstAmt: {
                              message: 'Wrong amount',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9.]+$/,
                                      message: 'Wrong amount'
                                  }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                              }
                          }, Remarks: {
                              message: 'No spacial characters are allowed',
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9\s]+$/,
                                      message: 'No spacial characters are allowed'
                                  }, stringLength: {
                                      min: 3,
                                      max: 150,
                                      message: 'The Remarks must be 3-150 characters long'
                                  }
                              }
                          }, BankName: {
                              message: 'No spacial characters are allowed',
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'No spacial characters are allowed'
                                  }, stringLength: {
                                      min: 3,
                                      max: 150,
                                      message: 'The Bank Name No must be 3-150 characters long'
                                  }
                              }
                          }, BranchName: {
                              message: 'No spacial characters are allowed',
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9\s]+$/,
                                      message: 'No spacial characters are allowed'
                                  }, stringLength: {
                                      min: 3,
                                      max: 150,
                                      message: 'The Branch Name No must be 3-150 characters long'
                                  }
                              }
                          }, ChequeRemarks: {
                              message: 'No spacial characters are allowed',
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9\s]+$/,
                                      message: 'No spacial characters are allowed'
                                  }, stringLength: {
                                      min: 5,
                                      max: 150,
                                      message: 'The remarks can be 5-150 characters long'
                                  }
                              }
                          }, ChNumber: {
                              message: 'Only Numberic values are allowed',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9]+$/,
                                      message: 'Only Numberic values are allowed'
                                  }, stringLength: {
                                      min: 5,
                                      max: 5,
                                      message: 'The Cheuqe No must be 5 characters long'
                                  }
                              }
                          }, ChAmount: {
                              message: 'Only Numberic values are allowed',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9]+$/,
                                      message: 'Only Numberic values are allowed'
                                  }
                              }, between: {
                                      min: 0,
                                      max: <?php echo MAX_FEE_AMT; ?>,
                                      message: 'Not Allowed More then <?php echo MAX_FEE_AMT; ?> Amount'
                                  }
                          }


                      }

                  });
              });

//submitting the data via ajax of searching form 

//    $("#search_student").click(function()
//    {
//
//        var formData = {
//            'EnrollNo': $('input[name=Search_EnrollNo]').val(),
//            'Searching_option': $('input[name=Searching_option]:checked').val(),
//            'Stu_Name': $('input[name=Name]').val(),
//            'Father_Name': $('input[name=FatherName]').val(),
//            'Batch_Code': $('input[name=BatchCode]').val(),
//            'Faculty_Code': $('input[name=FacultyCode]').val(),
//            'between_dates': $('input[name=between_dates]').val(),
//        };
//        // validation to prevent fee record searching errors  
//        if (formData['Searching_option'] === "EnrollNo" || formData['Searching_option'] === "Receipt_Number")
//        {
//            if (formData['EnrollNo'] === "") {
//                   swal({   
//                       title: "Wrong Entry!",
//                       type: "warning",
//                       text: "Please Fill The " + formData['Searching_option'] + " properly !! And Try Again !!",
//                       timer: 5000 });
//                //alert('Please Fill The ' + formData['Searching_option'] + " properly !! And Try Again !!");
//                return false;
//            }
//        } else if (formData['Searching_option'] === "Advance_Search") {
//            if (formData['Stu_Name'] === "" && formData['Father_Name'] === "" && formData['Batch_Code'] === "" && formData['Faculty_Code'] === "") {
//                 swal({
//                     title: "Wrong Entry!",
//                     type: "warning",
//                     text: "Minimum one Field is required",
//                     timer: 5000 });
//                return false;
//            }
//        }
//
////        var xhr = $.ajaxSettings.xhr(); // call the original function
////        xhr.addEventListener('progress', function (e) {
////            if (e.lengthComputable) {
////                var percentComplete = e.loaded / e.total;
////                // Do something with download progress
////            }
////        }, false);
//
//
//
//
//
//        //alert(formData['Searching_option']);
//        var page = "<?= base_url() ?>Ajax/Search_Student";
//        $("#Searching_Result").removeClass('hidden');
//        $("#progress_bar").removeClass('hidden');
//        $.ajax({
//            type: "POST",
//            url: page,
//            data: formData,
//            success: function(result) {
//                $("#Searching_Result").html(result);
//            }});
//
//    });

//fee handling


              function check_blank_field() {
                  // maint_charge,late_payment,std_charge,exam_fee,p_cost,other,total_amount
                  if ($("#reg_fee").val() === "") {
                      $("#reg_fee").val(0);
                  }
                  if ($("#maint_charge").val() === "") {
                      $("#maint_charge").val(0);
                  }
                  if ($("#other").val() === "") {
                      $("#other").val(0);
                  }
                  if ($("#late_payment").val() === "") {
                      $("#late_payment").val(0);
                  }
                  if ($("#std_charge").val() === "") {
                      $("#std_charge").val(0);
                  }
                  if ($("#PreBalAmt").val() === "") {
                      $("#PreBalAmt").val(0);
                  }
                  if ($("#balance_amt").val() === "") {
                      $("#balance_amt").val(0);
                  }

                  if ($("#p_cost").val() === "") {
                      $("#p_cost").val(0);
                  }
                  if ($("#discount").val() === "") {
                      $("#discount").val(0);
                  }
                  if ($("#paid_amt").val() === "") {
                      $("#paid_amt").val(0);
                  }
                  if ($("#net_payable").val() === "") {
                      $("#net_payable").val(0);
                  }

              }


              $("#reg_fee").keyup(function () {
                  // maint_charge,late_payment,std_charge,exam_fee,p_cost,other,total_amount
                  total_amount();
              });
              $("#maint_charge").keyup(function () {
                  // maint_charge,late_payment,std_charge,exam_fee,p_cost,other,total_amount
                  total_amount();
              });
              $("#late_payment").keyup(function () {
                  // maint_charge,late_payment,std_charge,exam_fee,p_cost,other,total_amount
                  total_amount();
              });
              $("#std_charge").keyup(function () {
                  // maint_charge,late_payment,std_charge,exam_fee,p_cost,other,total_amount
                  total_amount();
              });
              $("#PreBalAmt").keyup(function () {
                  // maint_charge,late_payment,std_charge,exam_fee,p_cost,other,total_amount
                  total_amount();
              });
              $("#p_cost").keyup(function () {
                  // maint_charge,late_payment,std_charge,exam_fee,p_cost,other,total_amount
                  total_amount();
              });
              $("#other").keyup(function () {
                  // maint_charge,late_payment,std_charge,exam_fee,p_cost,other,total_amount
                  total_amount();
              });
// discount,net_payable,paid,fee_type18(balance)
              $("#discount").keyup(function () {
                  discount();
              });
//    $("#paid").keyup(function() {
//        discount();
//    });
              // check amount
              function change_check_amount() {
                  var chkamount = parseFloat($("#ChAmount").val());
                  //alert(chkamount);
                  $("#paid").val(chkamount);
                  check_valid_pay();
              }

              // check valid pay to check paid amount should be less than total amount
              function check_valid_pay() {
                  if (parseInt($("#paid").val()) < 0 || $("#paid").val() == "")
                      $("#paid").val(0);
                  if (parseInt($("#fee_type18").val()) < 0)
                      $("#paid").val(0);
                  if (parseInt($("#net_payable").val()) < parseInt($("#paid").val())) {
                      swal({
                          title: "Wrong Entry",
                          type: "warning",
                          text: "Paid Amount Can\'t be more than net payable !!",
                          timer: 5000});
                      $("#paid").val($("#net_payable").val());
                      $("#ChAmount").val($("#net_payable").val());
                  }

                  net_payable_fee();
              }
              $("#paid").keyup(function () {
                  check_valid_pay();
              });
              // scrolling to see the fee structure
//    $("#all_fee_record").click(function(){
//    $("body").animate({ scrollTop: 1500 }, 600);
//    });

//    $("#FeeType_Code").change(function() {
//        
//        var FeeType = $("#FeeType_Code option:selected").val();
//        if (FeeType === "Bal") {
//            // alert(FeeType);
//            $("#temp_monthly_fee").val(parseInt($("#maint_charge").val()));
//            $("#maint_charge").val(0);
//            //$("#other").val(parseInt($("#pre_bal").val()));
//            $("#temp_reg_fee").val(parseInt($("#reg_fee").val()));
//            $("#reg_fee").val(0);
//            //$("#temp_late_payment").val(parseInt($("#late_payment").val()));
//            $("#late_payment").val(0);
//            $("#temp_std_charge").val(parseInt($("#std_charge").val()));
//            $("#std_charge").val(0);
//            $("#temp_exam_fee").val(parseInt($("#exam_fee").val()));
//            $("#exam_fee").val(0);
//            $("#temp_p_cost").val(parseInt($("#p_cost").val()));
//            $("#p_cost").val(0);
//           // Get_Late_Payment();
//            total_amount();
//            //$("#paid").val(parseInt($("#pre_bal").val()));
//        } else {
//            $("#maint_charge").val(parseInt($("#temp_monthly_fee").val()));
//            //$("#other").val(0);
//            Get_Late_Payment();
//            total_amount();
//        }
//    });


</script>
