<script>
//      Form Validation           
              $(document).ready(function () {
                  $('#batch_validation_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          BatchCode: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Batch Code is required'
                                  }, regexp: {
                                      regexp: /^[0-9a-zA-Z_]+$/,
                                      message: 'Wrong Value, only alphanumeric values are required'
                                  }, stringLength: {
                                      min:7,          
                                      max: 25,
                                      message: 'Cannot more than 25 characters'
                                  }
                              }
                          }, Max_Std: {
                              feedbackIcons: true,
                              validators: {
                                   regexp: {
                                      regexp: /^[0-9]+$/,
                                      message: 'Wrong Value, Please Try Again'
                                  }, between: {
                                      min: 0,
                                      max: 150,
                                      message: 'Not Allowed More then 40 Students'
                                  }
                              }
                          }, Total_Class: {
                              feedbackIcons: true,
                              validators: {
                                   regexp: {
                                      regexp: /^[0-9]+$/,
                                      message: 'Wrong Value, Pleae Try Again'
                                  }, between: {
                                      min: 0,
                                      max: 200,
                                      message: 'Total Class Only in between 0 to 200'
                                  }
                              }
                          }, Str_date: {
                              validators: {
                                  notEmpty: {
                                      message: 'The date is required and cannot be empty'
                                  },
                                  date: {
                                      format: 'DD-MM-YYYY'
                                  }
                              }

                          }
                      }
                  });
              });

              //   validation for enrollno wise searching
              $(document).ready(function () {
                  $('#EnrollnoWise_Form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          EnrollNo: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'EnrollNo is required and cannot be empty'
                                  }, regexp: {
                                      regexp: /^[a-zA-Z0-9]+$/,
                                      message: 'Wrong Value, Please Try Again'
                                  }, stringLength: {
                                      min: 11,
                                      max: 11,
                                      message: 'Wrong EnrollNo !!'
                                  }
                              }
                          }
                      }
                  });
              });
              // end for validation for enrollno wise searching
              // for adavnce search validation
              $(document).ready(function () {
                  $('#Adv_Search_Form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          StudentName: {
                              feedbackIcons: true,
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Wrong Value, Please Try Again'
                                  }
                              }
                          }, FatherName: {
                              feedbackIcons: true,
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Wrong Value, Please Try Again'
                                  }
                              }
                          }
                      }
                  });
              });
              // end for advance search validation

// for making batches using value of course category code, faculty code starting time of batch
//  

              $("#course_cat_id").change(function () {
                  generate_and_place_batchcode();
              });
              $("#course_id").change(function () {
                  generate_and_place_batchcode();
              });
              $("#faculty_id").change(function () {
                  generate_and_place_batchcode();
              });
              $("#str_batch_time").blur(function () {
                  generate_and_place_batchcode();
              });
              // batch code will change either changing in above values !!
              function generate_and_place_batchcode(where_to_placeid, course_cat_codeid, faculty_codeid, str_batch_time) {
//                  var POST = {};
//                  where_to_placeid = where_to_placeid || 'BatchCode';
//                  POST['course_cat_codeid'] = course_cat_codeid || 'course_cat_id';
//                  POST['course_id'] = course_cat_codeid || 'course_id';
//                  POST['faculty_codeid'] = faculty_codeid || 'faculty_id';
//                  POST['str_batch_time'] = str_batch_time || 'str_batch_time';
//                  POST['end_batch_time'] = str_batch_time || 'end_batch_time';
//
//
//                  // fetching values from ids
//                  var err = false;
//                  $.each(POST, function (index, value) {
//                      //your code
//                      POST[index] = $("#" + value).val();
//                      if (POST[index] == "") {
//                          err = true;
//                      }
//                  });
//
//                  if (err) {
//                      swal({
//                          title: "Error Occured",
//                          type: "error",
//                          text: "Please check once again, Course Category, Course Code, Faculty ID, Batch timings are complusory",
//                          timer: 5000});
//                  } else {
//
//                      //var time = (am_pm_to_24hour($("#" + str_batch_time).val())).toString();
//                      // var faculty = $("#" + faculty_codeid).val();
//                      //alert(cat+time+faculty);
//                      var page = "<?php echo base_url() . 'batch/batch_master/gen_batchcode' ?>";
//                      $.ajax({
//                          type: "POST",
//                          url: page,
//                          data: POST,
//                          success: function (result) {
//                              //   alert(result);
//                              $("#" + where_to_placeid).val(result);
//                          }});
//
//                      // $("#" + where_to_placeid).val(cat + time + faculty);
//                  }
              }
