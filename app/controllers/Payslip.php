<?php

class Payslip extends Controller{


   public function slip($employeeid){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();
        $empdata = Employee::getEmployeesById($employeeid);
        $company = $empdata->company;
        $fullname =  $empdata->surname.' '.$empdata->firstname;
        $alldata =  ['company'=>$company, 'payperiod'=>$paydata, 'name'=>$fullname];



        if(isset($_POST['slipbtn'])){

           $startdate = $_POST['startdate'];
           $enddate = $_POST['enddate'];

            $company =    $empdata->company;
            $department =  $empdata->department;
            $position  = $empdata->position;
            $fullname =  $empdata->surname.' '.$empdata->firstname;
            $basic_id = $empdata->basic_id;
            $tinnumber =$empdata->tinnumber;
            $staffid = $empdata->staffid;
            $bank = $empdata->bankname;
            $branch = $empdata->branch;
            $accountnumber = $empdata->accountnumber;
            $ssnitnumber = $empdata->ssnitnumber;
            $tiernumber = $empdata->tiernumber;
            $basicsalary = $empdata->basicsalary;
            $category = $empdata->category;
            $location = $empdata->location;

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
            $staffprovidentfund = Vamedcalculations::employeeprovidentfund($basicsalary);
            $grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit, $staffprovidentfund);
            $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief);
            $paye =  Vamedcalculations::paye($taxableincome);
            $whtonstandardovertime = Vamedcalculations::whtonstandardovertime($standardovertime);
            $whtonsatsunholovertime =  Vamedcalculations::whtonsatsunholovertime($satsunholovertime);
            $bonustax = Vamedcalculations::bonustax($teamdevelopment);
            $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye, $whtonstandardovertime, $whtonsatsunholovertime, $bonustax);
            //$vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $totaltaxpayable, $salaryadvance);
            $otherbenefits = $rec->otherbenefits;
            $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $totaltaxpayable, $salaryadvance, $otherbenefits);
            $vamedwelfarenetsalary = Vamedcalculations::vamedwelfarenetsalary($vamednetpay, $staffwelfare);
            $employerssnit  = Vamedcalculations::employerssnit($basicsalary);
            $totalssnit =  Vamedcalculations::totalssnit($staffssnit, $employerssnit);
            $ssnitact  = Vamedcalculations::ssnitact($totalssnit);
            $secondtier = Vamedcalculations::secondtier($totalssnit, $ssnitact);

            $totalbonus = Vamedcalculations::totalbonus($standardovertime, $teamdevelopment, $satsunholovertime);
            $tier3  =  Vamedcalculations::staffprovidentfund($basicsalary);

            $payrolldata = [
                              'company'=>$company, 'department'=>$department, 'position'=>$position, 'ssnitnumber'=>$ssnitnumber,
                              'fullname'=>$fullname, 'bankname'=>$bank, 'accountnumber'=>$accountnumber, 'branch'=>$branch,
                              'location'=>$location, 'basic_salary'=>$basicsalary, 'taxrelief'=>$taxrelief, 'salaryadvance'=>$salaryadvance ,
                              'staffwelfare'=>$staffwelfare,  'staffssnit'=>$staffssnit, 'totalincome'=>$totalincome,
                              'standardovertime'=>$standardovertime, 'teamdevelopment'=>$teamdevelopment, 'satsunholovertime'=>$satsunholovertime,
                              'transportvehiclemaintenance'=>$transportvehiclemaintenance, 'rentallowance'=>$rentallowance,
                              'grossincome'=>$grossincome, 'taxableincome'=>$taxableincome, 'paye'=>$paye,
                              'whtonstandardovertime'=>$whtonstandardovertime, 'whtonsatsunholovertime'=>$whtonsatsunholovertime,
                              'bonustax'=>$bonustax, 'totaltaxpayable'=>$totaltaxpayable, 'vamednetpay'=>$vamednetpay,
                              'vamedwelfarenetsalary'=>$vamedwelfarenetsalary, 'employerssnit'=>$employerssnit,
                              'totalssnit'=>$totalssnit, 'ssnitact'=>$ssnitact, 'secondtier'=>$secondtier,
                              'totalbonus'=>$totalbonus,  'otherbenefits'=>$otherbenefits, 'tier3'=>$tier3,
                               'category'=>$category, 'providentfund'=> $staffprovidentfund
            ];


             $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata, 'startdate'=>$startdate,
                          'enddate'=>$enddate, 'company'=>$company, 'name'=>$fullname, 'employeeid'=>$basic_id,'tier2'=>$empdata->tiernumber,'tier3'=>$empdata->tier3number];
             $this->view('reports/payslip', $alldata);
        }else{

        $this->view('reports/payslip', $alldata);
        }

   }


   public function slipdf($startdate, $enddate, $employeeid){


        $empdata = Employee::getEmployeesById($employeeid);



        $company =    $empdata->company;
        $department =  $empdata->department;
        $position  = $empdata->position;
        $fullname =  $empdata->surname.' '.$empdata->firstname;
        $basic_id = $empdata->basic_id;
        $tinnumber =$empdata->tinnumber;
        $staffid = $empdata->staffid;
        $bank = $empdata->bankname;
        $branch = $empdata->branch;
        $accountnumber = $empdata->accountnumber;
        $ssnitnumber = $empdata->ssnitnumber;
        $tiernumber = $empdata->tiernumber;
        $basicsalary = $empdata->basicsalary;
        $category = $empdata->category;
        $location = $empdata->location;

        //recurrent calculation
        $rec = Reports::getpayrollrecurrent($employeeid, $startdate, $enddate);
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
        $staffprovidentfund = Vamedcalculations::employeeprovidentfund($basicsalary);
        $grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit, $staffprovidentfund);
        //$grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit);
        $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief);
        $paye =  Vamedcalculations::paye($taxableincome);
        $whtonstandardovertime = Vamedcalculations::whtonstandardovertime($standardovertime);
        $whtonsatsunholovertime =  Vamedcalculations::whtonsatsunholovertime($satsunholovertime);
        $bonustax = Vamedcalculations::bonustax($teamdevelopment);
        $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye, $whtonstandardovertime, $whtonsatsunholovertime, $bonustax);
        $otherbenefits = $rec->otherbenefits;
        $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $totaltaxpayable, $salaryadvance, $otherbenefits);
        //$vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $totaltaxpayable, $salaryadvance);
        $vamedwelfarenetsalary = Vamedcalculations::vamedwelfarenetsalary($vamednetpay, $staffwelfare);
        $employerssnit  = Vamedcalculations::employerssnit($basicsalary);
        $totalssnit =  Vamedcalculations::totalssnit($staffssnit, $employerssnit);
        $ssnitact  = Vamedcalculations::ssnitact($totalssnit);
        $secondtier = Vamedcalculations::secondtier($totalssnit, $ssnitact);
        $tier3  =  Vamedcalculations::staffprovidentfund($basicsalary);

        $totalbonus = Vamedcalculations::totalbonus($standardovertime, $teamdevelopment, $satsunholovertime);

        $payrolldata = [
                          'company'=>$company, 'department'=>$department, 'position'=>$position, 'ssnitnumber'=>$ssnitnumber,
                          'fullname'=>$fullname, 'bankname'=>$bank, 'accountnumber'=>$accountnumber, 'branch'=>$branch,
                          'location'=>$location, 'basic_salary'=>$basicsalary, 'taxrelief'=>$taxrelief, 'salaryadvance'=>$salaryadvance ,
                          'staffwelfare'=>$staffwelfare,  'staffssnit'=>$staffssnit, 'totalincome'=>$totalincome,
                          'standardovertime'=>$standardovertime, 'teamdevelopment'=>$teamdevelopment, 'satsunholovertime'=>$satsunholovertime,
                          'transportvehiclemaintenance'=>$transportvehiclemaintenance, 'rentallowance'=>$rentallowance,
                          'grossincome'=>$grossincome, 'taxableincome'=>$taxableincome, 'paye'=>$paye,
                          'whtonstandardovertime'=>$whtonstandardovertime, 'whtonsatsunholovertime'=>$whtonsatsunholovertime,
                          'bonustax'=>$bonustax, 'totaltaxpayable'=>$totaltaxpayable, 'vamednetpay'=>$vamednetpay,
                          'vamedwelfarenetsalary'=>$vamedwelfarenetsalary, 'employerssnit'=>$employerssnit,
                          'totalssnit'=>$totalssnit, 'ssnitact'=>$ssnitact, 'secondtier'=>$secondtier,
                          'totalbonus'=>$totalbonus, 'enddate'=>$enddate, 'otherbenefits'=>$otherbenefits,
                           'tier3'=>$tier3, 'category'=>$category, 'providentfund'=>$staffprovidentfund
                        ];


         $alldata =  [ 'payrolldata'=>$payrolldata,'tier2'=>$empdata->tiernumber,'tier3'=>$empdata->tier3number];

         $this->view('reports/slipdf', $alldata);


   }

    public function slipexcel($startdate, $enddate, $employeeid){


        $empdata = Employee::getEmployeesById($employeeid);

        $company =    $empdata->company;
        $department =  $empdata->department;
        $position  = $empdata->position;
        $fullname =  $empdata->surname.' '.$empdata->firstname;
        $basic_id = $empdata->basic_id;
        $tinnumber =$empdata->tinnumber;
        $staffid = $empdata->staffid;
        $bank = $empdata->bankname;
        $branch = $empdata->branch;
        $accountnumber = $empdata->accountnumber;
        $ssnitnumber = $empdata->ssnitnumber;
        $tiernumber = $empdata->tiernumber;
        $basicsalary = $empdata->basicsalary;
        $category = $empdata->category;
        $location = $empdata->location;

        //recurrent calculation
        $rec = Reports::getpayrollrecurrent($employeeid, $startdate, $enddate);
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
        $staffprovidentfund = Vamedcalculations::employeeprovidentfund($basicsalary);
        $grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit, $staffprovidentfund);
        //$grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit);
        $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief);
        $paye =  Vamedcalculations::paye($taxableincome);
        $whtonstandardovertime = Vamedcalculations::whtonstandardovertime($standardovertime);
        $whtonsatsunholovertime =  Vamedcalculations::whtonsatsunholovertime($satsunholovertime);
        $bonustax = Vamedcalculations::bonustax($teamdevelopment);
        $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye, $whtonstandardovertime, $whtonsatsunholovertime, $bonustax);
        $otherbenefits = $rec->otherbenefits;
        $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $totaltaxpayable, $salaryadvance, $otherbenefits);
        //$vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $totaltaxpayable, $salaryadvance);
        $vamedwelfarenetsalary = Vamedcalculations::vamedwelfarenetsalary($vamednetpay, $staffwelfare);
        $employerssnit  = Vamedcalculations::employerssnit($basicsalary);
        $totalssnit =  Vamedcalculations::totalssnit($staffssnit, $employerssnit);
        $ssnitact  = Vamedcalculations::ssnitact($totalssnit);
        $secondtier = Vamedcalculations::secondtier($totalssnit, $ssnitact);
        $tier3  =  Vamedcalculations::staffprovidentfund($basicsalary);

        $totalbonus = Vamedcalculations::totalbonus($standardovertime, $teamdevelopment, $satsunholovertime);

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("PHPExcel Test Document")
            ->setSubject("PHPExcel Test Document")
            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
            ->setKeywords("office PHPExcel php")
            ->setCategory("Test result file");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'VAMED ENGINEERING GmbH');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Ghana Branch Office');

        $objPHPExcel->getActiveSheet()->SetCellValue('D7', date('d-M', strtotime($enddate)));
        $objPHPExcel->getActiveSheet()->SetCellValue('B8', 'PAYSLIP');

        $objPHPExcel->getActiveSheet()->SetCellValue('A10', 'Name of Employee');
        $objPHPExcel->getActiveSheet()->SetCellValue('B10',  $fullname);

        $objPHPExcel->getActiveSheet()->SetCellValue('A12', 'Position');
        $objPHPExcel->getActiveSheet()->SetCellValue('B12', $position);

        $objPHPExcel->getActiveSheet()->SetCellValue('A14', 'Social Security');
        $objPHPExcel->getActiveSheet()->SetCellValue('B14', $ssnitnumber);

        $objPHPExcel->getActiveSheet()->SetCellValue('A16', 'BBG Details');
        $objPHPExcel->getActiveSheet()->SetCellValue('B16', $accountnumber.' - '. $branch);

        $objPHPExcel->getActiveSheet()->SetCellValue('A18', 'Basic Calculations');
        $objPHPExcel->getActiveSheet()->SetCellValue('D18', 'Total (GH¢)');

        $objPHPExcel->getActiveSheet()->SetCellValue('A19', 'Income:');

        $objPHPExcel->getActiveSheet()->SetCellValue('A20', 'Basic Salary');
        $objPHPExcel->getActiveSheet()->SetCellValue('D20', $basicsalary);

        $objPHPExcel->getActiveSheet()->SetCellValue('A21', '5.5% Staff SSNIT Contribution');
        $objPHPExcel->getActiveSheet()->SetCellValue('D21', $staffssnit);

        $objPHPExcel->getActiveSheet()->SetCellValue('A22', '5% Provident Fund');
        $objPHPExcel->getActiveSheet()->SetCellValue('D22', $staffprovidentfund);

        $objPHPExcel->getActiveSheet()->SetCellValue('A23', 'Transport Allowance');
        $objPHPExcel->getActiveSheet()->SetCellValue('D23', $transportvehiclemaintenance);

        $objPHPExcel->getActiveSheet()->SetCellValue('A24', 'Rent Allowance');
        $objPHPExcel->getActiveSheet()->SetCellValue('D24', $rentallowance);

        $objPHPExcel->getActiveSheet()->SetCellValue('A25', 'Gross Income');
        $objPHPExcel->getActiveSheet()->SetCellValue('D25', $grossincome);

        $objPHPExcel->getActiveSheet()->SetCellValue('A27', 'Bonuses');

        $objPHPExcel->getActiveSheet()->SetCellValue('A28', ' Standard Overtime');
        $objPHPExcel->getActiveSheet()->SetCellValue('D28', $standardovertime);

        $objPHPExcel->getActiveSheet()->SetCellValue('A29', 'Saturdays, Sundays, & Public Holidays Overtime');
        $objPHPExcel->getActiveSheet()->SetCellValue('D29', $satsunholovertime);

        $objPHPExcel->getActiveSheet()->SetCellValue('A30',  teamdev($category). ' Team Development Bonus');
        $objPHPExcel->getActiveSheet()->SetCellValue('D30', $teamdevelopment);

        $objPHPExcel->getActiveSheet()->SetCellValue('A31', 'Total Bonus');
        $objPHPExcel->getActiveSheet()->SetCellValue('D31', $totalbonus);

        $objPHPExcel->getActiveSheet()->SetCellValue('A33', 'Deductions:');

        $objPHPExcel->getActiveSheet()->SetCellValue('A34', 'Tax Relief');
        $objPHPExcel->getActiveSheet()->SetCellValue('D34', $taxrelief);

        $objPHPExcel->getActiveSheet()->SetCellValue('A35', 'Taxable Income');
        $objPHPExcel->getActiveSheet()->SetCellValue('D35', $taxableincome);

        $objPHPExcel->getActiveSheet()->SetCellValue('A36', 'PAYE Tax Payable ');
        $objPHPExcel->getActiveSheet()->SetCellValue('D36', $paye);

        $objPHPExcel->getActiveSheet()->SetCellValue('A37', 'WHT on Overtime ');
        $objPHPExcel->getActiveSheet()->SetCellValue('D37', $whtonstandardovertime);

        $objPHPExcel->getActiveSheet()->SetCellValue('A38', 'WHT on Excess Overtime');
        $objPHPExcel->getActiveSheet()->SetCellValue('D38', $whtonsatsunholovertime);

        $objPHPExcel->getActiveSheet()->SetCellValue('A39', 'Bonus Tax');
        $objPHPExcel->getActiveSheet()->SetCellValue('D39', $bonustax);

        $objPHPExcel->getActiveSheet()->SetCellValue('A40', 'Total Tax Payable');
        $objPHPExcel->getActiveSheet()->SetCellValue('D40', $totaltaxpayable);

        $objPHPExcel->getActiveSheet()->SetCellValue('A41', 'Staff Welfare Association Contribution');
        $objPHPExcel->getActiveSheet()->SetCellValue('D41', $staffwelfare);

        $objPHPExcel->getActiveSheet()->SetCellValue('A42', 'Other Benefits');
        $objPHPExcel->getActiveSheet()->SetCellValue('D42',  $otherbenefits);

        $objPHPExcel->getActiveSheet()->SetCellValue('A43', 'Salary Advance');
        $objPHPExcel->getActiveSheet()->SetCellValue('D43',  $salaryadvance);

        $objPHPExcel->getActiveSheet()->SetCellValue('A45', 'Net Amount Payable to Staff Account');
        $objPHPExcel->getActiveSheet()->SetCellValue('D45', $vamedwelfarenetsalary);

        $objPHPExcel->getActiveSheet()->SetCellValue('A47', 'Monthly Contributions');

        $objPHPExcel->getActiveSheet()->SetCellValue('A48', 'Tier 1');
        $objPHPExcel->getActiveSheet()->SetCellValue('D48', $staffssnit);

        $objPHPExcel->getActiveSheet()->SetCellValue('A49', 'Tier 2');
        $objPHPExcel->getActiveSheet()->SetCellValue('D49', $secondtier);

        $objPHPExcel->getActiveSheet()->SetCellValue('A50', 'Tier 3');
        $objPHPExcel->getActiveSheet()->SetCellValue('D50', $tier3);



        $imgpath = URLROOT.'/img/vamed.jpg';
        $gdImage = imagecreatefromjpeg($imgpath);

        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(80);
        $objDrawing->setCoordinates('D1');
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




}

 ?>
