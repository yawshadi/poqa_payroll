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
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Total Income');
            $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Standard Overtime / Call-In Works');
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Team Development Bonus');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Sat, Sun, Holidays Overtime');
            $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Transport / Vehicle Maintenance Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Rent / Housing Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Gross Income');
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Tax Relief');
            $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Taxable Income');
            $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'PAYE Tax Payable');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'WHT on Overtime / Call-In');
            $objPHPExcel->getActiveSheet()->SetCellValue('R5', 'WHT on Excess Overtime');
            $objPHPExcel->getActiveSheet()->SetCellValue('S5', 'Bonus Tax');
            $objPHPExcel->getActiveSheet()->SetCellValue('T5', 'Total Tax Payable');
            $objPHPExcel->getActiveSheet()->SetCellValue('U5', 'Salary Advance');
            $objPHPExcel->getActiveSheet()->SetCellValue('V5', 'Actual Net Pay from VE');
            $objPHPExcel->getActiveSheet()->SetCellValue('W5', 'Staff Welfare Association ');
            $objPHPExcel->getActiveSheet()->SetCellValue('X5', 'Net Amount Payable to Staff Accounts');
            $objPHPExcel->getActiveSheet()->SetCellValue('Y5', '13% Employer SSNIT');
            $objPHPExcel->getActiveSheet()->SetCellValue('Z5', '18.5% Total SSNIT');
            $objPHPExcel->getActiveSheet()->SetCellValue('AA5', '13.5% SSNIT Act 766');
            $objPHPExcel->getActiveSheet()->SetCellValue('AB5', '5% EIC Second Tier ');



          for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
            }

            $i = 6;

            foreach($empdata as $get){

              $department =  $get->department;
              $position  = $get->position;
              $fullname =  $get->fullname;
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
              $standardovertime = Vamedcalculations::standardovertime($basicsalary);
              $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary);
              $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
              $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
              $rentallowance = Vamedcalculations::rentallowance($basicsalary);
              $grossincome = Vamedcalculations::grossincome($totalincome, $transportvehiclemaintenance, $rentallowance);
              $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief);
              $paye =  Vamedcalculations::paye($taxableincome);
              $whtonstandardovertime = Vamedcalculations::whtonstandardovertime($standardovertime);
              $whtonsatsunholovertime =  Vamedcalculations::whtonsatsunholovertime($satsunholovertime);
              $bonustax = Vamedcalculations::bonustax($teamdevelopment);
              $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye, $whtonstandardovertime, $whtonsatsunholovertime, $bonustax);
              $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $rentallowance,
                                                 $transportvehiclemaintenance, $totaltaxpayable, $salaryadvance);
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
             	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, payround($totalincome));
             	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, payround($standardovertime));
             	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, payround($teamdevelopment));
             	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, payround($satsunholovertime));
             	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, payround($transportvehiclemaintenance));
             	$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, payround($rentallowance));
             	$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, payround($grossincome));
             	$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, payround($taxrelief));
             	$objPHPExcel->getActiveSheet()->SetCellValue('O' . $i, payround($taxableincome));
             	$objPHPExcel->getActiveSheet()->SetCellValue('P' .$i, payround($paye));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Q' .$i, payround($whtonstandardovertime));
             	$objPHPExcel->getActiveSheet()->SetCellValue('R' .$i, payround($whtonsatsunholovertime));
             	$objPHPExcel->getActiveSheet()->SetCellValue('S' .$i, payround($bonustax));
             	$objPHPExcel->getActiveSheet()->SetCellValue('T' .$i, payround($totaltaxpayable));
             	$objPHPExcel->getActiveSheet()->SetCellValue('U' .$i, payround($salaryadvance));
             	$objPHPExcel->getActiveSheet()->SetCellValue('V' .$i, payround($vamednetpay));
             	$objPHPExcel->getActiveSheet()->SetCellValue('W' .$i, payround($staffwelfare));
             	$objPHPExcel->getActiveSheet()->SetCellValue('X' .$i, payround($vamedwelfarenetsalary));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Y' .$i, payround($employerssnit));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Z' .$i, payround($totalssnit));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AA' .$i, payround($ssnitact));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AB' .$i, payround($secondtier));

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
