<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pdf
 *
 * @author User
 */
class pdf {

    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once APPPATH . 'third_party/fpdf/FPDF.php';
        $this->pdf = new FPDF();
    }

    public function print_bill($bill_data) {
        $this->pdf->AddPage();

        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(190, 4, "PH.No : " . $bill_data['company_details']['bill_phone'], 0, 1, 'R');
        $this->pdf->Cell(190, 4, "Email : " . $bill_data['company_details']['bill_email'], 0, 1, 'R');
        $this->pdf->SetFont('Arial', 'B', 15);
        $this->pdf->Cell(190, 8, ucwords($bill_data['company_details']['billing_com_name']), 0, 1, 'L');
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(190, 5, ucwords($bill_data['company_details']['billing_add']), 0, 1, 'L');
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(190, 12, $bill_data['billtype'], 0, 1, 'C');
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(50, 5, "Bill No.  " . $bill_data['bill_no'], 0, 0, 'L');
        $this->pdf->Cell(140, 5, "Bill Date  " . date(DF, strtotime($bill_data['bill_due_date'])), 0, 1, 'R');
        $this->pdf->Cell(190, 5, "Name  " . ucwords($bill_data['client_details']['client_billing_name']), 0, 1, 'L');
        $this->pdf->Cell(190, 5, "" . ucwords($bill_data['client_details']['client_billing_add1']), 0, 1, 'L');
        $this->pdf->Cell(190, 5, "" . ucwords($bill_data['client_details']['client_billing_add2']), 0, 1, 'L');
        $GST_Details = "";
        if (isset($bill_data['client_details']['client_gst_no']) && $bill_data['client_details']['client_gst_no'] != '') {
            $GST_Details.=" GST No. {$bill_data['client_details']['client_gst_no']}";
        }
        if (isset($bill_data['client_details']['client_po']) && $bill_data['client_details']['client_po'] != '') {
            $GST_Details.=", PO No. {$bill_data['client_details']['client_po']}";
        }
        if ($GST_Details != ''){
            $this->pdf->Cell(190, 5, "" . ucwords($GST_Details), 0, 1, 'L');
        }

        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->sety($this->pdf->gety() + 5);
        $this->pdf->SetLineWidth(.5); // line width
        $this->pdf->Cell(140, 8, "Description", 0, 0, 'L');
        $this->pdf->Cell(45, 8, "Amount(Rs.)", 0, 1, 'C');
        $this->pdf->Line(10, $this->pdf->gety() - 8, 190, $this->pdf->gety() - 8);
        $this->pdf->Line(10, $this->pdf->gety() - 8, 10, $this->pdf->gety());
        $this->pdf->Line(10, $this->pdf->gety(), 190, $this->pdf->gety());
        $this->pdf->Line(190, $this->pdf->gety() - 8, 190, $this->pdf->gety());
        $this->pdf->SetFont('Arial', '', 10);
//        echo "<pre>";
//        print_r($bill_data['ser_data']);
        $count = 1;
        foreach ($bill_data['ser_data'] as $eachSer) {
            $y = $this->pdf->gety();
            $eachSer['ser_name_one'] = "";
            for ($i = 0; $i <= strlen($eachSer['ser_name']); $i+=60) {
                $eachSer['ser_name_one'] .= substr($eachSer['ser_name'], $i, 50) . "\n";
//                    $this->pdf->Cell(140, 8, substr($eachSer['ser_name'], $i, 50), 0, 0, 'L');
            }

            $this->pdf->MultiCell(140, 5, ($count++) . ". " . $eachSer['ser_name']);
            $nextY = $this->pdf->gety();
            $this->pdf->sety($y);
            $eachSer['amt'] = (float) trim($eachSer['amt']);
            $this->pdf->Cell(173, 5, number_format($eachSer['amt'], 2) . "", 0, 1, 'R');
//            $this->pdf->Line(10, $this->pdf->gety(), 190, $this->pdf->gety());
            $this->pdf->Line(10, $this->pdf->gety() - 5, 10, $this->pdf->gety() + ($nextY - $y));
            $this->pdf->Line(190, $this->pdf->gety() - 5, 190, $this->pdf->gety() + ($nextY - $y));
            $this->pdf->Line(155, $this->pdf->gety() - 5, 155, $this->pdf->gety() + ($nextY - $y));
            $this->pdf->sety($nextY + 5);
            if($this->pdf->gety()>260){
                $this->pdf->AddPage();  
            } 
        } 

        if ($bill_data['ser_tax'] != 0) {
            $this->pdf->Cell(140, 5, "Service Tax @ 14.00%", 0, 0, 'R');
            $this->pdf->Cell(50, 5, number_format($bill_data['ser_tax'], 2) . "", 0, 1, 'C');

            $this->pdf->Line(10, $this->pdf->gety() - 5, 10, $this->pdf->gety() + 5);
            $this->pdf->Line(190, $this->pdf->gety() - 5, 190, $this->pdf->gety() + 5);
            $this->pdf->Line(155, $this->pdf->gety() - 5, 155, $this->pdf->gety() + 5);
        }
        if ($bill_data['etax'] != 0) {
            $this->pdf->Cell(140, 5, "SBC @ 00.50%", 0, 0, 'R');
            $this->pdf->Cell(50, 5, number_format($bill_data['etax'], 2) . "", 0, 1, 'C');

            $this->pdf->Line(10, $this->pdf->gety() - 5, 10, $this->pdf->gety() + 5);
            $this->pdf->Line(190, $this->pdf->gety() - 5, 190, $this->pdf->gety() + 5);
            $this->pdf->Line(155, $this->pdf->gety() - 5, 155, $this->pdf->gety() + 5);
        }
        if ($bill_data['ktax'] != 0) {
            $this->pdf->Cell(140, 5, "KKC @ 00.50%", 0, 0, 'R');
            $this->pdf->Cell(50, 5, number_format($bill_data['ktax'], 2) . "", 0, 1, 'C');

            $this->pdf->Line(10, $this->pdf->gety() - 5, 10, $this->pdf->gety() + 5);
            $this->pdf->Line(190, $this->pdf->gety() - 5, 190, $this->pdf->gety() + 5);
            $this->pdf->Line(155, $this->pdf->gety() - 5, 155, $this->pdf->gety() + 5);
        }
        if (isset($bill_data['CGST']) && $bill_data['CGST'] != 0) {
            $this->pdf->Cell(140, 5, "CGST @ 9.00%", 0, 0, 'R');
            $this->pdf->Cell(50, 5, number_format(round($bill_data['CGST']), 2) . "", 0, 1, 'C');

            $this->pdf->Line(10, $this->pdf->gety() - 5, 10, $this->pdf->gety() + 5);
            $this->pdf->Line(190, $this->pdf->gety() - 5, 190, $this->pdf->gety() + 5);
            $this->pdf->Line(155, $this->pdf->gety() - 5, 155, $this->pdf->gety() + 5);
        }
        if ($bill_data['IGST'] != 0) {
            $this->pdf->Cell(140, 5, "IGST @ 18.00%", 0, 0, 'R');
            $this->pdf->Cell(50, 5, number_format(round($bill_data['IGST']), 2) . "", 0, 1, 'C');

            $this->pdf->Line(10, $this->pdf->gety() - 5, 10, $this->pdf->gety() + 5);
            $this->pdf->Line(190, $this->pdf->gety() - 5, 190, $this->pdf->gety() + 5);
            $this->pdf->Line(155, $this->pdf->gety() - 5, 155, $this->pdf->gety() + 5);
        }
        if ($bill_data['SGST'] != 0) {
            $this->pdf->Cell(140, 5, "SGST @ 9.00%", 0, 0, 'R');
            $this->pdf->Cell(50, 5, number_format(round($bill_data['SGST']), 2) . "", 0, 1, 'C');

            $this->pdf->Line(10, $this->pdf->gety() - 5, 10, $this->pdf->gety() + 5);
            $this->pdf->Line(190, $this->pdf->gety() - 5, 190, $this->pdf->gety() + 5);
            $this->pdf->Line(155, $this->pdf->gety() - 5, 155, $this->pdf->gety() + 5);
        }
        if ($bill_data['UTGST'] != 0) {
            $this->pdf->Cell(140, 5, "UTGST @ 18.00%", 0, 0, 'R');
            $this->pdf->Cell(50, 5, number_format(round($bill_data['UTGST']), 2) . "", 0, 1, 'C');

            $this->pdf->Line(10, $this->pdf->gety() - 5, 10, $this->pdf->gety() + 5);
            $this->pdf->Line(190, $this->pdf->gety() - 5, 190, $this->pdf->gety() + 5);
            $this->pdf->Line(155, $this->pdf->gety() - 5, 155, $this->pdf->gety() + 5);
        }

        $this->pdf->Cell(140, 5, "Total Amount", 0, 0, 'R');
        $this->pdf->Line(10, $this->pdf->gety(), 190, $this->pdf->gety());
        $this->pdf->Cell(50, 5, (number_format(round($bill_data['total_amt']), 2)) . "", 0, 1, 'C');

        $this->pdf->Line(10, $this->pdf->gety() - 5, 10, $this->pdf->gety() + 5);
        $this->pdf->Line(190, $this->pdf->gety() - 5, 190, $this->pdf->gety() + 5);
        $this->pdf->Line(10, $this->pdf->gety(), 190, $this->pdf->gety());

        $this->pdf->Cell(190, 5, ($bill_data['total_amt_in_wrds']) . " Only", 0, 1, 'L');
        $this->pdf->Line(10, $this->pdf->gety(), 190, $this->pdf->gety());
        $this->pdf->Cell(190, 5, "PAN No. " . ($bill_data['company_details']['pan_no']) . "", 0, 1, 'L');
          if(isset($bill_data['company_details']['st_reg_no']) && $bill_data['company_details']['st_reg_no']!=''){
        $this->pdf->Cell(190, 5, "ST Reg. No. " . ($bill_data['company_details']['st_reg_no']) . "", 0, 1, 'L');
          }
        if(isset($bill_data['company_details']['gst_no']) && $bill_data['company_details']['gst_no']!=''){
        $this->pdf->Cell(190, 5, "GST. No. " . ($bill_data['company_details']['gst_no']) . "", 0, 1, 'L');
        }
        if(isset($bill_data['company_details']['hsn_scn']) && $bill_data['company_details']['hsn_scn']!=''){
        $this->pdf->Cell(190, 5, "HSN/SCN. Code " . ($bill_data['company_details']['hsn_scn']) . "", 0, 1, 'L');
        }
        //Bank Details
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(190, 5, "Bank Details: ", 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 10);
        $singy = $this->pdf->gety();
        $this->pdf->Cell(190, 5, "Bank Name: " . ($bill_data['company_details']['bank_name']) . "", 0, 1, 'L');
        $this->pdf->Cell(190, 5, "A/c No.: " . ($bill_data['company_details']['bank_acc_no']) . "", 0, 1, 'L');
        $this->pdf->Cell(190, 5, "IFSC: " . ($bill_data['company_details']['bank_ifsc_code']) . "", 0, 1, 'L');
        $this->pdf->Cell(190, 5, "Bank Address:" . ($bill_data['company_details']['bank_address']) . "", 0, 1, 'L');
        if($bill_data['msme_no']!=''){
        $this->pdf->Cell(190, 5, "MSME Number:" . ($bill_data['msme_no']) . "", 0, 1, 'L');
        }

        $this->pdf->sety($singy);


        $this->pdf->Cell(175, 15, "For, " . (ucwords($bill_data['company_details']['billing_com_name'])) . "", 0, 1, 'R');
        $this->pdf->Cell(175, 15, "(Authorised Signatory)", 0, 1, 'R');

        $this->pdf->Output();
//        echo "<pre>";
//        print_r($bill_data);
    }

    //put your code here
}
