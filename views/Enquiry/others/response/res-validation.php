 <script>
           // validation of   response_form 
            $(document).ready(function () {
                  $('#response_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          ResponseText: {
                              message: 'Enquirer Name is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'Response Text is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9\s]+$/,
                                      message: 'Response Text can only consist numbers and alphabets'
                                  },stringLength: {
                                      min: 10,
                                      max: 50,
                                      message: 'Response Text Should be 10 to 50 characters long'
                                  }
                              }
                          },
                            Sort: {
                              message: 'Sorting value is not valid',
                              validators: {
                                 regexp: {
                                      regexp: /^[0-9]+$/,
                                      message: 'Sort  can only consist numbers'
                                  },stringLength: {
                                      min: 0,
                                      max: 99,
                                      message: 'SortShould be 0 to 99'
                                  }
                              }
                          }
                      }

                  });
              });

        </script>