//              function am_pm_to_24hour(t) {
//                  var no = t.substr(0, t.indexOf(":"));
//                  var am_pm = t.substr(t.indexOf("m") - 1);
//                  if (am_pm === "pm") {
//                      if (no == 12) {
//                          return no;
//                      }
//                      return(12 + eval(no));
//                  }
//                  else {
//                      if (no < 10) {
//                          return "0" + no;
//                      }
//                      return(no);
//                  }
//                  return(no);
//              }
              // Ajax to Search Student Faculty Wise
              $("#FacultyWise_btn").click(function ()
              {
                  var formData = {
                      'FacultyCode': $('#FacultyCode').val(),
                      'BatchCode': $('#BatchCode').val(),
                      'Searching_btn': $('#FacultyWise_btn').val(),
                      'result_id': 'Searching_Result_FacultyWise',
                      'table_id': 'Facultywise_tb'
                  };
                  var page = "<?= base_url() ?>Ajax/Search_Student_For_Batch_Update";
                  $('#Searching_Result_FacultyWise').removeClass('hidden');
                  $('#Searching_Result_FacultyWise').children("#progress_bar").removeClass('hidden');
                  $.ajax({
                      type: "POST",
                      url: page,
                      data: formData,
                      success: function (result) {
                          $("#Searching_Result_FacultyWise").html(result);
                      }});

              });
// EnrollNo 
              $("#EnrollNoWise_btn").click(function ()
              {
                  var formData = {
                      'EnrollNo': $('#EnrollNo').val(),
                      'Searching_btn': $('#EnrollNoWise_btn').val(),
                      'result_id': 'Searching_Result_EnrollnoWise',
                      'table_id': 'EnrollNoWise_tb'
                  };
                  len = $('#EnrollNo').val().length;
                  if (formData['EnrollNo'] === "" || len != 11) {
                      alert('Sorry Please Fill Correct EnrollNo then Try Again !!');
                      return false;
                  }
                  var page = "<?= base_url() ?>Ajax/Search_Student_For_Batch_Update";
                  $('#Searching_Result_EnrollnoWise').removeClass('hidden');
                  $('#Searching_Result_EnrollnoWise').children("#progress_bar").removeClass('hidden');
                  $.ajax({
                      type: "POST",
                      url: page,
                      data: formData,
                      success: function (result) {
                          $("#Searching_Result_EnrollnoWise").html(result);
                      }});

              });
// Advance Search
              $("#Adv_Search_btn").click(function ()
              {
                  var formData = {
                      'StudentName': $('#StudentName').val(),
                      'FatherName': $('#FatherName').val(),
                      'Searching_btn': $('#Adv_Search_btn').val(),
                      'result_id': 'Searching_Result_Adv_Search',
                      'table_id': 'adv_search_tb'
                  };
                  if (formData['StudentName'] === "" && formData['FatherName'] === "") {
                      alert('Sorry Please All the Value !!');
                      return false;
                  }
                  var page = "<?= base_url() ?>Ajax/Search_Student_For_Batch_Update";
                  $('#EnrollNoWise').removeClass('hidden');
                  $('#EnrollNoWise').children("#progress_bar").removeClass('hidden');
                  $.ajax({
                      type: "POST",
                      url: page,
                      data: formData,
                      success: function (result) {
                          $("#Searching_Result_Adv_Search").html(result);
                      }});

              });
              $(".Get_batches").change(function () {
                  var faculty_code = $(this).val();
                  var field_name = $(this).attr('bname');
                  var curr_this = $(this);
                  var page = "<?= base_url() ?>Ajax/Get_Batches_of_Faculty?FacultyID=" + faculty_code + "&name=" + field_name;
                  $.ajax({
                      type: "POST",
                      url: page,
                      //data: "Faculty_Code ="+faculty_code,
                      datatype: "html",
                      success: function (result) {
                          $("#" + $(curr_this).attr('result_id')).html(result);
                          var config = {
                              '.chosen-select': {},
                              '.chosen-select-deselect': {allow_single_deselect: true},
                              '.chosen-select-no-single': {disable_search_threshold: 10},
                              '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                              '.chosen-select-width': {width: "95%"}
                          };
                          for (var selector in config) {
                              $(selector).chosen(config[selector]);
                          }
                      }});
              });

</script>