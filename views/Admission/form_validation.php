<script>
              /* 
               * To change this license header, choose License Headers in Project Properties.
               * To change this template file, choose Tools | Templates
               * and open the template in the editor.
               */
              //      Form Validation           
              $(document).ready(function () {
                  $('#adm_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          StudentName: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Student Name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Student Name can only consist alphabets'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 25,
                                      message: 'Student Name must be more 3 characters long'
                                  }
                              }
                          }, FatherName: {
                              message: 'Father Name is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'Father Name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Father Name can only consist alphabets'
                                  }
                              }
                          }, MotherName: {
                              message: 'Mother Name is not valid',
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Mother Name can only consist alphabets'
                                  }
                              }
                          }, Email1: {
                              validators: {
                                  emailAddress: {
                                      message: 'Invalid Email address'
                                  }
                              }
                          }, Email2: {
                              validators: {
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
                          }, Phone1: {
                              validators: {
//                         notEmpty: {
//                            message: 'Phone is required and can\'t be empty'
//                        },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^[0-9\,]+$/,
                                      message: 'Invalid Phone number'
                                  }
                              }
                          }, C_city: {
                              validators: {
                                  notEmpty: {
                                      message: 'City is required and can\'t be empty'
                                  }
                              }
                          }, C_state: {
                              validators: {
                                  notEmpty: {
                                      message: 'State and is required and can\'t be empty'
                                  }, regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Invalid State name'
                                  }
                              }
                          }, Quali: {
                              validators: {
                                  notEmpty: {
                                      message: 'Qualification is required and can\'t be empty'
                                  }
                              }
                          }, Nationality: {
                              validators: {
                                  notEmpty: {
                                      message: 'Nationality is required and can\'t be empty'
                                  }
                              }
                          }, C_village_and_post: {
                              validators: {
                                  notEmpty: {
                                      message: 'Village and Post is required and can\'t be empty'
                                  }
                              }
                          },
                          DOB: {
                              validators: {
                                  notEmpty: {
                                      message: 'Date is required and can\'t be empty'
                                  },
                                  date: {
                                      format: 'DD-MM-YYYY'
                                  }
                              }
                          }, C_pincode: {
                              validators: {
                                  notEmpty: {
                                      message: 'Pincode is required and can\'t be empty'
                                  },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^(\d{6})+$/,
                                      message: 'Invalid PinCode'
                                  }
                              }
                          }, P_pincode: {
                              validators: {
//                         notEmpty: {
//                            message: 'Phone is required and can\'t be empty'
//                        },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^(\d{6})+$/,
                                      message: 'Invalid PinCode'
                                  }
                              }
                          }
                      }

                  });
              });



</script>