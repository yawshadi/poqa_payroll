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
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Job Category');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Location');
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Staff SSNIT NO');
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Consolidated Salary');
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', '5.5% Staff SSF');
            $objPHPExcel->getActiveSheet()->SetCellValue('H5', '5% Staff PF');
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Other Benefits / Allowances');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Gross Salary'); // formula change
            $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Loan Repayment');
            $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Loan Benefit');  // formula change
            $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Tax Relief'); // formula change
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Taxable Income'); // formula change
            $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'PAYE Payable '); // formula
            $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Bonus ');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'Bonus Tax');
            $objPHPExcel->getActiveSheet()->SetCellValue('R5', 'Total Tax Payable'); //formula
            $objPHPExcel->getActiveSheet()->SetCellValue('S5', 'Salary Advance');
            $objPHPExcel->getActiveSheet()->SetCellValue('T5', 'Actual Net Salary from VE'); //formula
            $objPHPExcel->getActiveSheet()->SetCellValue('U5', 'Staff Welfare Asso.');
            $objPHPExcel->getActiveSheet()->SetCellValue('V5', 'Other Deductibles');
            $objPHPExcel->getActiveSheet()->SetCellValue('W5', 'Amount Payable to Staff Account');
            $objPHPExcel->getActiveSheet()->SetCellValue('X5', '13% Employer SSNIT');
            $objPHPExcel->getActiveSheet()->SetCellValue('Y5', '18.5% Total Pensions');
            $objPHPExcel->getActiveSheet()->SetCellValue('Z5', '13.5% SSNIT Act 766');
            $objPHPExcel->getActiveSheet()->SetCellValue('AA5', '5% EIC Second Tier');
            $objPHPExcel->getActiveSheet()->SetCellValue('AB5', '5% Employer PF');
            $objPHPExcel->getActiveSheet()->SetCellValue('AC5', '10% Total PF');
    

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
              $jobcat = $get->jobcat;
              $ssnitnumber = $get->ssnitnumber;
              $location = $get->location;
              $basicsalary = $get->basicsalary;
              $otherbenefits = $get->otherbenefit;


              //recurrent calculation
              $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
              $taxrelief = $rec->taxrelf;
              $salaryadvance =  $rec->salaryadvance;
              $staffwelfare = $rec->staffwelfare;
              $otherdeductible = $rec->otherdeductions;
              $bonus = $rec->bonus;
              $loanrepayment = $rec->loanrepayment;



              //payrollcalculations
              $staffssnit = Vamedcalculations::staffssnit($basicsalary);
              $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
              $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
              $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
              $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
              $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
              $rentallowance = Vamedcalculations::rentallowance($basicsalary);
              $staffprovidentfund = Vamedcalculations::employeeprovidentfund($basicsalary);
              $grossincome = Vamedcalculations::grossincome($basicsalary, $otherbenefits, $staffssnit, $staffprovidentfund); // 2021
              $loanbenefits = Vamedcalculations::loanbenefits($loanrepayment); // 2021
              $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief,$loanbenefits); // 2021
              $paye =  Vamedcalculations::paye($taxableincome); // 2021 explain
              $whtonstandardovertime = Vamedcalculations::whtonstandardovertime($standardovertime);
              $whtonsatsunholovertime =  Vamedcalculations::whtonsatsunholovertime($satsunholovertime);
              $bonustax = Vamedcalculations::bonustax($bonus); // 2021
              $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye,$bonustax); //2021
              $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $totaltaxpayable, $salaryadvance, $loanrepayment,$bonus,$basicsalary,$category); // 2021
              $vamedwelfarenetsalary = Vamedcalculations::vamedwelfarenetsalary($vamednetpay, $staffwelfare,$otherdeductible);
              $employerssnit  = Vamedcalculations::employerssnit($basicsalary);
              $totalssnit =  Vamedcalculations::totalssnit($staffssnit, $employerssnit);
              $ssnitact  = Vamedcalculations::ssnitact($basicsalary,$category); // 2021
              $secondtier = Vamedcalculations::secondtier($basicsalary, $category); // 2021

              $employerprovidentfund  = Vamedcalculations::employeeprovidentfund($basicsalary);
              $totalprovident =  Vamedcalculations::totalprovidentfunc($basicsalary,$category);//2021


                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fullname);
             	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $position);
             	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $jobcat);
             	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $location );
             	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ssnitnumber);
             	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $basicsalary);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'  .$i, payround($staffssnit));
             	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, payround($staffprovidentfund));
             	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, payround($otherbenefits));
             	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, payround($grossincome));
             	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, payround($loanrepayment));
             	$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, payround($loanbenefits));
             	$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, payround($taxrelief));
             	$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, payround($taxableincome));
             	$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, payround($paye));
             	$objPHPExcel->getActiveSheet()->SetCellValue('P' . $i, payround($bonus));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Q' .$i, payround($bonustax));
             	$objPHPExcel->getActiveSheet()->SetCellValue('R' .$i, payround($totaltaxpayable));
             	$objPHPExcel->getActiveSheet()->SetCellValue('S' .$i, payround($salaryadvance));
             	$objPHPExcel->getActiveSheet()->SetCellValue('T' .$i, payround($vamednetpay));
                $objPHPExcel->getActiveSheet()->SetCellValue('U' .$i, payround($staffwelfare));
             	$objPHPExcel->getActiveSheet()->SetCellValue('V' .$i, payround($otherdeductible));
             	$objPHPExcel->getActiveSheet()->SetCellValue('W' .$i, payround($vamedwelfarenetsalary));
             	$objPHPExcel->getActiveSheet()->SetCellValue('X' .$i, payround($employerssnit));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Y' .$i, payround($totalssnit));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Z' .$i, payround($ssnitact));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AA' .$i, payround($secondtier));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AB' .$i, payround($employerprovidentfund));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AC' .$i, payround($totalprovident));


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
