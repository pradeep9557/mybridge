<script>
              //      Form Validation           
              $(document).ready(function () {
                  $('#Fee_Type_validation_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          FeeType_Code: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Fee Type Code is required and cannot be empty'
                                  }, regexp: {
                                      regexp: /^[a-zA-Z]+$/,
                                      message: 'The Fee Type Code can only consist Alphabates, No special character allowed'
                                  }
                              }
                          }, FeeType_Name: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Fee Type Name is required and cannot be empty'
                                  }, regexp: {
                                      regexp: /^[a-zA-Z ]+$/,
                                      message: 'The Fee Type Name can only consist Alphabates, No special character allowed'
                                  }
                              }
                          }, Late_Payment_Fee: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Late Payment is required and cannot be empty.'
                                  }, regexp: {
                                      regexp: /^[0.0-9.0]+$/,
                                      message: 'The Fee Type Name can only consist Numberic value.'
                                  }
                              }
                          }, Fine_Day_Limit: {
                              feedbackIcons: true,
                              validators: {
                                  notEmpty: {
                                      message: 'Fine Day Limit is required and cannot be empty.'
                                  }, regexp: {
                                      regexp: /^[0.0-9.0]+$/,
                                      message: 'The Fee Type Name can only consist Numberic value.'
                                  }
                              }
                          }
                      }
                  });
              });

</script>