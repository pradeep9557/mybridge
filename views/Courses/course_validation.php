<script>
              //      Form Validation           
              $(document).ready(function () {
                  $('#course_validation_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          CourseCode: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Course Code is required and cannot be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9_+.&]+$/,
                                      message: 'It can only consist alphabets and numbers'
                                  }, stringLength: {
                                      min: 1,
                                      max: 15,
                                      message: 'The Course Code must be more 1-15 characters long'
                                  }

                              }
                          }, Course_Name: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Course Name is required and cannot be empty'
                                  }, regexp: {
                                      regexp: /^[a-zA-Z0-9\s_+.&]+$/,
                                      message: 'It can only consist alphabets and numbers'
                                  }
                              }
                          }, Duration: {
                              feedbackIcons: true,
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9]*\.?[0-9]+$/,
                                      message: 'The Duration can only consist numbers'
                                  }, between: {
                                      min: 1,
                                      max: 31,
                                      message: 'Not Allowed More then 40 Students'
                                  }
                              }
                          }, CourseFee: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Course Fees is required'
                                  }, regexp: {
                                      regexp: /^[0-9]*\.?[0-9]+$/,
                                      message: 'The Course Fees can only consist numbers'
                                  }, between: {
                                      min: 0,
                                      max: 1000000,
                                      message: 'Not Allowed More then 1000000'
                                  }
                              }
                          }, New_Category: {
                              feedbackIcons: true,
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9]+$/,
                                      message: 'The New Category can only a-z, A-Z and 0-9'
                                  }, stringLength: {
                                      min: 3,
                                      max: 3,
                                      message: 'The Category Code must be more 3 characters long'
                                  }
                              }
                          }, Remarks: {
                              feedbackIcons: true,
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9\s_,.&]+$/,
                                      message: 'Remarks can only contain a-z, A-Z,ampersand(&),underscore(_),Comma(,),dot(.) and 0-9'
                                  }, stringLength: {
                                      min: 5,
                                      max: 150,
                                      message: 'The Remarks Code must be more 5-150 characters long'
                                  }
                              }
                          }
                      }
                  });
              });

</script>