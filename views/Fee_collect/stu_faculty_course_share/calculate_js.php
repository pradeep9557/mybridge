<script>
              function copy_dis_into_all(table_id, that) {

                  var c = document.getElementById('dis_chk');
                  var course_fee = 0;
                  var total_dis_amt = $(that).val();
                  var course_per = 0;
                  var dis_amt = 0;
                  if (c.checked) {

                      var total_fees = parseInt($(".total_fees").val());
                              $('#' + table_id + ' > tbody  > tr').each(function () {
                          course_fee = $(this).children(".course_fee_col").children(".actual_fee").val();
                          course_per = course_fee / total_fees * 100;
                          dis_amt = course_per * total_dis_amt / 100;
                          $(this).children(".dis_col").children(".course_discount").val(dis_amt.toFixed(2));

                      }); 
                  }

              }

              function amount_validation(g_val, s_val, that) {
                  if (g_val < s_val) {
                      sweetAlert("Oops...", "Discount Amount cannot be greater than Total amount !!", "error");
                      $(that).val(0);
                  }

                  discount_cal(that);
                  cal_total("faculty_share_tb");

              }
              /*
               * cal_total(tbl_id)
               * @param {string} id of table
               * @returns null
               */
              function cal_total(table_id) {
                  var total_dis = 0;
                  $('#' + table_id + ' > tbody  > tr').each(function () {
                      total_dis += parseInt($(this).children(".dis_col").children(".course_discount").val());
                  });
                  $(".total_dis_amt").val(total_dis);

                  var final_total_fee = 0;
                  $(".total_dis_fee").val(parseInt($(".total_fees").val()) - parseInt($(".total_dis_amt").val()));
              }

              /* funciton discount_cal 
               * wehn a user will enter discount amount it will reflect the net payable amount
               * */

              function discount_cal(that) {
                  //alert($(that).val());
                  var dis_amount = parseInt($(that).parent().siblings(".course_fee_col").children(".actual_fee").val()) - parseInt($(that).val());
                  //alert($(that).parent().siblings(".course_fee_col").children(".actual_fee").val());
                  $(that).parent().siblings(".dis_fee_col").children(".dis_fee").val(dis_amount.toString());
              }

</script>