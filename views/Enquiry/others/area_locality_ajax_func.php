<script>
              function load_parents(BranchID, parent)
              {
                  preloader.on();
                  //  alert(result_in);
                  $.ajax({
                      url: "<?= base_url() . "Enquiry/source/showParentList/" ?>" + BranchID + "/" + parent + "/Src_ID",
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {
                          $("#child_src").html('<?= AJAXPRELOADER ?>');
                          $("#child_src").html(data);
                          var config = {
                              '.chosen-select': {},
                              '.chosen-select-deselect': {allow_single_deselect: true},
                              '.chosen-select-no-single': {disable_search_threshold: 10},
                              '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                              '.chosen-select-width': {width: "95%"}
                          };
                          for (var selector in config) {
                              $(selector).chosen(config[selector]);
                          }

                      },
                      complete: function (jqXHR, textStatus) {

                      },
                      error: function (jqXHR, textStatus, errorThrown) {

                      }
                  });
                  preloader.off();
              }
              function load_states(country_id, load_div)
              {
                  preloader.on();
                  //  alert(result_in);
                  $.ajax({
                      url: "<?= base_url() . "Ajax/get_states/" ?>" + country_id + "/C_State",
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {
                          $("#" + load_div).html('<?= AJAXPRELOADER ?>');
                          $("#" + load_div).html(data);
                          var config = {
                              '.chosen-select': {},
                              '.chosen-select-deselect': {allow_single_deselect: true},
                              '.chosen-select-no-single': {disable_search_threshold: 10},
                              '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                              '.chosen-select-width': {width: "95%"}
                          };
                          for (var selector in config) {
                              $(selector).chosen(config[selector]);
                          }

                      },
                      complete: function (jqXHR, textStatus) {

                      },
                      error: function (jqXHR, textStatus, errorThrown) {

                      }
                  });
                  preloader.off();
              }

             


              function load_cities(state_id, load_div)
              {
                            preloader.on();
                  //  alert(result_in);
                  $.ajax({
                      url: "<?= base_url() . "Ajax/get_cities/" ?>" + state_id + '/C_Locality',
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {
                          $("#" + load_div).html('<?= AJAXPRELOADER ?>');
                          $("#" + load_div).html(data);
                          var config = {
                              '.chosen-select': {},
                              '.chosen-select-deselect': {allow_single_deselect: true},
                              '.chosen-select-no-single': {disable_search_threshold: 10},
                              '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                              '.chosen-select-width': {width: "95%"}
                          };
                          for (var selector in config) {
                              $(selector).chosen(config[selector]);
                          }

                      },
                      complete: function (jqXHR, textStatus) {

                      },
                      error: function (jqXHR, textStatus, errorThrown) {

                      }
                  });
                  preloader.off();
              }
              function load_locality(city_id, load_div)
              {
                            preloader.on();
                  //  alert(result_in);
                  $.ajax({
                      url: "<?= base_url() . "Ajax/get_locality/" ?>" + city_id + '/C_City',
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {
                          $("#" + load_div).html('<?= AJAXPRELOADER ?>');
                          $("#" + load_div).html(data);
                          var config = {
                              '.chosen-select': {},
                              '.chosen-select-deselect': {allow_single_deselect: true},
                              '.chosen-select-no-single': {disable_search_threshold: 10},
                              '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                              '.chosen-select-width': {width: "95%"}
                          };
                          for (var selector in config) {
                              $(selector).chosen(config[selector]);
                          }

                      },
                      complete: function (jqXHR, textStatus) {

                      },
                      error: function (jqXHR, textStatus, errorThrown) {

                      }
                  });
                  preloader.off();
              }

              function load_sub_locality(city_id, load_div)
              {
                            preloader.on();
                  //  alert(result_in);
                  $.ajax({
                      url: "<?= base_url() . "Ajax/get_sub_locality/" ?>" + city_id + '/C_SubLocality',
                      type: 'POST',
                      data: 'html',
                      success: function (data, textStatus, jqXHR) {
                          $("#" + load_div).html('<?= AJAXPRELOADER ?>');
                          $("#" + load_div).html(data);
                          var config = {
                              '.chosen-select': {},
                              '.chosen-select-deselect': {allow_single_deselect: true},
                              '.chosen-select-no-single': {disable_search_threshold: 10},
                              '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                              '.chosen-select-width': {width: "95%"}
                          };
                          for (var selector in config) {
                              $(selector).chosen(config[selector]);
                          }

                      },
                      complete: function (jqXHR, textStatus) {

                      },
                      error: function (jqXHR, textStatus, errorThrown) {

                      }
                  });
                  preloader.off();
              }

</script>