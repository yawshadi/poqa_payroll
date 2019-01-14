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
            $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Employee Name');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Department');
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Position');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Total Full Present Hrs');
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Basic Salary');
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Transport Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Gross');
            $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Weekday Hourly Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Weekday Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Holiday & Weekend Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Night Shift Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Basic Salary');
            $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Transport Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Gross');
            $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Weekday Shift Basic');
            $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Weekday Night Shift Basic');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'Weekday Overtime Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('R5', 'Holiday and Weekend Overtime Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('S5', 'Night Shift Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('T5', 'T&T Actual Present ');
            $objPHPExcel->getActiveSheet()->SetCellValue('U5', 'Total Wage ');
            $objPHPExcel->getActiveSheet()->SetCellValue('V5', 'Total Overtime');
            $objPHPExcel->getActiveSheet()->SetCellValue('W5', 'Overtime tax ');
            $objPHPExcel->getActiveSheet()->SetCellValue('X5', 'Other Allowance ');
            $objPHPExcel->getActiveSheet()->SetCellValue('Y5', 'Other Deductions');
            $objPHPExcel->getActiveSheet()->SetCellValue('Z5', 'Overall Gross ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AA5', 'SSF Basic ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AB5', 'SSF (5.5%)');
            $objPHPExcel->getActiveSheet()->SetCellValue('AC5', 'Taxable');
            $objPHPExcel->getActiveSheet()->SetCellValue('AD5', 'PAYE');
            $objPHPExcel->getActiveSheet()->SetCellValue('AE5', 'Total Tax');
            $objPHPExcel->getActiveSheet()->SetCellValue('AF5', 'Total Deductions');
            $objPHPExcel->getActiveSheet()->SetCellValue('AG5', 'Net Pay');
            $objPHPExcel->getActiveSheet()->SetCellValue('AH5', 'SSNIT Company (13%)');
            $objPHPExcel->getActiveSheet()->SetCellValue('AI5', 'Total Cost Of Salary');


          for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
            }

            $i = 6;

            foreach($empdata as $get){

            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;


            $fix = Position::getpositiondata($company, $department, $position);

            $basic_salary = $fix->basic_salary;
            $transport_allowance = $fix->transport_allowance;
            $gross = $fix->gross1;
            $holiday_overtime_rate = $fix->holiday_overtime_rate;
            $total_full_present = $fix->total_full_present;

            // $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
            // $transport_allowance = Reports::transport_allowance($company, $department, $position, $startdate, $enddate);
            //
            // $gross = Reports::gross($company, $department, $position, $startdate, $enddate);
            //
            // $holiday_overtime_rate =Reports::holiday_overtime_rate($company, $department, $position, $startdate, $enddate);
            // $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);

            $weekday_hourly_rate = $basic_salary / $total_full_present;
            $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
            $holiday_overtime_rate = $weekday_hourly_rate * 2;
            $night_shift_allowance = $weekday_hourly_rate * 0.25;


            //$total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);
            $weekday_hourly_rate = $basic_salary / $total_full_present;
            $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
            $holiday_overtime_rate = $weekday_hourly_rate * 2;
            $night_shift_allowance = $weekday_hourly_rate * 0.25;

            $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
            $weekday_dayshift = $rec->weekdayshifthours;
            $weekday_nightshift =  $rec->weekdaynightshifthours;
            $weekday_overtime = $rec->weekdayovertimehours;
            $holiday_weekend_overtime  = $rec->holidayovertimehours;
            $otherallowance =   $rec->otherallowances;
            $otherdeductions =  $rec->otherdeductions;

            $nightshiftallowance = Calculations:: nightshiftallowance($night_shift_allowance, $weekday_nightshift);
            $holidayandweekovertimeallowance = Calculations::holidayandweekovertimeallowance($holiday_overtime_rate,$holiday_weekend_overtime);
            $weekdayovertimeallowance = Calculations::weekdayovertimeallowance($weekday_overtime_rate,$weekday_overtime);
            $totalovertime = Calculations::totalovertime($weekdayovertimeallowance, $holidayandweekovertimeallowance);
            $transportactualpresent = Calculations::transportactualpresent($total_full_present, $transport_allowance, $weekday_dayshift,  $weekday_nightshift);
            $weekdaynightshitbasic = Calculations::weekdaynightshitbasic($weekday_hourly_rate,$weekday_nightshift);
            $weekdayshiftbasic = Calculations::weekdayshiftbasic($weekday_hourly_rate, $weekday_dayshift);
            $totalwage = Calculations::totalwage($weekdayshiftbasic, $weekdaynightshitbasic);
            $overallgross = Calculations::overallgross($totalwage,$transportactualpresent,$totalovertime,$otherallowance,$nightshiftallowance, $otherdeductions);

            $overtimepercent = Calculations::overtimepercent($totalwage);
            $ssfbasic = Calculations::ssfbasic($weekdayshiftbasic, $weekdaynightshitbasic);
            $ssfemp = Calculations::ssfemp($ssfbasic);

            $totalovertime = Calculations::totalovertime($weekdayovertimeallowance, $holidayandweekovertimeallowance);
            $taxable = Calculations::taxable($totalwage,$overallgross,$totalovertime, $ssfemp);
            $paye = Calculations::paye($taxable);
            $overtimetax = Calculations::overtimetax($totalwage, $totalovertime, $overtimepercent);
            $totaltax = Calculations::totaltax($overtimetax, $paye);
            $totaldeduction =Calculations::totaldeduction($ssfemp, $totaltax);
            $netpay = Calculations::netpay($overallgross, $totaldeduction);
            //$ssnitbasic  = $basic_salary;
            $ssnitpercent  = Calculations::ssnitpercent($ssfbasic);
            $ssnitocompany = Calculations::ssnitocompany($totalwage);
            $totalssf = Calculations:: totalssf($ssnitpercent, $ssnitocompany);


             $totalsalarycost = Calculations::totalsalarycost($overallgross,$ssnitcompany);

              $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fullname);
             	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $department);
             	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i,	$position);
             	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $total_full_present );
             	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $basic_salary);
             	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $transport_allowance);
             	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $gross );
             	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, payround($weekday_hourly_rate));
             	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, payround($weekday_overtime_rate));
             	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, payround($holiday_overtime_rate));
             	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, payround($night_shift_allowance));
             	$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, payround($basic_salary));
             	$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, payround($transport_allowance));
             	$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, payround($gross));
             	$objPHPExcel->getActiveSheet()->SetCellValue('O' . $i, payround($weekdayshiftbasic ));
             	$objPHPExcel->getActiveSheet()->SetCellValue('P' .$i, payround($weekdaynightshitbasic));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Q' .$i, payround($weekdayovertimeallowance));
             	$objPHPExcel->getActiveSheet()->SetCellValue('R' .$i, payround($holidayandweekovertimeallowance));
             	$objPHPExcel->getActiveSheet()->SetCellValue('S' .$i, payround($nightshiftallowance));
             	$objPHPExcel->getActiveSheet()->SetCellValue('T' .$i, payround($transportactualpresent));
             	$objPHPExcel->getActiveSheet()->SetCellValue('U' .$i, payround($totalwage));
             	$objPHPExcel->getActiveSheet()->SetCellValue('V' .$i, payround($totalovertime));
             	$objPHPExcel->getActiveSheet()->SetCellValue('W' .$i, payround($overtimetax));
             	$objPHPExcel->getActiveSheet()->SetCellValue('X' .$i, payround($otherallowance));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Y' .$i, payround($otherdeductions));
             	$objPHPExcel->getActiveSheet()->SetCellValue('Z' .$i, payround($overallgross));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AA' .$i, payround($ssfbasic));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AB' .$i, payround($ssfemp));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AC' .$i, payround($taxable));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AD' .$i, payround($paye));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AE' .$i, payround($totaltax));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AF' .$i, payround($totaldeduction));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AG' .$i, payround($netpay));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AH' .$i, payround($ssnitocompany));
             	$objPHPExcel->getActiveSheet()->SetCellValue('AI' .$i, payround($totalsalarycost));
              $i++;
         }


        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'LABOUR POWER STRUCTURE');

        $imgpath = URLROOT.'/img/plogo.jpg';

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
        header('Content-Disposition: attachment; filename="actualpayroll.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

     }



     public function salarysheetexcel($startdate,$enddate, $companyid){
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
            $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Employee Name');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Department');
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Position');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Total Full Present Hrs');
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Basic Salary');
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Transport Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Gross');
            $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Weekday Hourly Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Weekday Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Holiday & Weekend Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Night Shift Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Basic Salary');
            $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Transport Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Gross');
            $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Weekday Hourly Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Weekday Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'Holiday & Weekend Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('R5', 'Night Shift Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('S5', 'Weekday Shift Basic');
            $objPHPExcel->getActiveSheet()->SetCellValue('T5', 'Weekday Night Shift Basic');
            $objPHPExcel->getActiveSheet()->SetCellValue('U5', 'Weekday Overtime Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('V5', 'Holiday and Weekend Overtime Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('W5', 'Night Shift Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('X5', 'T&T Actual Present ');
            $objPHPExcel->getActiveSheet()->SetCellValue('Y5', 'Total Wage ');
            $objPHPExcel->getActiveSheet()->SetCellValue('Z5', 'Total Overtime');
            $objPHPExcel->getActiveSheet()->SetCellValue('AA5', 'Overtime tax ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AB5', 'Other Allowance ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AC5', 'Other Deductions');
            $objPHPExcel->getActiveSheet()->SetCellValue('AD5', 'Overall Gross ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AE5', 'SSF Basic ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AF5', 'SSF (5.5%)');
            $objPHPExcel->getActiveSheet()->SetCellValue('AG5', 'Taxable');
            $objPHPExcel->getActiveSheet()->SetCellValue('AH5', 'PAYE');
            $objPHPExcel->getActiveSheet()->SetCellValue('AI5', 'Total Tax');
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ5', 'Total Deductions');
            $objPHPExcel->getActiveSheet()->SetCellValue('AK5', 'Net Pay');
            $objPHPExcel->getActiveSheet()->SetCellValue('AL5', 'SSNIT Company (13%)');
            $objPHPExcel->getActiveSheet()->SetCellValue('AM5', 'Total Cost Of Salary');


          for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
            }

            $i = 6;

            foreach($empdata as $get){

            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;

            $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
            $transport_allowance = Reports::transport_allowance($company, $department, $position, $startdate, $enddate);
            $weekday_overtime_rate = Reports::weekday_overtime_rate ($company, $department, $position, $startdate, $enddate);
            $gross = Reports::gross($company, $department, $position, $startdate, $enddate);
            $night_shift_allowance = Reports::night_shift_allowance($company, $department, $position, $startdate, $enddate);
            $weekday_hourly_rate = Reports::weekday_hourly_rate($company, $department, $position, $startdate, $enddate);
            $holiday_overtime_rate =Reports::holiday_overtime_rate($company, $department, $position, $startdate, $enddate);
            $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);

            //recurrent calculation
            $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);

            $weekday_dayshift = $rec->weekdayshifthours;
            $weekday_nightshift =  $rec->weekdaynightshifthours;
            $weekday_overtime = $rec->weekdayovertimehours;
            $holiday_weekend_overtime  = $rec->holidayovertimehours;

            // payroll main calculation
            $weekdayshiftbasic = $weekday_hourly_rate * $weekday_dayshift;
            $weekdaynightshitbasic = $weekday_hourly_rate * $weekday_nightshift ;
            $weekdayovertimeallowance = $weekday_overtime_rate  * $weekday_overtime;
            $holidayandweekovertimeallowance = $holiday_overtime_rate  * $holiday_weekend_overtime;
            $nightshiftallowance = $night_shift_allowance   * $weekday_nightshift;
            if($total_full_present == 0 ||  $total_full_present == '' ){
            $transportactualpresent = 0;
            }else{
            $transportactualpresent = ($transport_allowance / $total_full_present) * ($weekday_dayshift + $weekday_nightshift);
            }

            $totalwage = $weekdayshiftbasic + $weekdaynightshitbasic;
            $totalovertime = $weekdayovertimeallowance + $holidayandweekovertimeallowance;
            $otherallowance =   $rec->otherallowances;
            $otherdeductions =  $rec->otherdeductions;
            $overtimetax = 0;
            $overtimepercent = 0.5 * $totalwage;

            // overtimetax calcukation ///////////////////////////////////////////////////////////////////////////////
            if($totalwage <= 1500 ){
              $dummy = 0.5 * $totalwage;
              if($totalovertime <= $dummy){
                $overtimetax = round($totalovertime,2)  * 0.05;
              }else{
                $overtimetax = (round($totalwage,2) * 0.5) * 0.05 +
                (round($totalovertime,2) - (round($totalwage,2) * 0.5)) * 0.10;
              }

            }

            else if($totalwage > 1500 && $totalovertime > $overtimepercent){
              $dummyamount = $totalwage * 0.5;
              $overtimetax = ($dummyamount * 0.05) + (($totalovertime - $dummyamount) * 0.10);
             }

             else if($totalwage > 1500 && $totalovertime <= $overtimepercent){
             $overtimetax = $totalovertime * 0.05;
             }

             $overallgross = ($totalwage + $transportactualpresent + $totalovertime + $otherallowance + $nightshiftallowance) - $otherdeductions;

             $ssfbasic = $weekdayshiftbasic + $weekdaynightshitbasic;
             $ssfemp = $ssfbasic * 0.055;

             $taxable = 0;

             ///// Taxable Income Calculation ////////////////////////////////////////////////////////////////////////

              if($totalwage <= 1500 ){$taxable = $overallgross - $ssfemp - $totalovertime;}

              if($totalwage > 1500 ){$taxable = $overallgross - $ssfemp;}

             ////////////////////////////////////////////////////////////////////////////////////////////////////////

             $paye = 0;

             //// PAYE Calaulation //////////////////////////////////////////////////////////////////////////////////

             if($taxable <= 216){ $paye = 0; }

             if($taxable > 216 && $taxable<=324){ $paye = ($taxable - 216) * 0.05; }

             if($taxable > 324 && $taxable <= 475){ $paye = (($taxable - 324) * 0.10) + 5.4; }

             if($taxable > 475 && $taxable <= 3240){ $paye = (($taxable - 475) * 0.175) + 20.5; }

             if($taxable > 3240){ $paye = (($taxable - 3240) * 0.25) + 504.375; }


              $totaltax = $overtimetax + $paye;
              $totaldeduction = $ssfemp + $totaltax;
              $netpay = $overallgross -$totaldeduction;
              $ssnitcompany = $totalwage * 0.13;
              $totalsalarycost = $overallgross + $ssnitcompany;

              $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fullname);
               $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $department);
               $objPHPExcel->getActiveSheet()->setCellValue('C' . $i,	$position);
               $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $total_full_present );
               $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $basic_salary);
               $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $transport_allowance);
               $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $gross );
               $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $weekday_hourly_rate);
               $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $weekday_overtime_rate);
               $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $holiday_overtime_rate);
               $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $night_shift_allowance);
               $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $basic_salary);
               $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $transport_allowance);
               $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $gross);
               $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $weekday_dayshift);
               $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $weekday_overtime );
               $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $holiday_weekend_overtime);
               $objPHPExcel->getActiveSheet()->SetCellValue('R' . $i, $weekday_nightshift);
               $objPHPExcel->getActiveSheet()->SetCellValue('S' . $i, $weekdayshiftbasic );
               $objPHPExcel->getActiveSheet()->SetCellValue('T' .$i, $weekdaynightshitbasic);
               $objPHPExcel->getActiveSheet()->SetCellValue('U' .$i, $weekdayovertimeallowance);
               $objPHPExcel->getActiveSheet()->SetCellValue('V' .$i, $holidayandweekovertimeallowance);
               $objPHPExcel->getActiveSheet()->SetCellValue('W' .$i, $nightshiftallowance);
               $objPHPExcel->getActiveSheet()->SetCellValue('X' .$i, $transportactualpresent);
               $objPHPExcel->getActiveSheet()->SetCellValue('Y' .$i, $totalwage);
               $objPHPExcel->getActiveSheet()->SetCellValue('Z' .$i, $totalovertime);
               $objPHPExcel->getActiveSheet()->SetCellValue('AA' .$i, $overtimetax);
               $objPHPExcel->getActiveSheet()->SetCellValue('AB' .$i, $otherallowance);
               $objPHPExcel->getActiveSheet()->SetCellValue('AC' .$i, $otherdeductions);
               $objPHPExcel->getActiveSheet()->SetCellValue('AD' .$i, round($overallgross, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AE' .$i, round($ssfbasic, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AF' .$i, round($ssfemp, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AG' .$i, round($taxable, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AH' .$i, round($paye, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AI' .$i, round($totaltax, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AJ' .$i, round($totaldeduction, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AK' .$i, round($netpay, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$i, round($ssnitcompany, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$i, round($totalsalarycost, 2));
              $i++;
         }


        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'LABOUR POWER STRUCTURE');

        $imgpath = URLROOT.'/img/plogo.jpg';

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
        header('Content-Disposition: attachment; filename="actualpayroll.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

     }

     public function chargesheetexcel($startdate,$enddate, $companyid){
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
            $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Employee Name');
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Department');
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Position');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Total Full Present Hrs');
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Basic Salary');
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Transport Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Gross');
            $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Weekday Hourly Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Weekday Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Holiday & Weekend Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Night Shift Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Basic Salary');
            $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Transport Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Gross');
            $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Weekday Hourly Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Weekday Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'Holiday & Weekend Overtime Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('R5', 'Night Shift Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('S5', 'Weekday Shift Basic');
            $objPHPExcel->getActiveSheet()->SetCellValue('T5', 'Weekday Night Shift Basic');
            $objPHPExcel->getActiveSheet()->SetCellValue('U5', 'Weekday Overtime Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('V5', 'Holiday and Weekend Overtime Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('W5', 'Night Shift Allowance');
            $objPHPExcel->getActiveSheet()->SetCellValue('X5', 'T&T Actual Present ');
            $objPHPExcel->getActiveSheet()->SetCellValue('Y5', 'Total Wage ');
            $objPHPExcel->getActiveSheet()->SetCellValue('Z5', 'Total Overtime');
            $objPHPExcel->getActiveSheet()->SetCellValue('AA5', 'Overtime tax ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AB5', 'Other Allowance ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AC5', 'Other Deductions');
            $objPHPExcel->getActiveSheet()->SetCellValue('AD5', 'Overall Gross ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AE5', 'SSF Basic ');
            $objPHPExcel->getActiveSheet()->SetCellValue('AF5', 'SSF (5.5%)');
            $objPHPExcel->getActiveSheet()->SetCellValue('AG5', 'Taxable');
            $objPHPExcel->getActiveSheet()->SetCellValue('AH5', 'PAYE');
            $objPHPExcel->getActiveSheet()->SetCellValue('AI5', 'Total Tax');
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ5', 'Total Deductions');
            $objPHPExcel->getActiveSheet()->SetCellValue('AK5', 'Net Pay');
            $objPHPExcel->getActiveSheet()->SetCellValue('AL5', 'SSNIT Company (13%)');
            $objPHPExcel->getActiveSheet()->SetCellValue('AM5', 'Total Cost Of Salary');


          for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
            }

            $i = 6;

            foreach($empdata as $get){

            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;

            $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
            $transport_allowance = Reports::transport_allowance($company, $department, $position, $startdate, $enddate);
            $weekday_overtime_rate = Reports::weekday_overtime_rate ($company, $department, $position, $startdate, $enddate);
            $gross = Reports::gross($company, $department, $position, $startdate, $enddate);
            $night_shift_allowance = Reports::night_shift_allowance($company, $department, $position, $startdate, $enddate);
            $weekday_hourly_rate = Reports::weekday_hourly_rate($company, $department, $position, $startdate, $enddate);
            $holiday_overtime_rate =Reports::holiday_overtime_rate($company, $department, $position, $startdate, $enddate);
            $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);

            //recurrent calculation
            $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);

            $weekday_dayshift = $rec->weekdayshifthours;
            $weekday_nightshift =  $rec->weekdaynightshifthours;
            $weekday_overtime = $rec->weekdayovertimehours;
            $holiday_weekend_overtime  = $rec->holidayovertimehours;

            // payroll main calculation
            $weekdayshiftbasic = $weekday_hourly_rate * $weekday_dayshift;
            $weekdaynightshitbasic = $weekday_hourly_rate * $weekday_nightshift ;
            $weekdayovertimeallowance = $weekday_overtime_rate  * $weekday_overtime;
            $holidayandweekovertimeallowance = $holiday_overtime_rate  * $holiday_weekend_overtime;
            $nightshiftallowance = $night_shift_allowance   * $weekday_nightshift;
            if($total_full_present == 0 ||  $total_full_present == '' ){
            $transportactualpresent = 0;
            }else{
            $transportactualpresent = ($transport_allowance / $total_full_present) * ($weekday_dayshift + $weekday_nightshift);
            }

            $totalwage = $weekdayshiftbasic + $weekdaynightshitbasic;
            $totalovertime = $weekdayovertimeallowance + $holidayandweekovertimeallowance;
            $otherallowance =   $rec->otherallowances;
            $otherdeductions =  $rec->otherdeductions;
            $overtimetax = 0;
            $overtimepercent = 0.5 * $totalwage;

            // overtimetax calcukation ///////////////////////////////////////////////////////////////////////////////
            if($totalwage <= 1500 ){
              $dummy = 0.5 * $totalwage;
              if($totalovertime <= $dummy){
                $overtimetax = round($totalovertime,2)  * 0.05;
              }else{
                $overtimetax = (round($totalwage,2) * 0.5) * 0.05 +
                (round($totalovertime,2) - (round($totalwage,2) * 0.5)) * 0.10;
              }

            }

            else if($totalwage > 1500 && $totalovertime > $overtimepercent){
              $dummyamount = $totalwage * 0.5;
              $overtimetax = ($dummyamount * 0.05) + (($totalovertime - $dummyamount) * 0.10);
             }

             else if($totalwage > 1500 && $totalovertime <= $overtimepercent){
             $overtimetax = $totalovertime * 0.05;
             }

             $overallgross = ($totalwage + $transportactualpresent + $totalovertime + $otherallowance + $nightshiftallowance) - $otherdeductions;

             $ssfbasic = $weekdayshiftbasic + $weekdaynightshitbasic;
             $ssfemp = $ssfbasic * 0.055;

             $taxable = 0;

             ///// Taxable Income Calculation ////////////////////////////////////////////////////////////////////////

              if($totalwage <= 1500 ){$taxable = $overallgross - $ssfemp - $totalovertime;}

              if($totalwage > 1500 ){$taxable = $overallgross - $ssfemp;}

             ////////////////////////////////////////////////////////////////////////////////////////////////////////

             $paye = 0;

             //// PAYE Calaulation //////////////////////////////////////////////////////////////////////////////////

             if($taxable <= 216){ $paye = 0; }

             if($taxable > 216 && $taxable<=324){ $paye = ($taxable - 216) * 0.05; }

             if($taxable > 324 && $taxable <= 475){ $paye = (($taxable - 324) * 0.10) + 5.4; }

             if($taxable > 475 && $taxable <= 3240){ $paye = (($taxable - 475) * 0.175) + 20.5; }

             if($taxable > 3240){ $paye = (($taxable - 3240) * 0.25) + 504.375; }


              $totaltax = $overtimetax + $paye;
              $totaldeduction = $ssfemp + $totaltax;
              $netpay = $overallgross -$totaldeduction;
              $ssnitcompany = $totalwage * 0.13;
              $totalsalarycost = $overallgross + $ssnitcompany;

              $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fullname);
               $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $department);
               $objPHPExcel->getActiveSheet()->setCellValue('C' . $i,	$position);
               $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $total_full_present );
               $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $basic_salary);
               $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $transport_allowance);
               $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $gross );
               $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $weekday_hourly_rate);
               $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $weekday_overtime_rate);
               $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $holiday_overtime_rate);
               $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $night_shift_allowance);
               $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $basic_salary);
               $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $transport_allowance);
               $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $gross);
               $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $weekday_dayshift);
               $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $weekday_overtime );
               $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $holiday_weekend_overtime);
               $objPHPExcel->getActiveSheet()->SetCellValue('R' . $i, $weekday_nightshift);
               $objPHPExcel->getActiveSheet()->SetCellValue('S' . $i, $weekdayshiftbasic );
               $objPHPExcel->getActiveSheet()->SetCellValue('T' .$i, $weekdaynightshitbasic);
               $objPHPExcel->getActiveSheet()->SetCellValue('U' .$i, $weekdayovertimeallowance);
               $objPHPExcel->getActiveSheet()->SetCellValue('V' .$i, $holidayandweekovertimeallowance);
               $objPHPExcel->getActiveSheet()->SetCellValue('W' .$i, $nightshiftallowance);
               $objPHPExcel->getActiveSheet()->SetCellValue('X' .$i, $transportactualpresent);
               $objPHPExcel->getActiveSheet()->SetCellValue('Y' .$i, $totalwage);
               $objPHPExcel->getActiveSheet()->SetCellValue('Z' .$i, $totalovertime);
               $objPHPExcel->getActiveSheet()->SetCellValue('AA' .$i, $overtimetax);
               $objPHPExcel->getActiveSheet()->SetCellValue('AB' .$i, $otherallowance);
               $objPHPExcel->getActiveSheet()->SetCellValue('AC' .$i, $otherdeductions);
               $objPHPExcel->getActiveSheet()->SetCellValue('AD' .$i, round($overallgross, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AE' .$i, round($ssfbasic, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AF' .$i, round($ssfemp, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AG' .$i, round($taxable, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AH' .$i, round($paye, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AI' .$i, round($totaltax, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AJ' .$i, round($totaldeduction, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AK' .$i, round($netpay, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$i, round($ssnitcompany, 2));
               $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$i, round($totalsalarycost, 2));
              $i++;
         }


        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'LABOUR POWER STRUCTURE');

        $imgpath = URLROOT.'/img/plogo.jpg';

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
        header('Content-Disposition: attachment; filename="actualpayroll.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

     }


     public function payeexcel($startdate,$enddate, $companyid){
        $company = Companies::getCompanybyId($companyid);
        $empdata = Employee::getEmployeesByCompany($company);


        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("PHPExcel Test Document")
                             ->setSubject("PHPExcel Test Document")
                             ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                             ->setKeywords("office PHPExcel php")
                             ->setCategory("Test result file");

          $objPHPExcel->setActiveSheetIndex(0);
          $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Employee Code');
          $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Employee Name');
          $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Position');
          $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Employee TIN');
          $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Extra / Overtime Allowance');
          $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Other Allowance');
          $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Other Deductions');
          $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Overall Gross');
          $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'SSNIT (13%)');
          $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'SSF (5.5%)');
          $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Total SSF');
          $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'PAYE');
          $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'TOTAL TAX');


        for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
              $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
          }

          $i = 6;

          foreach($empdata as $get){

            $company = $_POST['company'];
            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;
            $tinnumber = $get->tinnumber;
            $staffid = $get->staffid;

            $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
            $transport_allowance = Reports::transport_allowance($company, $department, $position, $startdate, $enddate);

            $weekday_overtime_rate = Reports::weekday_overtime_rate ($company, $department, $position, $startdate, $enddate);

            $gross = $basic_salary + $weekday_overtime_rate;
            $ssnitbasic  = $basic_salary;
            $ssnitpercent  = 0.055 * $basic_salary;
            $paye = Reports::paye($basic_id, $startdate, $enddate) ;
            $otherdeductions = Reports::otherdeductions($basic_id, $startdate, $enddate);
            $otherallowances = Reports::otherallowances($basic_id, $startdate, $enddate);
            $totaldeduction = $ssnitpercent + $paye;

            $ssnitocompany = 0.13 * $basic_salary;
            $overallgross = ($gross + $otherallowances) - $otherdeductions;
            $netsalary = $overallgross - $totaldeduction;

            $totalssf = $ssnitpercent + $ssnitocompany;


          $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $staffid);
          $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fullname);
          $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $position);
          $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $tinnumber );
          $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $weekday_overtime_rate);
          $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $otherallowances);
          $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $otherdeductions);
          $objPHPExcel->getActiveSheet()->setCellValue('H' . $i,  $overallgross);
          $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $ssnitocompany );
          $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $ssnitpercent);
          $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $totalssf);
          $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $paye);
          $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $paye);

           $i++;
       }


      $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'EMPLOYERS SCHEDULE OF MONTHLY TAX DEDUCTIONS (P.A.Y.E)');

      $imgpath = URLROOT.'/img/plogo.png';

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
      header('Content-Disposition: attachment; filename="actualpayroll.xlsx"');
      header("Pragma: no-cache");
      header("Expires: 0");

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
      exit;

   }


    public function tierexcel($startdate,$enddate, $companyid){
        $company = Companies::getCompanybyId($companyid);
        $empdata = Employee::getEmployeesByCompany($company);


        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                            ->setTitle("PHPExcel Test Document")
                            ->setSubject("PHPExcel Test Document")
                            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                            ->setKeywords("office PHPExcel php")
                            ->setCategory("Test result file");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Employee Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Employee Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Position');
        $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Tier 2 No');
        $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Basic Salary');
        $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'SSF (5.5%)');



        for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $i = 6;

        foreach($empdata as $get){

            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;
            $tinnumber = $get->tinnumber;
            $staffid = $get->staffid;
            $tiernumber = $get->tiernumber;

            $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
            $ssnit  = 0.05 * $basic_salary;


            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $staffid);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fullname);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $position);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $tiernumber );
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $basic_salary);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $ssnit);


        $i++;
    }


    $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'EMPLOYERS SCHEDULE OF MONTHLY SSF DEDUCTIONS (TIER 2)');

    $imgpath = URLROOT.'/img/plogo.png';

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
    header('Content-Disposition: attachment; filename="actualpayroll.xlsx"');
    header("Pragma: no-cache");
    header("Expires: 0");

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;

    }

    public function ssnitexcel($startdate,$enddate, $companyid){

        $company = Companies::getCompanybyId($companyid);
        $empdata = Employee::getEmployeesByCompany($company);


        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                            ->setTitle("PHPExcel Test Document")
                            ->setSubject("PHPExcel Test Document")
                            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                            ->setKeywords("office PHPExcel php")
                            ->setCategory("Test result file");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Employee Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Employee Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Position');
        $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Tier 2 No');
        $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Basic Salary');
        $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'SSF (13.5%)');



        for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $i = 6;

        foreach($empdata as $get){

            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;
            $tinnumber = $get->tinnumber;
            $staffid = $get->staffid;
            $tiernumber = $get->tiernumber;

            $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
            $ssnit  = 0.135 * $basic_salary;


            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $staffid);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fullname);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $position);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $tiernumber );
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $basic_salary);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $ssnit);


        $i++;
    }


    $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'EMPLOYERS SCHEDULE OF MONTHLY SSNIT DEDUCTIONS');

    $imgpath = URLROOT.'/img/plogo.jpg';

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
    header('Content-Disposition: attachment; filename="actualpayroll.xlsx"');
    header("Pragma: no-cache");
    header("Expires: 0");

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;

    }


    public function payslipexcel($startdate,$enddate, $employeeid){

        $empdata = Employee::getEmployeesById($employeeid);
        $payrolldata = [];
        $company =    $empdata[0]->company;
        $department =  $empdata[0]->department;
        $position  = $empdata[0]->position;
        $fullname =  $empdata[0]->fullname;
        $basic_id = $empdata[0]->basic_id;
        $tinnumber =$empdata[0]->tinnumber;
        $staffid = $empdata[0]->staffid;
        $bank = $empdata[0]->bankname;
        $branch = $empdata[0]->branch;
        $accountnumber = $empdata[0]->accountnumber;
        $ssnitnumber = $empdata[0]->ssnitnumber;
        $tiernumber = $empdata[0]->tiernumber;

        // $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
        // $transport_allowance = Reports::transport_allowance($company, $department, $position, $startdate, $enddate);
        //
        // $gross = Reports::gross($company, $department, $position, $startdate, $enddate);
        //
        // $holiday_overtime_rate =Reports::holiday_overtime_rate($company, $department, $position, $startdate, $enddate);
        // $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);
        //
        // $weekday_hourly_rate = $basic_salary / $total_full_present;
        // $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
        // $holiday_overtime_rate = $weekday_hourly_rate * 2;
        // $night_shift_allowance = $weekday_hourly_rate * 0.25;
        //
        //
        // $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);
        // $weekday_hourly_rate = $basic_salary / $total_full_present;
        // $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
        // $holiday_overtime_rate = $weekday_hourly_rate * 2;
        // $night_shift_allowance = $weekday_hourly_rate * 0.25;
        //
        // $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
        // $weekday_dayshift = $rec->weekdayshifthours;
        // $weekday_nightshift =  $rec->weekdaynightshifthours;
        // $weekday_overtime = $rec->weekdayovertimehours;
        // $holiday_weekend_overtime  = $rec->holidayovertimehours;
        // $otherallowance =   $rec->otherallowances;
        // $otherdeductions =  $rec->otherdeductions;
        //
        // $nightshiftallowance = Calculations:: nightshiftallowance($night_shift_allowance, $weekday_nightshift);
        // $holidayandweekovertimeallowance = Calculations::holidayandweekovertimeallowance($holiday_overtime_rate,$holiday_weekend_overtime);
        // $weekdayovertimeallowance = Calculations::weekdayovertimeallowance($weekday_overtime_rate,$weekday_overtime);
        // $totalovertime = Calculations::totalovertime($weekdayovertimeallowance, $holidayandweekovertimeallowance);
        // $transportactualpresent = Calculations::transportactualpresent($total_full_present, $transport_allowance, $weekday_dayshift,  $weekday_nightshift);
        // $weekdaynightshitbasic = Calculations::weekdaynightshitbasic($weekday_hourly_rate,$weekday_nightshift);
        // $weekdayshiftbasic = Calculations::weekdayshiftbasic($weekday_hourly_rate, $weekday_dayshift);
        // $totalwage = Calculations::totalwage($weekdayshiftbasic, $weekdaynightshitbasic);
        // $overallgross = Calculations::overallgross($totalwage,$transportactualpresent,$totalovertime,$otherallowance,$nightshiftallowance, $otherdeductions);
        //
        // $overtimepercent = Calculations::overtimepercent($totalwage);
        // $ssfbasic = Calculations::ssfbasic($weekdayshiftbasic, $weekdaynightshitbasic);
        // $ssfemp = Calculations::ssfemp($ssfbasic);
        //
        // $totalovertime = Calculations::totalovertime($weekdayovertimeallowance, $holidayandweekovertimeallowance);
        // $taxable = Calculations::taxable($totalwage,$overallgross,$totalovertime, $ssfemp);
        // $paye = Calculations::paye($taxable);
        // $overtimetax = Calculations::overtimetax($totalwage, $totalovertime, $overtimepercent);
        // $totaltax = Calculations::totaltax($overtimetax, $paye);
        // $totaldeduction =Calculations::totaldeduction($ssfemp, $totaltax);
        // $netpay = Calculations::netpay($overallgross, $totaldeduction);
        // $ssnitpercent  = Calculations::ssnitpercent($ssfbasic);
        // $ssnitocompany = Calculations::ssnitocompany($totalwage);
        // $totalssf = Calculations:: totalssf($ssnitpercent, $ssnitocompany);


        $fix = Position::getpositiondata($company, $department, $position);;

        $basic_salary = $fix->basic_salary;
        $transport_allowance = $fix->transport_allowance;
        $gross = $fix->gross1;
        $holiday_overtime_rate = $fix->holiday_overtime_rate;
        $total_full_present = $fix->total_full_present;


        $weekday_hourly_rate = $basic_salary / $total_full_present;
        $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
        $holiday_overtime_rate = $weekday_hourly_rate * 2;
        $night_shift_allowance = $weekday_hourly_rate * 0.25;



        $weekday_hourly_rate = $basic_salary / $total_full_present;
        $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
        $holiday_overtime_rate = $weekday_hourly_rate * 2;
        $night_shift_allowance = $weekday_hourly_rate * 0.25;

        $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
        $weekday_dayshift = $rec->weekdayshifthours;
        $weekday_nightshift =  $rec->weekdaynightshifthours;
        $weekday_overtime = $rec->weekdayovertimehours;
        $holiday_weekend_overtime  = $rec->holidayovertimehours;
        $otherallowance =   $rec->otherallowances;
        $otherdeductions =  $rec->otherdeductions;

        $nightshiftallowance = Calculations:: nightshiftallowance($night_shift_allowance, $weekday_nightshift);
        $holidayandweekovertimeallowance = Calculations::holidayandweekovertimeallowance($holiday_overtime_rate,$holiday_weekend_overtime);
        $weekdayovertimeallowance = Calculations::weekdayovertimeallowance($weekday_overtime_rate,$weekday_overtime);
        $totalovertime = Calculations::totalovertime($weekdayovertimeallowance, $holidayandweekovertimeallowance);
        $transportactualpresent = Calculations::transportactualpresent($total_full_present, $transport_allowance, $weekday_dayshift,  $weekday_nightshift);
        $weekdaynightshitbasic = Calculations::weekdaynightshitbasic($weekday_hourly_rate,$weekday_nightshift);
        $weekdayshiftbasic = Calculations::weekdayshiftbasic($weekday_hourly_rate, $weekday_dayshift);
        $totalwage = Calculations::totalwage($weekdayshiftbasic, $weekdaynightshitbasic);
        $overallgross = Calculations::overallgross($totalwage,$transportactualpresent,$totalovertime,$otherallowance,$nightshiftallowance, $otherdeductions);

        $overtimepercent = Calculations::overtimepercent($totalwage);
        $ssfbasic = Calculations::ssfbasic($weekdayshiftbasic, $weekdaynightshitbasic);
        $ssfemp = Calculations::ssfemp($ssfbasic);

        $totalovertime = Calculations::totalovertime($weekdayovertimeallowance, $holidayandweekovertimeallowance);
        $taxable = Calculations::taxable($totalwage,$overallgross,$totalovertime, $ssfemp);
        $paye = Calculations::paye($taxable);
        $overtimetax = Calculations::overtimetax($totalwage, $totalovertime, $overtimepercent);
        $totaltax = Calculations::totaltax($overtimetax, $paye);
        $totaldeduction =Calculations::totaldeduction($ssfemp, $totaltax);
        $netpay = Calculations::netpay($overallgross, $totaldeduction);
        //$ssnitbasic  = $basic_salary;
        $ssnitpercent  = Calculations::ssnitpercent($ssfbasic);
        $ssnitocompany = Calculations::ssnitocompany($totalwage);
        $totalssf = Calculations:: totalssf($ssnitpercent, $ssnitocompany);


        $objPHPExcel = new PHPExcel();
		// Set document properties
		   $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Payslip No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', '1');
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('D5', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('E5', '');
        $objPHPExcel->getActiveSheet()->SetCellValue('F5', date('Y-M') );

        for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE); }

        $objPHPExcel->getActiveSheet()->setCellValue('A6', '');
        $objPHPExcel->getActiveSheet()->setCellValue('B6', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C6', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D6', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E6', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F6', '');

        $objPHPExcel->getActiveSheet()->setCellValue('A7', '');
        $objPHPExcel->getActiveSheet()->setCellValue('B7', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C7', 'OVERTIME');
        $objPHPExcel->getActiveSheet()->setCellValue('D7', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E7', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F7', '');

        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Employee Code');
        $objPHPExcel->getActiveSheet()->setCellValue('B8',  $staffid);
        $objPHPExcel->getActiveSheet()->setCellValue('C8', 'Days');
        $objPHPExcel->getActiveSheet()->setCellValue('D8', 'Hours');
        $objPHPExcel->getActiveSheet()->setCellValue('E8', 'Rate');
        $objPHPExcel->getActiveSheet()->setCellValue('F8', 'Amount');

        $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Department');
        $objPHPExcel->getActiveSheet()->setCellValue('B9',  $department );
        $objPHPExcel->getActiveSheet()->setCellValue('C9', 'WeekDay');
        $objPHPExcel->getActiveSheet()->setCellValue('D9', $weekday_overtime);
        $objPHPExcel->getActiveSheet()->setCellValue('E9', round($weekday_overtime_rate,2) );
        $objPHPExcel->getActiveSheet()->setCellValue('F9', $weekdayovertimeallowance);


        $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Station');
        $objPHPExcel->getActiveSheet()->setCellValue('B10',  '' );
        $objPHPExcel->getActiveSheet()->setCellValue('C10', 'Holiday/Weekend');
        $objPHPExcel->getActiveSheet()->setCellValue('D10', $holiday_weekend_overtime);
        $objPHPExcel->getActiveSheet()->setCellValue('E10', round($holiday_overtime_rate, 2));
        $objPHPExcel->getActiveSheet()->setCellValue('F10', $holidayandweekovertimeallowance);

        $objPHPExcel->getActiveSheet()->setCellValue('A11', 'Name');
        $objPHPExcel->getActiveSheet()->setCellValue('B11', $fullname );
        $objPHPExcel->getActiveSheet()->setCellValue('C11', 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue('D11',   $weekday_overtime + $holiday_weekend_overtime );
        $objPHPExcel->getActiveSheet()->setCellValue('E11', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F11',   $weekdayovertimeallowance + $holidayandweekovertimeallowance);


        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'Bank');
        $objPHPExcel->getActiveSheet()->setCellValue('B12',  $bank  );
        $objPHPExcel->getActiveSheet()->setCellValue('C12', 'Officers OT');
        $objPHPExcel->getActiveSheet()->setCellValue('D12', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E12', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F12', '');


        $objPHPExcel->getActiveSheet()->setCellValue('A13', 'Branch');
        $objPHPExcel->getActiveSheet()->setCellValue('B13',  $branch   );
        $objPHPExcel->getActiveSheet()->setCellValue('C13', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D13', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E13', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F13', '');


        $objPHPExcel->getActiveSheet()->setCellValue('A14', 'Account');
        $objPHPExcel->getActiveSheet()->setCellValue('B14',   $accountnumber  );
        $objPHPExcel->getActiveSheet()->setCellValue('C14', 'No. of days/hours worked');
        $objPHPExcel->getActiveSheet()->setCellValue('D14', $weekday_dayshift);
        $objPHPExcel->getActiveSheet()->setCellValue('E14', 'Night Hours');
        $objPHPExcel->getActiveSheet()->setCellValue('F14', $weekday_nightshift);


        $objPHPExcel->getActiveSheet()->setCellValue('A15', 'SSF NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B15',  $ssnitnumber   );
        $objPHPExcel->getActiveSheet()->setCellValue('C15', 'Daily Hourly Rate');
        $objPHPExcel->getActiveSheet()->setCellValue('D15', round($weekday_hourly_rate,2) );
        $objPHPExcel->getActiveSheet()->setCellValue('E15', 'Hourly Rate');
        $objPHPExcel->getActiveSheet()->setCellValue('F15', round($weekday_hourly_rate,2) );

        $objPHPExcel->getActiveSheet()->setCellValue('A16', 'Tier 2 No');
        $objPHPExcel->getActiveSheet()->setCellValue('B16',  $tiernumber );
        $objPHPExcel->getActiveSheet()->setCellValue('C16', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D16', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E16', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F16', '');


        $objPHPExcel->getActiveSheet()->setCellValue('A17', '');
        $objPHPExcel->getActiveSheet()->setCellValue('B17', '');
        $objPHPExcel->getActiveSheet()->setCellValue('C17', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D17', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E17', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F17', '');

        $objPHPExcel->getActiveSheet()->setCellValue('A18', 'EARNINGS');
        $objPHPExcel->getActiveSheet()->setCellValue('B18', 'AMOUNT(GHC)');
        $objPHPExcel->getActiveSheet()->setCellValue('C18', 'DEDUCTIONS');
        $objPHPExcel->getActiveSheet()->setCellValue('D18', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E18', 'AMOUNT');
        $objPHPExcel->getActiveSheet()->setCellValue('F18', 'Taxable Salary (GHS)');

        $objPHPExcel->getActiveSheet()->setCellValue('A19', 'Monthly Wage');
        $objPHPExcel->getActiveSheet()->setCellValue('B19',  $basic_salary );
        $objPHPExcel->getActiveSheet()->setCellValue('C19', 'SSF Employee (5.5%)');
        $objPHPExcel->getActiveSheet()->setCellValue('D19', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E19', payround($ssnitpercent));
        $objPHPExcel->getActiveSheet()->setCellValue('F19', '');

        $objPHPExcel->getActiveSheet()->setCellValue('A20', 'Overtime');
        $objPHPExcel->getActiveSheet()->setCellValue('B20',  payround($overtime) );
        $objPHPExcel->getActiveSheet()->setCellValue('C20', 'Income Tax ');
        $objPHPExcel->getActiveSheet()->setCellValue('D20', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E20', $paye);
        $objPHPExcel->getActiveSheet()->setCellValue('F20', '');


        $objPHPExcel->getActiveSheet()->setCellValue('A21', 'Transport Allowance');
        $objPHPExcel->getActiveSheet()->setCellValue('B21',  '');
        $objPHPExcel->getActiveSheet()->setCellValue('C21', 'Overtime Tax');
        $objPHPExcel->getActiveSheet()->setCellValue('D21',  '');
        $objPHPExcel->getActiveSheet()->setCellValue('E21', payround($overtimetax));
        $objPHPExcel->getActiveSheet()->setCellValue('F21', '');

        $objPHPExcel->getActiveSheet()->setCellValue('A22', 'Night Allowance');
        $objPHPExcel->getActiveSheet()->setCellValue('B22',  '' );
        $objPHPExcel->getActiveSheet()->setCellValue('C22', 'Loan');
        $objPHPExcel->getActiveSheet()->setCellValue('D22', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E22', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F22', '');

        $objPHPExcel->getActiveSheet()->setCellValue('A23', '');
        $objPHPExcel->getActiveSheet()->setCellValue('B23',  '');
        $objPHPExcel->getActiveSheet()->setCellValue('C23', 'Other Deductions');
        $objPHPExcel->getActiveSheet()->setCellValue('D23', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E23', payround($otherdeductions));
        $objPHPExcel->getActiveSheet()->setCellValue('F23', '');

        $objPHPExcel->getActiveSheet()->setCellValue('A24', 'Gross');
        $objPHPExcel->getActiveSheet()->setCellValue('B24',  payround($overallgross));
        $objPHPExcel->getActiveSheet()->setCellValue('C24', 'Total Deductions');
        $objPHPExcel->getActiveSheet()->setCellValue('D24', payround($totaldeduction));
        $objPHPExcel->getActiveSheet()->setCellValue('E24', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F24', '');


        $objPHPExcel->getActiveSheet()->setCellValue('A25', 'Net Pay');
        $objPHPExcel->getActiveSheet()->setCellValue('B25',  payround($netpay));
        $objPHPExcel->getActiveSheet()->setCellValue('C25', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D25', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E25', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F25', '');

        $objPHPExcel->getActiveSheet()->setCellValue('A26', 'Employee Contributions');
        $objPHPExcel->getActiveSheet()->setCellValue('B26',  ''  );
        $objPHPExcel->getActiveSheet()->setCellValue('C26', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D26', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E26', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F26', '');


        $objPHPExcel->getActiveSheet()->setCellValue('A27', 'SSF Employer (15%)');
        $objPHPExcel->getActiveSheet()->setCellValue('B27',  payround($ssnitocompany));
        $objPHPExcel->getActiveSheet()->setCellValue('C27', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D27', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E27', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F27', '');


        $objPHPExcel->getActiveSheet()->setCellValue('A28', 'Total SSF');
        $objPHPExcel->getActiveSheet()->setCellValue('B28',  payround($totalssf));
        $objPHPExcel->getActiveSheet()->setCellValue('C28', '');
        $objPHPExcel->getActiveSheet()->setCellValue('D28', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E28', '');
        $objPHPExcel->getActiveSheet()->setCellValue('F28', '');

        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'EMPLOYEE PAY SLIP');

        $imgpath = URLROOT.'/img/plogo.jpg';
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
        header('Content-Disposition: attachment; filename="payslip.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }

    public function bankadvice($startdate,$enddate, $companyid){
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
           $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Employee Name');
           $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Bank');
           $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Account Number ');
           $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Sort code');
           $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Net Salary');



         for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
               $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
           }

           $i = 6;

           foreach($empdata as $get){


             $account  = $get->accountnumber;
             $branchname = $get->branch;
             $bank = $get->bankname;
             $fullname =  $get->fullname;
             $basic_id = $get->basic_id;

             $department =  $get->department;
             $position  = $get->position;
             $branchcode = Bank::getbanksortcode($bank, $branchname);

             $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
             $transport_allowance = Reports::transport_allowance($company, $department, $position, $startdate, $enddate);
             $weekday_overtime_rate = Reports::weekday_overtime_rate ($company, $department, $position, $startdate, $enddate);
             $gross = Reports::gross($company, $department, $position, $startdate, $enddate);
             $night_shift_allowance = Reports::night_shift_allowance($company, $department, $position, $startdate, $enddate);
             $weekday_hourly_rate = Reports::weekday_hourly_rate($company, $department, $position, $startdate, $enddate);
             $holiday_overtime_rate =Reports::holiday_overtime_rate($company, $department, $position, $startdate, $enddate);
             $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);

             $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
             $weekday_dayshift = $rec->weekdayshifthours;
             $weekday_nightshift =  $rec->weekdaynightshifthours;
             $weekday_overtime = $rec->weekdayovertimehours;
             $holiday_weekend_overtime  = $rec->holidayovertimehours;
             $otherallowance =   $rec->otherallowances;
             $otherdeductions =  $rec->otherdeductions;

             $nightshiftallowance = Calculations:: nightshiftallowance($night_shift_allowance, $weekday_nightshift);
             $holidayandweekovertimeallowance = Calculations::holidayandweekovertimeallowance($holiday_overtime_rate,$holiday_weekend_overtime);
             $weekdayovertimeallowance = Calculations::weekdayovertimeallowance($weekday_overtime_rate,$weekday_overtime);
             $totalovertime = Calculations::totalovertime($weekdayovertimeallowance, $holidayandweekovertimeallowance);
             $transportactualpresent = Calculations::transportactualpresent($total_full_present, $transport_allowance, $weekday_dayshift,  $weekday_nightshift);
             $weekdaynightshitbasic = Calculations::weekdaynightshitbasic($weekday_hourly_rate,$weekday_nightshift);
             $weekdayshiftbasic = Calculations::weekdayshiftbasic($weekday_hourly_rate, $weekday_dayshift);
             $totalwage = Calculations::totalwage($weekdayshiftbasic, $weekdaynightshitbasic);
             $overallgross = Calculations::overallgross($totalwage,$transportactualpresent,$totalovertime,$otherallowance,$nightshiftallowance, $otherdeductions);

             $overtimepercent = Calculations::overtimepercent($totalwage);
             $ssfbasic = Calculations::ssfbasic($weekdayshiftbasic, $weekdaynightshitbasic);
             $ssfemp = Calculations::ssfemp($ssfbasic);

             $totalovertime = Calculations::totalovertime($weekdayovertimeallowance, $holidayandweekovertimeallowance);
             $taxable = Calculations::taxable($totalwage,$overallgross,$totalovertime, $ssfemp);
             $paye = Calculations::paye($taxable);
             $overtimetax = Calculations::overtimetax($totalwage, $totalovertime, $overtimepercent);
             $totaltax = Calculations::totaltax($overtimetax, $paye);
             $totaldeduction =Calculations::totaldeduction($ssfemp, $totaltax);
             $netpay = Calculations::netpay($overallgross, $totaldeduction);

             $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fullname);
             $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $bank);
             $objPHPExcel->getActiveSheet()->setCellValue('C' . $i,	$account);
             $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $branchcode);
             $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $netpay);

             $i++;

        }


       $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'LABOUR POWER STRUCTURE');

       $imgpath = URLROOT.'/img/plogo.jpg';

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
       header('Content-Disposition: attachment; filename="bankadvice.xlsx"');
       header("Pragma: no-cache");
       header("Expires: 0");

       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
       $objWriter->save('php://output');
       exit;

    }







}



?>
