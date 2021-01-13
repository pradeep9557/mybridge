<script>
        /* 
               * To change this license header, choose License Headers in Project Properties.
               * To change this template file, choose Tools | Templates
               * and open the template in the editor.
               */
              //      Form Validation           
              $(document).ready(function () {
                  $('#city_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          citycode: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'City is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z]+$/,
                                      message: 'City can only consist alphabets'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 15,
                                      message: 'City must be more 3-15 characters long'
                                  }
                              }
                          },
                             Sort: {// field name
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9]+$/,
                                      message: 'Sort can only consist alphabets'
                                  },
                                  stringLength: {
                                      min: 0,
                                      max: 99,
                                      message: 'Sort must be more 3-15 characters long'
                                  }
                              }
                          }
                      }

                  });
              });


    </script>