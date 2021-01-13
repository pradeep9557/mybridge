<script src="<?= base_url() ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script>
                  /* 
                   * To change this license header, choose License Headers in Project Properties.
                   * To change this template file, choose Tools | Templates
                   * and open the template in the editor.
                   * @auther Anup kumar
                   * @Date of Creation : 11 march 2015
                   * @purpose : validation of add Employee
                   */


                  //      Form Validation           
                  $(document).ready(function () {
                      $('#validation_form').bootstrapValidator({
                          feedbackIcons: {
                              valid: 'glyphicon glyphicon-ok',
                              invalid: 'glyphicon glyphicon-remove',
                              validating: 'glyphicon glyphicon-refresh'
                          },
                          fields: {
                              Emp_Code: {// field name
                                  validators: {
                                      notEmpty: {
                                          message: 'Emp Code is required and can\'t be empty'
                                      },
                                      regexp: {
                                          regexp: /^[a-zA-Z0-9]+$/,
                                          message: 'Emp Code can only consist alphabets and numberic value'
                                      },
                                      stringLength: {
                                          min: 3,
                                          max: 10,
                                          message: 'Emp Code must be more 3-10 characters long'
                                      }
                                  }
                              }, Emp_Name: {
                                  message: 'Employee Name is not valid',
                                  validators: {
                                      notEmpty: {
                                          message: 'Employee Name is required and can\'t be empty'
                                      },
                                      regexp: {
                                          regexp: /^[a-zA-Z\s]+$/,
                                          message: 'Employee Name can only consist alphabets'
                                      }
                                  }
                              }, UserName: {
                                  message: 'User Name is not valid',
                                  validators: {
                                      notEmpty: {
                                          message: 'User Name is required and can\'t be empty'
                                      },
                                      regexp: {
                                          regexp: /^[a-zA-Z0-9]+$/,
                                          message: 'User Name can only consist alphabets and numberic value'
                                      }
                                  }
                              }, FatherName: {
                                  message: 'Father Name is not valid',
                                  validators: {
                                      regexp: {
                                          regexp: /^[a-zA-Z\s]+$/,
                                          message: 'Father Name can only consist alphabets'
                                      }
                                  }
                              }, MotherName: {
                                  message: 'Mother Name is not valid',
                                  validators: {
                                      regexp: {
                                          regexp: /^[a-zA-Z0-9\s]+$/,
                                          message: 'Mother Name can only consist alphabets'
                                      }
                                  }
                              }, P_Email: {
                                  validators: {notEmpty: {
                                          message: 'Primary Email is required and can\'t be empty'
                                      },
                                      emailAddress: {
                                          message: 'Invalid Email address'
                                      }
                                  }
                              }, Mobile1: {
                                  validators: {
                                      notEmpty: {
                                          message: 'Mobile is required and can\'t be empty'
                                      },
                                      regexp: {
                                          //regexp: /^[a-zA-Z]+$/,
                                          regexp: /^[0-9\,]+$/,
                                          message: 'Invalid Mobile number'
                                      },
                                      stringLength: {
                                          min: 10,
                                          max: 21,
                                          message: 'Mobile no. should be 10 characters long'
                                      }
                                  }
                              }, Password: {
                                  feedbackIcons: false,
                                  validators: {
                                      stringLength: {
                                          min: 6,
                                          max: 15,
                                          message: 'Password should be in between 6 to 15'}
                                  }
                              }, confirmPassword: {
                                  feedbackIcons: false,
                                  validators: {
                                      identical: {
                                          field: 'Password',
                                          message: 'The password and Re-Type Password are not the same'
                                      }
                                  }
                              }, Salary: {
                                  validators: {
//                                                  notEmpty: {
//                                                     message: 'Salary is required and can\'t be empty'
//                                                 },
                                      regexp: {
                                          //regexp: /^[a-zA-Z]+$/,
                                          regexp: /^[0-9]+$/,
                                          message: 'Invalid Salary'
                                      }
                                  }
                              }, Pro_Pic: {// field name
                                  validators: {
                                      file: {
                                          extension: 'jpg,png,gif',
                                          type: 'image/jpeg,image/png,image/gif',
                                          maxSize: 307200, // 300 * 1024
                                          message: 'Only jpg,png, and gif are allowed with max size 300 kb'
                                      }
                                  }
                              }, Sign: {// field name
                                  validators: {
                                      file: {
                                          extension: 'jpg,png,gif',
                                          type: 'image/jpeg,image/png,image/gif',
                                          maxSize: 307200, // 300 * 1024
                                          message: 'Only jpg,png, and gif are allowed with max size 300 kb'
                                      }
                                  }
                              }
                          }

                      });
                  });

    </script>
<script src="<?= base_url() ?>/js/show_password/bootstrap-show-password.js" type="text/javascript"></script>
<script>
                  $('.password_toogle').password();
                  $('#Same_add_check_box').click(function () {
                      var ids = {
                          "C_Add":"P_Add",          
                          "C_localilty": "P_localilty",
                          "C_sub_Locality": "P_sub_Locality",
                          "C_city": "P_city",
                          "C_state": "P_state",
                          "C_pincode": "P_pincode"};
                      $.each(ids, function (sid, did) {
                           copy_text(sid,did);
                      });
                  });


</script>