 <?php

$text_Page_width = 195;
$defaultX = 12;
$copy = array("Students Copy", "Head Office Copy");
$Greating_Message = "Thanks For Submitting Your Fees For";
require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$title = "Fee Receipt";
for ($page = 0; $page < 2; $page++) {
    $pdf->SetXY($pdf->GetX(), $pdf->GetY()-3);
    $pdf->border(0, 0, 0);
// Page header
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(190, 0, $copy[$page], 0, 0, 'R');
    $pdf->SetFont('Arial', 'B', 12);
    // Insert a logo in the top-left corner at 300 dpi
    //  $pdf->Image(LOGO,10,10,-300);
    // Insert a dynamic image from a URL
    $pdf->Image(base_url() . LOGO, 30, $pdf->GetY()-3, 40, 0, 'PNG');
    $w = $pdf->GetStringWidth($title) + 6;
    $pdf->SetX((210 - $w) / 2 + 18);
    $pdf->SetDrawColor(255, 255, 255);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetLineWidth(1); // line width
    $pdf->Cell($w, 3, $title, 1, 1, 'C', true);
    $pdf->SetLineWidth(.3);
    $pdf->SetDrawColor(0, 0, 0);
    //$pdf->Line($w+56,18,$w+$w+61,18);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetY($pdf->GetY() - 3);
    $pdf->SetX((190 - $w) / 2 + 13);
    $pdf->Cell($w, 10, $fee_record->Address1);
    $pdf->SetY($pdf->GetY() + 3);
    $pdf->SetX((195 - $w) / 2 + 20);
    $pdf->Cell($w, 10, 'Website: '.$fee_record->Website);
    $pdf->SetY($pdf->GetY() + 4);
    $pdf->SetX((200 - $w) / 2 + 18);
    $pdf->SetTextColor(196, 100, 46);
    $pdf->Cell($w - 5, 10, 'E-mail:'.$fee_record->Email);
    $pdf->SetDrawColor(196, 100, 46);
    // $pdf->Line($w+56,$pdf->GetY()+8,$w+$w+75,$pdf->GetY()+8);//x1,y1, x2,y2 
    $pdf->SetLineWidth(.1);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetY($pdf->GetY() + 8);
    $pdf->Line(12, $pdf->GetY(), 195, $pdf->GetY());  //top 
    $pdf->SetLineWidth(1);
    $pdf->SetY($pdf->GetY() + 1.5);
    $pdf->Line(12, $pdf->GetY(), 195, $pdf->GetY());  //top 


    /* end of starting */

    $pdf->SetFont('Arial', 'B', 8);
    $Greating_Message_width = $pdf->GetStringWidth($Greating_Message);
    $pdf->SetY($pdf->GetY()-6);
    $pdf->SetFont('Arial', 'B', 8);
//$pdf->Cell(15);
    if($page==1){
     $pdf->Cell(15, $pdf->GetY()-140, $Greating_Message);   
    }else
    {$pdf->Cell(15, $pdf->GetY(), $Greating_Message);}
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetY($pdf->GetY() + 12);
    $pdf->SetXY(10, $pdf->GetY());
    //$pdf->SetTextColor(0, 179, 239);
//$pdf->Cell(180,5,"Fees Details: ",0,1,'L');
    $pdf->SetLineWidth(.1);
    $pdf->Line(11, $pdf->GetY(), 195, $pdf->GetY());  //top 
    $pdf->Ln(2);
    $pdf->SetTextColor(0, 0, 0);
//1
    $pdf->Cell(20, 3, "Fee Type", 0, 0, 'L');
    $pdf->Cell(35, 3, ": " . $fee_record->FeeType_Code, 0, 0, 'L');
    $pdf->Cell(18, 3, "Month", 0, 0, 'L');
    $pdf->Cell(20, 3, ": " . $fee_record->Month, 0, 0, 'L');
    $pdf->Cell(17, 3, "Receipt No", 0, 0, 'L');
    $pdf->Cell(36, 3, " :  " . $fee_record->ID, 0, 0, 'L');
    $pdf->Cell(20, 3, "Receipt Date", 0, 0, 'L');
    $pdf->Cell(30, 3, ": " . date(DF, strtotime($fee_record->ReceiptDate)), 0, 1, 'L');




    $pdf->Cell(20, 3, "EnrollNo", 0, 0, 'L');
    $pdf->Cell(35, 3, ": " . $fee_record->EnrollNo, 0, 0, 'L');
    $pdf->Cell(18, 3, "DOR", 0, 0, 'L');
    $pdf->Cell(20, 3, ": " . date(DF, strtotime($fee_record->DOR)), 0, 0, 'L');
    $pdf->Cell(18, 3, "Course", 0, 0, 'L');
    $pdf->Cell(35, 3, ": ".$fee_record->CourseCode, 0, 0, 'L');
    $pdf->Cell(20, 3, "Duration", 0, 0, 'L');
    $pdf->Cell(30, 3, ": " . $fee_record->Duration." ".$fee_record->MonthDay, 0, 1, 'L');


//$pdf->Cell(67,3,"Mobile          :  ".$fee_record->Mobile1,0,1,'L');
//2
    $pdf->Cell(20, 3, "Name", 0, 0, 'L');
    $pdf->Cell(35, 3, ": " . substr($fee_record->StudentName, 0, 15), 0, 0, 'L');
    $pdf->Cell(18, 3, "Faculty Code", 0, 0, 'L');
    $pdf->Cell(20, 3, ": " . $fee_record->FacultyCode, 0, 0, 'L');
    $pdf->Cell(18, 3, "Batch Code", 0, 0, 'L');
    $pdf->Cell(35, 3, ": " . $fee_record->BatchCode, 0, 0, 'L');
    $pdf->Cell(20, 3, "Batch Timing", 0, 0, 'L');
    $pdf->Cell(35, 3, ": " . date('h:i',  strtotime($fee_record->Start_Time))." to ".date('h:i a',  strtotime($fee_record->End_Time)), 0, 1, 'L');

//3
    $pdf->Cell(20, 3, "Father's Name", 0, 0, 'L');
    $pdf->Cell(35, 3, ": " . substr($fee_record->FatherName, 0, 15), 0, 0, 'L');
    $pdf->MultiCell(125, 3, "Address         :".$fee_record->C_village_and_post." ".($fee_record->C_city!=""?", ".$fee_record->C_city:'')." ".($fee_record->C_state!=""?", ".$fee_record->C_state:''), 0, 'L');

    $pdf->Cell(20, 3, "Mobile", 0, 0, 'L');
    $pdf->Cell(35, 3, ": " . $fee_record->Mobile1, 0, 1, 'L');
//$pdf->Cell(20,3,"Current Topic",0,0,'L');
//$pdf->Cell(35,3,": "."+91-9211433695,+91-7835851114",0,1,'L');
//$pdf->MultiCell(180,3,"Address       :".$fee_record->C_houseno." ".$fee_record->C_street." ".
//$fee_record->C_locality." ".$fee_record->C_sub_locality." ".$fee_record->C_city." ".$fee_record->C_village_and_post,0,'L');
    $mob = "Mobile1";
    $pdf->Ln(2);

// row 
    $field = array(
        "Reg Fee Amt" => "RegFeeAmt",
        "Monthly Charge" => "MonthlyChargeAmt",
        "Late Payment Charge" => "LatePaymentAmt",
        "Study Material Cost" => "StudyMaterialCostAmt",
        "Exam Fees" => "ExamFeeAmt",
        "Prospectus Cost" => "ProspectusCostAmt",
        "Others" => "OtherAmt");
    $pdf->Cell(10, 5, "S.No", 1, 0, 'L');
    $pdf->Cell(50, 5, "Particulars    ", 1, 0, 'L');
    $pdf->Cell(30, 5, "Cash Details          ", 1, 1, 'L');
    $i = 1;
    foreach ($field as $key => $value) {
        $pdf->Cell(10, 5, $i++, 1, 0, 'L');
        $pdf->Cell(50, 5, $key, 1, 0, 'L');
        $pdf->Cell(30, 5, $fee_record->$value, 1, 1, 'L');
    }
    $next_fields = array(
        "Current Total Amount" => "TotalAmt",
        "Discount(If Any)" => "DisAmt",
        "NetPayable Amount" => "NetPayableAmt",
        "Paid Amount" => "PaidAmt",
        "Balance" => "BalanceAmt"
    );
    foreach ($next_fields as $key => $value) {
        $pdf->Cell(60, 5, $key, 1, 0, 'R');
        $pdf->Cell(30, 5, $fee_record->$value, 1, 1, 'L');
    }
    $next_fields = array(
        "Next Inst." => $fee_record->NextInstAmt,
        "Next Due Date" => $fee_record->NextDueDate != NULL ? date(DF, strtotime($fee_record->NextDueDate)) : "",
        "After Next Inst." => $fee_record->AfterNextInstAmt,
        "After Next Due Date" => $fee_record->AfterNextDueDate != NULL ? date(DF, strtotime($fee_record->AfterNextDueDate)) : "",
        "Total Paid Inst." => $fee_record->NoOfInstallment
    );

    $pdf->SetXY(110, $pdf->GetY() - 65);
    $pdf->Cell(80, 5, "Other Details", 1, 1, 'L');
    foreach ($next_fields as $key => $value) {
        $pdf->SetX(110);
        $pdf->Cell(50, 5, $key, 1, 0, 'L');
        $pdf->Cell(30, 5, $value, 1, 1, 'L');
    }
    $pdf->SetX(110);
    $pdf->Cell(80, 5, "Amount in words", 1, 1, 'L');
    $pdf->SetX(110);
    $pdf->MultiCell(80, 5, $amount_in_words, 1, 1, 'L');


    $pdf->SetX(110);
    $pdf->Cell(40, 20, "Student Sign", 0, 0, 'C');
    $pdf->Cell(40, 20, "PRO", 0, 1, 'C');
    $pdf->SetX(110);
    $pdf->Cell(40, -7, "(" . $fee_record->StudentName . ")", 0, 0, 'C');
    $pdf->Cell(40, -7, "(".$Session_Data['AIITC_SMS_USER'].")", 0, 1, 'C');

    $pdf->SetX(110);
    $pdf->Cell(40, 15, "Date:____/____/_______", 0, 0, 'C');
    $pdf->Cell(90, 15, "Date:____/____/_______", 0, 1, 'L');
    $pdf->SetY($pdf->GetY()-2);
    $pdf->MultiCell(180,3,"Important to Note :- ",0,'L');
    $pdf->MultiCell(180,3,"1. After Due Date() Of Every Month, "
            . "You will be liable to pay fine $branch_details->Late_Payment_Fee rs/- per Day.",0,'L');
    $pdf->MultiCell(180,3,"2. Your Registration will be cancelled, If you will be left or absent more than 15 days,then Re-Registration charge is $branch_details->re_reg_charge rs/-",0,'L');
    $pdf->MultiCell(180,3,"3. After Admission or Fee submission, there is no refund in any case.",0,'L');
    $pdf->Image(base_url()."img/hindi_fee_notic.png",10,$pdf->GetY(),0,0,'PNG');
    $pdf->SetFont('Arial','I',6);
	$pdf->SetTextColor(128);
        //if($page==0){
         if($page==0){
        $pdf->SetXY($pdf->GetX(), $pdf->GetY()+12);
       // }
	$pdf->Cell(50,4,'Page '.$pdf->PageNo(),0,0,'L');
        $pdf->Cell(140,4,date(DF." h:i:m a",time()),0,0,'R');
       
        $pdf->SetY($pdf->GetY()+10);
        }else{
             $pdf->SetX(5);
             $pdf->SetY(275);
             $pdf->Cell(50,1,'Page '.$pdf->PageNo(),0,0,'L');
             $pdf->Cell(140,1,date(DF." h:i:m a",time()),0,0,'R');
        }
        
//     
}

$pdf->Output();
?>
