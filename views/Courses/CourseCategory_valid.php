<script>
              //      Form Validation           
              $(document).ready(function () {
                  $('#CourseCategory_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          C_CatCode: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Course Code is required and cannot be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9_+&]+$/,
                                      message: 'It can only consist alphabets and numbers'
                                  }

                              }
                          }, C_CatName: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Course Category  Name is required and cannot be empty'
                                  }, regexp: {
                                      regexp: /^[a-zA-Z0-9\s_+&]+$/,
                                      message: 'It can only consist alphabets and numbers'
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