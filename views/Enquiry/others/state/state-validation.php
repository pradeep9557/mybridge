 <script>
           // validation of   response_form 
            $(document).ready(function () {
                  $('#state_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          code: {
                              message: 'State code is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'State code is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9.]+$/,
                                      message: 'State code can only consist numbers and alphabets'
                                  },stringLength: {
                                      min: 2,
                                      max: 32,
                                      message: 'State code Should be 3 to 32 characters long'
                                  }
                              }
                          },name: {
                              message: 'State name is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'State name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9.\s&]+$/,
                                      message: 'State name can only consist numbers and alphabets'
                                  },stringLength: {
                                      min: 3,
                                      max: 128,
                                      message: 'State name Should be 3 to 128 characters long'
                                  }
                              }
                          }
                      }

                  });
              });

        </script>