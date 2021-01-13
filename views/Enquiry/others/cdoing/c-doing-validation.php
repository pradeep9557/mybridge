<script>
        /* 
               * To change this license header, choose License Headers in Project Properties.
               * To change this template file, choose Tools | Templates
               * and open the template in the editor.
               */
              //      Form Validation           
              $(document).ready(function () {
                  $('#cdoing_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          Code: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Current doing code is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z_0-9]+$/,
                                      message: 'Current doing code can only consist alphanumeric,space and underscore'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 15,
                                      message: 'Current doing code must be more 3-15 characters long'
                                  }
                              }
                          }, Name: {
                              message: 'Current doing Name is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'Current doing Name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s0-9]+$/,
                                      message: 'Current doing Name can only consist alphanumeric,space and underscore'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 30,
                                      message: 'Current doing Name must be more 3-30 characters long'
                                  }
                              }
                          }, Sort: {
                              message: 'Sorting Value is not valid',
                              validators: {
                                  regexp: {
                                      regexp: /^[0-9]+$/,
                                      message: 'Sorting value should be only numberic'
                                  }
                              }
                          }
                      }

                  });
              });


    </script>