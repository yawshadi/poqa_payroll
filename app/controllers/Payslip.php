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
            $fullname =  $get->empdata.' '.$empdata->firstname;
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
                              'totalbonus'=>$totalbonus
                            ];


             $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata, 'startdate'=>$startdate,
                          'enddate'=>$enddate, 'company'=>$company, 'name'=>$fullname, 'employeeid'=>$basic_id];
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
                          'totalbonus'=>$totalbonus, 'enddate'=>$enddate
                        ];


         $alldata =  [ 'payrolldata'=>$payrolldata];

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

        $objPHPExcel->getActiveSheet()->SetCellValue('A22', 'Transport Allowance');
        $objPHPExcel->getActiveSheet()->SetCellValue('D22', $transportvehiclemaintenance);

        $objPHPExcel->getActiveSheet()->SetCellValue('A23', 'Rent Allowance');
        $objPHPExcel->getActiveSheet()->SetCellValue('D23', $rentallowance);

        $objPHPExcel->getActiveSheet()->SetCellValue('A24', 'Gross Income');
        $objPHPExcel->getActiveSheet()->SetCellValue('D24', $grossincome);

        $objPHPExcel->getActiveSheet()->SetCellValue('A26', 'Bonuses');

        $objPHPExcel->getActiveSheet()->SetCellValue('A27', ' Standard Overtime');
        $objPHPExcel->getActiveSheet()->SetCellValue('D27', $standardovertime);

        $objPHPExcel->getActiveSheet()->SetCellValue('A28', 'Saturdays, Sundays, & Public Holidays Overtime');
        $objPHPExcel->getActiveSheet()->SetCellValue('D28', $satsunholovertime);

        $objPHPExcel->getActiveSheet()->SetCellValue('A29', 'Team Development & Weekend Bonus');
        $objPHPExcel->getActiveSheet()->SetCellValue('D29', $teamdevelopment);

        $objPHPExcel->getActiveSheet()->SetCellValue('A30', 'Total Bonus');
        $objPHPExcel->getActiveSheet()->SetCellValue('D30', $totalbonus);

        $objPHPExcel->getActiveSheet()->SetCellValue('A32', 'Deductions:');

        $objPHPExcel->getActiveSheet()->SetCellValue('A33', 'Tax Relief');
        $objPHPExcel->getActiveSheet()->SetCellValue('D33', $taxrelief);

        $objPHPExcel->getActiveSheet()->SetCellValue('A34', 'Taxable Income');
        $objPHPExcel->getActiveSheet()->SetCellValue('D34', $taxableincome);

        $objPHPExcel->getActiveSheet()->SetCellValue('A35', 'PAYE Tax Payable ');
        $objPHPExcel->getActiveSheet()->SetCellValue('D35', $paye);

        $objPHPExcel->getActiveSheet()->SetCellValue('A36', 'WHT on Overtime ');
        $objPHPExcel->getActiveSheet()->SetCellValue('D36', $whtonstandardovertime);

        $objPHPExcel->getActiveSheet()->SetCellValue('A37', 'WHT on Excess Overtime');
        $objPHPExcel->getActiveSheet()->SetCellValue('D37', $whtonsatsunholovertime);

        $objPHPExcel->getActiveSheet()->SetCellValue('A38', 'Bonus Tax');
        $objPHPExcel->getActiveSheet()->SetCellValue('D38', $bonustax);

        $objPHPExcel->getActiveSheet()->SetCellValue('A39', 'Total Tax Payable');
        $objPHPExcel->getActiveSheet()->SetCellValue('D39', $totaltaxpayable);

        $objPHPExcel->getActiveSheet()->SetCellValue('A40', 'Staff Welfare Association Contribution');
        $objPHPExcel->getActiveSheet()->SetCellValue('D40', $staffwelfare);

        $objPHPExcel->getActiveSheet()->SetCellValue('A42', 'Net Amount Payable to Staff Account');
        $objPHPExcel->getActiveSheet()->SetCellValue('D42', $vamedwelfarenetsalary);


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
