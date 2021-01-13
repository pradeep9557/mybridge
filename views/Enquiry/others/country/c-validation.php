<script>
        /* 
               * To change this license header, choose License Headers in Project Properties.
               * To change this template file, choose Tools | Templates
               * and open the template in the editor.
               */
              //      Form Validation           
              $(document).ready(function () {
                  $('#country_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          name: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Country is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z]+$/,
                                      message: 'Country can only consist alphabets'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 15,
                                      message: 'Country must be more 3-15 characters long'
                                  }
                              }
                          }
                      }

                  });
              });


    </script>