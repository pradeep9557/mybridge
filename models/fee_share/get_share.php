<?php

class get_share extends CI_Model {

              public function get_share_info($filter_data = array()) {
                            $this->db->select()->from(DB_PREFIX . "");
              }

              public function get_faculty_share($filter_data) {
                            //$this->util_model->printr($filter_data);
                            if (isset($filter_data['FacultyID']) && $filter_data['FacultyID'] != "") {
                                          $this->db->where("ffacc.FacultyID", $filter_data['FacultyID']);
                            }
                            if (isset($filter_data['CourseID'])) {
                                          $this->db->where_in("ffacc.CourseID", $filter_data['CourseID']);
                            }
                            if (isset($filter_data['BranchID'])) {
                                          $this->db->where("stu_mst.BranchID", $filter_data['BranchID']);
                                          $this->db->where("stu_mst.Status", 1);
                            }
                            if (isset($filter_data['orderby'])) {
                                          $order = "ASC";
                                          if (isset($filter_data['order'])) {
                                                        $order = "DESC";
                                          }
                                          $this->db->order_by($filter_data['orderby'], $order);
                            }

                            if (isset($filter_data['Status'])) {
                                          $this->db->where("fee_trn.Status", $filter_data['Status']);
                                          $this->db->where("ffacc.Status", $filter_data['Status']);
                            }

                            if (isset($filter_data['search_via_value'])) {
                                          foreach ($filter_data['search_via_value'] as $index => $search_value) {
                                                        if ($search_value != "") {
                                                                      //return array("succ"=>FALSE,"_err_code"=>"UnSuccDataToSearchEnq");
                                                                      $column_list = array(
                                                                          "Mob1" => "stu_mst.Mobile1",
                                                                          "Name" => "stu_mst.StudentName",
                                                                          "Fname" => "stu_mst.FatherName",
                                                                          "Email1" => "stu_mst.Email1",
                                                                          "EnrollNo" => "stu_mst.EnrollNo",
                                                                          "Stu_ID" => "fee_trn.Stu_ID",
                                                                          "ReceiptNo" => "ffacc.ReceiptNo");
                                                                      $col = isset($column_list[$filter_data['search_via'][$index]]) ? $column_list[$filter_data['search_via'][$index]] : '';
                                                                      // $value = $filter_data['search_via_value1'];
                                                                      if ($col != "") {
                                                                                    $this->db->where($col, $search_value);
                                                                                    $condi_given = TRUE; // it is for getting, yes any one condition is given
                                                                      }
                                                        }
                                          }
                            }

                            if (isset($filter_data['adv_search'])) {
                                          $condi_given = FALSE;
                                          // advance search started !!          
                                          // starting of search date of enquiry or date of registration wise

                                          $from = date(DB_DTF, strtotime($filter_data['From']));
                                          $to = date(DB_DTF, strtotime($filter_data['To']));
                                          if (isset($filter_data['todays_adm'])) {
                                                        // login for todays enquiry, if today checkbox is checked
                                                        $from = date(DB_DTF, strtotime(Year . "-" . Month . "-" . date('d') . "00:00:00"));
                                                        $to = date(DB_DTF, strtotime(Year . "-" . Month . "-" . date('d') . "23:59:59"));
                                          }

                                          $this->db->where("fee_trn.ReceiptDate>=", "'$from'", FALSE);
                                          $this->db->where("fee_trn.ReceiptDate<=", "'$to'", FALSE);
                            }

                            $this->db->select('ffacc.ffaID,'
                                    . 'fee_trn.ReceiptNo,'
                                    . 'fee_trn.ReceiptDate,'
                                    . 'fee_trn.PaidAmt,'
                                    . 'ffacc.FacultyShare,'
                                    . 'ffacc.Weightage,'
                                    . '(((fee_trn.PaidAmt*ffacc.Weightage)/100)*ffacc.FacultyShare/100) share_amount,'
                                    . 'stu_mst.EnrollNo,'
                                    . 'stu_mst.StudentName,'
                                    . 'cm.CourseCode,'
                                    . 'facultyTable.Emp_Code FacultyCode,'
                                    . 'bm.BatchCode,'
                                    . 'stu_mst.Mobile1,'
                                    . 'fee_type.FeeType_Code,'
                                    . 'emp.Emp_Code Add_UserCode')->from(DB_PREFIX . "fee_faculty_account ffacc");

                            //->from(DB_PREFIX . "fee_trn fee_trn");
                            $this->db->join(DB_PREFIX . "fee_trn fee_trn", "ffacc.ReceiptNo = fee_trn.ReceiptNo", "left");
                            $this->db->join(DB_PREFIX . "course_mst cm", "ffacc.CourseID = cm.CourseID", "left");
                            $this->db->join(DB_PREFIX . "stu_batches sb", "ffacc.CourseID = sb.CourseID and ffacc.FacultyID=sb.FacultyID", "left");
                            $this->db->join(DB_PREFIX . "batch_master bm", "sb.BatchID = bm.BatchID", "left");
                            $this->db->join(DB_PREFIX . "fee_type_mst fee_type", "fee_type.FeeTypeID = fee_trn.FeeTypeID", "left");
                            $this->db->join(DB_PREFIX . "stu_mst stu_mst", "stu_mst.Stu_ID = fee_trn.Stu_ID", "left");
                            $this->db->join(DB_PREFIX . "employee emp", "emp.Emp_ID = ffacc.Add_User", "left");
                            $this->db->join(DB_PREFIX . "employee facultyTable", "ffacc.FacultyID=facultyTable.Emp_ID", "left");


                            $query = $this->db->get();
                           
                            $all_result = $query->result_array();
                            return $all_result;
                     }

                           

              }


