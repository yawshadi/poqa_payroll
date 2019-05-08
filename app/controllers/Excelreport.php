<?php

class Excelreport extends Controller{


     public function actualexcel($startdate,$enddate, $companyid){

          $company = Companies::getCompanybyId($companyid);
          $empdata = Employee::getEmployeesByCompany($company);

          $objPHPExcel = new PHPExcel();

          $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                               ->setLastModifiedBy("Maarten Balliauw")
                               ->setTitle("PHPExcel Test Document")
                               ->setSubject("PHPExcel Test Document")
                               ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                               ->setKeywords("office PHPExcel php")
                               ->setCategory("Test result file");

            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Name of Staff');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Position');
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Location');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Staff SSNIT No:');
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Basic Salary');
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', '5.5% Staff SSNIT');
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Transport / Vehicle Maintenance Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Rent/ Housing Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Gross Incone');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Standard Overtime / Call-In Work');
            $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Sat, Sun, Holidays Overtime');
            $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Team Development & Pay Weekend Bonus');
            $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Tax Relief');
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Taxable Income');
            $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'PAYE Tax Payable ');
            $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'WHT on Standard Overtime / Call-In');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'WHT on Excess Overtime');
            $objPHPExcel->getActiveSheet()->SetCellValue('R5', 'Bonus Tax');
            $objPHPExcel->getActiveSheet()->SetCellValue('S5', 'Total Tax Payable');
            $objPHPExcel->getActiveSheet()->SetCellValue('T5', 'Salary Advance');
            $objPHPExcel->getActiveSheet()->SetCellValue('U5', 'Actual Net Pay from VE');
            $objPHPExcel->getActiveSheet()->SetCellValue('V5', 'Staff Welfare Asso.');
            $objPHPExcel->getActiveSheet()->SetCellValue('W5', 'Net Amount Payable to Staff Accounts');
            $objPHPExcel->getActiveSheet()->SetCellValue('X5', '13% Employer SSNIT');
            $objPHPExcel->getActiveSheet()->SetCellValue('Y5', '18.5% Total SSNIT');
            $objPHPExcel->getActiveSheet()->SetCellValue('Z5', '13.5% SSNIT Act 766');
            $objPHPExcel->getActiveSheet()->SetCellValue('AA5', '5% EIC Second Tier');





          for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
            }

            $i = 6;

            foreach($empdata as $get){

              $department =  $get->department;
              $position  = $get->position;
              $fullname =  $get->surname. ' '.$get->firstname;
              $basic_id = $get->basic_id;
              $category = $get->category;
              $ssnitnumber = $get->ssnitnumber;
              $location = $get->location;
              $basicsalary = $get->basicsalary;


              //recurrent calculation
              $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
              $taxrelief = $rec->taxrelf;
              $salaryadvance =  $rec->salaryadvance;
              $staffwelfare = $rec->staffwelfare;

              //payrollcalculations
              $staffssnit = Vamedcalculations::staffssnit($basicsalary);
              $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
              $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
              $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
              $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
              $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
              $rentallowance = Vamedcalculations::rentallowance($basicsalary);
              $grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit);
              $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief);
              $paye =  Vamedcalculations::paye($taxableincome);
              $whtonstandardovertime = Vamedcalculations::whtonstandardovertime($standardovertime);
              $whtonsatsunholovertime =  Vamedcalculations::whtonsatsunholovertime($satsunholovertime);
              $bonustax = Vamedcalculations::bonustax($teamdevelopment);
              $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye, $whtonstandardovertime, $whtonsatsunholovertime, $bonustax);
              $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $totaltaxpayable, $salaryadvance);
              $vamedwelfarenetsalary = Vamedcalculations::vamedwelfarenetsalary($vamednetpay, $staffwelfare);
              $employerssnit  = Vamedcalculations::employerssnit($basicsalary);
              $totalssnit =  Vamedcalculations::totalssnit($staffssnit, $employerssnit);
              $ssnitact  = Vamedcalculations::ssnitact($totalssnit);
              $secondtier = Vamedcalculations::secondtier($totalssnit, $ssnitact);


              $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fullname);
             	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $position);
             	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $location);
             	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $ssnitnumber );
             	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $basicsalary);
             	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, payround($staffssnit));
             	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, payround($transportvehiclemaintenance));
             	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, payround($rentallowance));
             	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, payround($grossincome));
             	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, payround($standardovertime));
             	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, payround($satsunholovertime));
             	$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, payround($teamdevelopment));
             	$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, payround($taxrelief));
             	$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, payround($taxableincome));
             	$objPHPExcel->getActiveSheet()->SetCellValue('O' . $i, payround($paye));
             	$objPHPExcel->getActiveSheet()->SetCellValue('P' .$i, payround($whtonstandardovertime));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Q' .$i, payround($whtonsatsunholovertime));
             	$objPHPExcel->getActiveSheet()->SetCellValue('R' .$i, payround($bonustax));
             	$objPHPExcel->getActiveSheet()->SetCellValue('S' .$i, payround($totaltaxpayable));
             	$objPHPExcel->getActiveSheet()->SetCellValue('T' .$i, payround($salaryadvance));
             	$objPHPExcel->getActiveSheet()->SetCellValue('U' .$i, payround($vamednetpay));
             	$objPHPExcel->getActiveSheet()->SetCellValue('V' .$i, payround($staffwelfare));
             	$objPHPExcel->getActiveSheet()->SetCellValue('W' .$i, payround($vamedwelfarenetsalary));
             	$objPHPExcel->getActiveSheet()->SetCellValue('X' .$i, payround($employerssnit));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Y' .$i, payround($totalssnit));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Z' .$i, payround($ssnitact));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AA' .$i, payround($secondtier));


              $i++;
         }


        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'VAMED ENGINEERING GmbH');

        $imgpath = URLROOT.'/img/vamed.jpg';

        $gdImage = imagecreatefromjpeg($imgpath);

        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(80);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setTitle('SheetOne');

        ob_end_clean();
        header( "Content-type: application/vnd.ms-excel" );
        header('Content-Disposition: attachment; filename="payroll.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

     }


}



?>
