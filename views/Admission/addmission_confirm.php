<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Confirm Your Admission Details</h4>
            <h6 id="succ_msg">
                <button type="button" class="btn btn-success btn-md"><?= SUCCESS_MSG ?> Please Confirm Your details !!

                    <span class="glyphicon glyphicon-remove"></span> 

                </button></h6>

            <?php
            ?>

        </div>

        <!-- /.col-lg-12 -->

    </div>

    <?php
    //for normal form

    echo form_open(base_url() . 'admission/all_admission_form/0/1', $attributes);

    //echo form_open_multipart('/dashboard/admission_save_update',$attributes);
    ?>

    <!--String of Row-->

    <div class="row bottom_gap">

        <div class="col-lg-2">Enrollment Number</div>

        <div class="col-lg-4">
            <?php echo $admission_data->EnrollNo; ?>
            <?php echo form_hidden("Stu_ID", "$admission_data->Stu_ID"); ?>
        </div> <!-- end of col-lg-4 -->

        <div class="col-lg-2">Student Name</div>

        <div class="col-lg-4">

            <?php echo $admission_data->StudentName; ?>

        </div>

    </div> <!--End of row-->

    <!--String of Row-->

    <div class="row bottom_gap">
        <div class="col-lg-2">Date of Reg.(DOR)</div>
        <div class="col-lg-4">
            <?php
            if ($admission_data->DOR == "") {
                echo "Not Mentioned";
            } else {
                echo date(DF, strtotime($admission_data->DOR));
            }
            ?>    
        </div>
        <div class="col-lg-2">Selected Course</div>
        <div class="col-lg-4"><?php
            foreach ($all_stu_scnb_details as $scnb) {
                echo $scnb->CourseCode;
            }
            ?></div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-12"><h5 class="group_title">Personal Details</h5></div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">Father's Name</div>
        <div class="col-lg-4">
            <?php echo $admission_data->FatherName; ?>          
        </div>
        <div class="col-lg-2">Mother's Name</div>
        <div class="col-lg-4">
            <?php echo $admission_data->MotherName; ?>                         
        </div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">Date of Birth</div>
        <div class="col-lg-4">
            <div class="input-group">

                <?php
                if ($admission_data->DOB == "") {
                    echo "Not Mentioned";
                } else {
                    echo date(DF, strtotime($admission_data->DOB));
                }
                ?>         
            </div>

        </div>

        <div class="col-lg-2">Gender</div>

        <div class="col-lg-4">

            <?php echo $admission_data->Gender; ?>       

        </div>

    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">qualification</div>

        <div class="col-lg-4">

            <?php echo $admission_data->Quali; ?>       



        </div>

        <div class="col-lg-2">Nationality</div>

        <div class="col-lg-4">

            <?php echo $admission_data->Nationality; ?>       

        </div>



    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">Image</div>

        <div class="col-lg-4">



            <?php
            if (file_exists(STU_UPLOAD_PATH . $admission_data->Pro_pic)) {
                echo "<img src='" . base_url() . STU_UPLOAD_PATH . $admission_data->Pro_pic . "' width='75px'/>";
            } else {
                echo "<img src='" . base_url() . DEFAULT_STU_PIC . "' width='75px'/>";
            }
            ?>
        </div>
        <div class="col-lg-2">Signature</div>
        <div class="col-lg-4">
            <?php
            if (file_exists(STU_UPLOAD_PATH . $admission_data->Sign)) {
                echo "<img src='" . base_url() . STU_UPLOAD_PATH . $admission_data->Sign . "' width='75px'/>";
            } else {
                echo "<img src='" . base_url() . DEFAULT_STU_SIGN . "' width='75px'/>";
            }
            ?>          
        </div>                
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-12"><h5 class="group_title">Contact Details</h5></div>
    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">Primary Mobile No</div>

        <div class="col-lg-4">

            <?php echo $admission_data->Mobile1; ?>       

        </div>
        <div class="col-lg-2">Primary Phone No</div>
        <div class="col-lg-4">

            <?php echo $admission_data->Phone1; ?>          
        </div>

    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">Primary Email ID</div>

        <div class="col-lg-4">
            <?php echo $admission_data->Email1; ?>     
        </div>



    </div>

    <div class="row bottom_gap">

        <div class="col-lg-12"><h5 class="group_title">Address Details</h5></div>

    </div>


    <div class="row bottom_gap">

        <div class="col-lg-2">House No.</div>

        <div class="col-lg-4">
            <?php echo $admission_data->C_houseno; ?>    
        </div>

        <div class="col-lg-2">Street</div>

        <div class="col-lg-4">
            <?php echo $admission_data->C_street; ?>    
        </div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">City</div>
        <div class="col-lg-4">
            <?php echo $admission_data->C_city; ?>    
        </div>
        <div class="col-lg-2">State</div>
        <div class="col-lg-4">
            <?php echo $admission_data->C_state; ?>    
        </div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">village and post</div>
        <div class="col-lg-4">
            <?php echo $admission_data->C_village_and_post; ?>    
        </div>
        <div class="col-lg-2">Pin</div>

        <div class="col-lg-4">
            <?php echo $admission_data->C_pincode; ?>    
        </div>
    </div>
    <div class="row bottom_gap">

        <div class="col-lg-12"><h5 class="group_title">Office Work</h5></div>

    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2">PRO</div>

        <div class="col-lg-4"><?php echo $admission_data->Add_User; ?></div>
        <div class="col-lg-2">Remarks</div>
        <div class="col-lg-4"><?php echo $admission_data->Remarks; ?></div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2">Password</div>
        <div class="col-lg-4"><?php echo $pass; ?></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button type="submit" name="admission_submit" value="Confirm" class="btn btn-success btn-md">
                <span class="glyphicon glyphicon-saved"></span> Confirm
            </button>
            <button type="button" name="admission_submit" value="Edit" class="btn btn-success btn-md" onclick="open_page('<?= base_url() ?>admission/admission_edit/0/0/<?= $admission_data->EnrollNo ?>', '')">
                <span class="glyphicon glyphicon-edit"></span> Edit
            </button>
            <a href="<?= base_url() . "admission/print_admission/" . $admission_data->EnrollNo ?>" target="_blank"><button type="Button" name="Print" value="Print" class="btn btn-primary btn-md">
                    <span class="glyphicon glyphicon-print"></span> Print
                </button>
            </a>
            <a href="<?= base_url() ?>Fee_Master/Fee_collect_form/0/0/<?= $admission_data->EnrollNo ?>/<?= $this->util_model->url_encode($scnb->CourseCode) ?>">
                <button class="btn-md btn btn-info" title="Fee Collect For <?= $admission_data->EnrollNo ?>" type="button"><span class="glyphicon glyphicon-send"></span> Fee Collect</button>
            </a>
        </div>
    </div>
    <?php echo form_close(); ?>       

</div>
