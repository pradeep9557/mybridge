<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Excel {

    private $excel;

    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once APPPATH . 'third_party/PHPExcel.php';
        $this->excel = new PHPExcel();
    }

    public function load($path) {
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $this->excel = $objReader->load($path);
    }

    public function save($path) {
        // Write out as the new file
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save($path);
    }

    public function stream($filename, $data = null) {
        if ($data != null) {
            $col = 'A';
            foreach ($data[0] as $key => $val) {
                $objRichText = new PHPExcel_RichText();
                $objPayable = $objRichText->createTextRun(str_replace("_", " ", $key));
                $objPayable->getFont()->setBold(true);
                $objPayable->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKRED));
                $currSheet->getCell($col . '1')->setValue($objRichText);
                //$objPHPExcel->getActiveSheet()->setCellValue($col.'1' , str_replace("_"," ",$key));
                $col++;
            }
            $rowNumber = 2; //start in cell 1
            foreach ($data as $row) {
                $col = 'A'; // start at column A
                foreach ($row as $cell) {
                    $currSheet->setCellValue($col . $rowNumber, $cell);
                    $col++;
                }
                $rowNumber++;
            }
        }
        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        $objWriter->save("temp/$filename");
        header("location: " . base_url() . "temp/$filename");
        unlink(base_url() . "temp/$filename");
    }

    public function __call($name, $arguments) {
        // make sure our child object has this method  
        if (method_exists($this->excel, $name)) {
            // forward the call to our child object  
            return call_user_func_array(array($this->excel, $name), $arguments);
        }
        return null;
    }

    public function print_bills($billData) {
        $currSheet = "";
        $sheet = 0;
        foreach ($billData as $eachBill) {
            if($sheet==0){
                $currSheet = $this->excel->getActiveSheet();
            }else{
              $currSheet = $this->excel->createSheet($sheet);
            }
                
            
            $col = '66';
            $row = "2";
            $filename = "bill_formate" . rand(0, 50000) . ".xls";
            
            //"Pushpanjali Corporate Services Private Limited"
            $this->excel->getDefaultStyle()->getFont()->setName('Arial');
            $currSheet->getCell(chr($col) . $row)
                    ->setValue($eachBill['billing_com_name']);

            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 4) . $row);

            //402, Aakash Chambers,S-528, School Block, Shakarpur ,Delhi,110092
            $col = "66";
            $row++;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue($eachBill['billing_add']);
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 4) . $row);

            $col = "68";
            $row++;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("PH. NO.     :");
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue($eachBill['bill_phone']);

            $col = "68";
            $row++;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("E-mail      :");
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue($eachBill['bill_email']);

            $col = 66;
            $row++;

            $currSheet->getCell(chr($col) . $row)
                    ->setValue("Invoice");


            $col = "65";
            $row + 2;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("Bill No.");
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue($eachBill['bill_no']);
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue("Date:");
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue(date(DF, strtotime($eachBill['add_date'])));

            $col = "65";
            $row + 2;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("Name:");
            //M/s Leroy Somer Motors Division (Division Of Emerson Electric Company Pvt. Ltd.)
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue($eachBill['client_billing_name']);
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 2) . $row);

            $col = 65;
            $row++;
            //"A-221 , Sector-83"
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue($eachBill['client_billing_add1']);

            $col = 65;
            $row++;
            //Noida-201305
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue($eachBill['client_billing_add2']);

            $col = 65;
            $row+=3;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("Description");
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 4) . $row);
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue("Amount(Rs.)");

            foreach ($eachBill['billing_task_details'] as $eachTask) {
                $col = 66;
                $row+=1;
                $currSheet->getCell(chr($col) . $row)
                        ->setValue($eachTask['tm_name']);
                $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 3) . $row);
                foreach ($eachTask['services'] as $eachService) {

                    $row+=1;
                    $currSheet->getCell(chr($col) . $row)
                            ->setValue($eachService['service_name']);
                    $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 3) . $row);

                    $currSheet->getCell(chr($col + 4) . $row)
                            ->setValue($eachService['amt'] . "/-");
                }
            }


            $col = 67;
            
            $row+=1;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("Service Tax @ 14.00 %");
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 2) . $row);
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue("Amount(Rs.)");

            $col = 67;
            
            $row+=1;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("Service Tax @ 14.00 %");
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 2) . $row);
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue("Amount(Rs.)");
            $col = 67;
            
            $row+=1;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("Service Tax @ 14.00 %");
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 2) . $row);
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue("Amount(Rs.)");
            $col = 65;
            
            $row+=1;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("Total: ");
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 3) . $row);
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue("");
            $currSheet->getCell(chr(++$col) . $row)
                    ->setValue("15000");
            
            $col = 65;
            $row+=1;
            $currSheet->getCell(chr($col) . $row)
                    ->setValue("Amount in Words : One Lakh Ten Thousand Seven Hundred Sixteen Only");
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 5) . $row);
            
            $col = 65;
            $row+=1;
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue("PAN No.");
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue($eachBill['pan_no']);
            
            $col = 65;
            $row+=1;
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue("ST Reg No.");
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue($eachBill['st_reg_no']);
            
            $col = 65;
            $row+=1;
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue("Bank Name");
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 2) . $row);
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue("For, {$eachBill['billing_com_name']}");
            
            $col = 65;
            $row+=1;
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue("A/c No. {$eachBill['bank_acc_no']}");
            $col = 65;
            $row+=1;
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue("IFSC. {$eachBill['bank_ifsc_code']}");
                    
                    
                    
            $col = 65;
            $row+=1;
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue("Branch Address: {$eachBill['bank_address']}");
            $currSheet->mergeCells(chr($col) . "$row:" . chr($col + 2) . $row);
            $currSheet->getCell(chr($col++) . $row)
                    ->setValue("(Authorised Signatory)");        
            $sheet++;
        }


        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
        $objWriter->save("temp/$filename");
        header("location: " . base_url() . "temp/$filename");
        unlink(base_url() . "temp/$filename");
    }

}
