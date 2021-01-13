<?php
$text_Page_width = 195;
$defaultX = 12;  
$copy = array("Students Copy","Head Office Copy");
$Greating_Message = "Congratulation !! You have joined AIITC Computer Education Center.";
require('fpdf.php');
$pdf = new FPDF();
for($i=0;$i<2;$i++){
$pdf->AddPage();
$pdf->border(0,0,0);
$pdf->Header("Admission Form",$copy[$i],$branch_details);
$pdf->SetFont('Arial','B',12);
$Greating_Message_width = $pdf->GetStringWidth($Greating_Message);
$pdf->SetY(32);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15);
$pdf->Cell(15,$pdf->GetY(),$Greating_Message);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(10,$pdf->GetY()+20);
$pdf->SetTextColor(0,179,239);
$pdf->Cell(185,5,"Importent Details: ",0,1,'L');
$pdf->SetLineWidth(.1);
$pdf->Line(10,  $pdf->GetY() , 130, $pdf->GetY());  //top 
$pdf->Ln(2);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(50,5,"EnrollNo      :  ".$basic_details->EnrollNo,0,0,'L');
$pdf->Cell(82,5,"Student Name  :  ".substr($basic_details->StudentName,0,15),0,0,'L');
$pdf->Cell(51,5,"Password          :  ".$basic_details->Pass,1,1,'R');


$pdf->Cell(50,5,"DOR             :  ".date(DF,strtotime($basic_details->DOR)),0,0,'L');
$pdf->Cell(82,5,"Course              :  ".$scnb_details->CourseCode,0,0,'L');
$pdf->Cell(51,70,"",1,0);

if(file_exists(STU_UPLOAD_PATH.$basic_details->Pro_pic)){
 $pdf->Image(base_url().STU_UPLOAD_PATH.$basic_details->Pro_pic,$pdf->GetX()-50,$pdf->GetY()+1,50,50,'GIF');
}else{
    $pdf->Image(base_url().DEFAULT_STU_PIC,$pdf->GetX()-50,$pdf->GetY()+1,50,50,'PNG');
}
if(file_exists(STU_UPLOAD_PATH.$basic_details->Sign)){
 $pdf->Image(base_url().STU_UPLOAD_PATH.$basic_details->Sign,$pdf->GetX()-50,$pdf->GetY()+52,50,18,'GIF');
}else{
    $pdf->Image(base_url().DEFAULT_EMP_SIGN,$pdf->GetX()-50,$pdf->GetY()+52,50,18,'GIF');
}

    $pdf->Ln(5);
    $pdf->Cell(50,5,"Due Date      :  ".$scnb_details->Due_Date." Of Every Month(For Fee Submission).",0,1,'L');
    $pdf->Ln(1);
    $pdf->MultiCell(120,5,"Note: After Due Date(".$scnb_details->Due_Date.") of Every Month, "
            . "You will be liable to pay fine $branch_details->Late_Payment_Fee Rs/- per Day.",1,'L');

    $pdf->Ln(5);
    $pdf->SetTextColor(0,179,239);
    $pdf->Cell(120,5,"Personal Details",0,1,'L');
    $pdf->Line(10,  $pdf->GetY() , 130, $pdf->GetY());  //top 
    $pdf->SetTextColor(0,0,0);
    $pdf->Ln(1);
    
    $pdf->Cell(65,5,"Father's Name: ".substr($basic_details->FatherName,0,15),0,0,'L');
    $pdf->Cell(67,5,"Mother's Name: ".substr($basic_details->MotherName,0,15),0,1,'L');
    
    $pdf->Cell(65,5,"Date Of Birth   : ".date(DF,strtotime($basic_details->DOB)),0,0,'L');
    $pdf->Cell(67,5,"Gender             :  ".$basic_details->Gender,0,1,'L');
    $pdf->Ln(5);
    $pdf->SetTextColor(0,179,239);
    $pdf->Cell(120,5,"Contact Details Details",0,1,'L');
    $pdf->Line(10,  $pdf->GetY() , 130, $pdf->GetY());  //top 
    $pdf->SetTextColor(0,0,0);
    $pdf->Ln(1);
    $pdf->Cell(75,5,"Mobile Number:  ".$basic_details->Mobile1,0,0,'L');
    $pdf->Cell(60,5,"Phone   :  ".$basic_details->Phone1,0,1,'L');
    $pdf->Cell(80,5,"Email       :".$basic_details->Email1,0,1);

    $pdf->MultiCell(120,5,"Address: ".$basic_details->C_houseno." ".$basic_details->C_street." ".$basic_details->C_locality." ".$basic_details->C_sub_locality." ".$basic_details->C_city." ".$basic_details->C_village_and_post,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(50,5,"City:  ".$basic_details->C_city,0,0,'L');
    $pdf->Cell(50,5,"State        :  ".$basic_details->C_state,0,0,'L');
    $pdf->Cell(50,5,"Pincode       :".$basic_details->C_pincode,0,1);
    $pdf->Ln(25);
    
    $pdf->Cell(90,5,"PRO Sign(".$basic_details->Add_User.")",0,0,'L');
    $pdf->Cell(90,5,"Head Of Center(___________________________)",0,1,'L');
    $pdf->Cell(90,5,"Date:_____/_____/_____________",0,0,'L');
    $pdf->Cell(90,5,"Date:____/_____/______________",0,1,'L');
    
    $pdf->Ln(5);
    $pdf->SetTextColor(0,179,239);
    $pdf->Cell(120,5,"Importent to Note:",0,1,'L');
    $pdf->Line(10,  $pdf->GetY() , 130, $pdf->GetY());  //top 
    $pdf->SetTextColor(0,0,0);
    $pdf->Ln(1);
    $pdf->MultiCell(180,5,"1. After Due Date(".$scnb_details->Due_Date.") Of Every Month, "
            . "You will be liable to pay fine $branch_details->Late_Payment_Fee rs/- per Day.",0,'L');
    $pdf->MultiCell(180,5,"2. Your Registration will be cancelled, If you will be left or absent more than 15 days, then Re-Registration charge is $branch_details->re_reg_charge rs/-",0,'L');
    $pdf->MultiCell(180,5,"3. After Admission, there is no refund in any case.",0,'L');
    

}
    
    $pdf->Output();
?>
