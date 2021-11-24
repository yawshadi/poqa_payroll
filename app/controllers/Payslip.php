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
            $otherbenefits = $empdata->otherbenefit;
            $jobcat = $empdata->jobcat;


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
$quantifiable= Vamedcalculations::quantifiablebenefits($basicsalary);
            $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
            $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
            $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
            $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
            $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
            $rentallowance = Vamedcalculations::rentallowance($basicsalary);
            $staffprovidentfund = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
            $grossincome = Vamedcalculations::grossincome($basicsalary, $otherbenefits, $staffssnit, $staffprovidentfund); // 2021
            $loanbenefits = Vamedcalculations::loanbenefits($loanrepayment); // 2021
              $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief,$loanbenefits,$category,$quantifiable); // 2021
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
            $secondtier = Vamedcalculations::secondtier($basicsalary, $category,$totalssnit); // 2021


            $paysliptotalpay = Vamedcalculations::paysliptotal($vamednetpay,$otherbenefits,$bonus,$loanbenefits,$totaltaxpayable,$salaryadvance,$basicsalary); // 2021

        $employerprovidentfund  = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
        $totalprovident =  Vamedcalculations::totalprovidentfunc($basicsalary,$category);//2021

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
                               'category'=>$category, 'providentfund'=> $staffprovidentfund,'jobcat'=>$jobcat,'bonus'=>$bonus,
                               'otherdeductible'=>$otherdeductible,'loanrepayment'=>$loanrepayment,'loanbenefits'=>$loanbenefits,'totalpf'=>$totalprovident,'paysliptotalpay'=>$paysliptotalpay
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
        $otherbenefits = $empdata->otherbenefit;
        $jobcat = $empdata->jobcat;

        //recurrent calculation
        $rec = Reports::getpayrollrecurrent($employeeid, $startdate, $enddate);
        $taxrelief = $rec->taxrelf;
        $salaryadvance =  $rec->salaryadvance;
        $staffwelfare = $rec->staffwelfare;
        $otherdeductible = $rec->otherdeductions;
        $bonus = $rec->bonus;
        $loanrepayment = $rec->loanrepayment;

        //payrollcalculations
        //payrollcalculations
        $staffssnit = Vamedcalculations::staffssnit($basicsalary);  
$quantifiable= Vamedcalculations::quantifiablebenefits($basicsalary);
        $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
        $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
        $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
        $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
        $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
        $rentallowance = Vamedcalculations::rentallowance($basicsalary);
        $staffprovidentfund = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
        $grossincome = Vamedcalculations::grossincome($basicsalary, $otherbenefits, $staffssnit, $staffprovidentfund); // 2021
        $loanbenefits = Vamedcalculations::loanbenefits($loanrepayment); // 2021
          $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief,$loanbenefits,$category,$quantifiable); // 2021
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
        $secondtier = Vamedcalculations::secondtier($basicsalary, $category,$totalssnit); // 2021

        $paysliptotalpay = Vamedcalculations::paysliptotal($vamednetpay,$otherbenefits,$bonus,$loanbenefits,$totaltaxpayable,$salaryadvance,$basicsalary); // 2021

    $employerprovidentfund  = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
    $totalprovident =  Vamedcalculations::totalprovidentfunc($basicsalary,$category);//2021

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
                           'category'=>$category, 'providentfund'=> $staffprovidentfund,'jobcat'=>$jobcat,'bonus'=>$bonus,
                           'otherdeductible'=>$otherdeductible,'loanrepayment'=>$loanrepayment,'loanbenefits'=>$loanbenefits,'totalpf'=>$totalprovident,'paysliptotalpay'=>$paysliptotalpay
        ];


         $alldata =  [ 'payrolldata'=>$payrolldata,'tier2'=>$empdata->tiernumber,'tier3'=>$empdata->tier3number,'startdate'=>$startdate,
         'enddate'=>$enddate,];

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
        $otherbenefits = $empdata->otherbenefit;
        $jobcat = $empdata->jobcat;

        //recurrent calculation
        $rec = Reports::getpayrollrecurrent($employeeid, $startdate, $enddate);
        $taxrelief = $rec->taxrelf;
        $salaryadvance =  $rec->salaryadvance;
        $staffwelfare = $rec->staffwelfare;
        $otherdeductible = $rec->otherdeductions;
        $bonus = $rec->bonus;
        $loanrepayment = $rec->loanrepayment;

        //payrollcalculations
        //payrollcalculations
        $staffssnit = Vamedcalculations::staffssnit($basicsalary);  
$quantifiable= Vamedcalculations::quantifiablebenefits($basicsalary);
        $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
        $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
        $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
        $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
        $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
        $rentallowance = Vamedcalculations::rentallowance($basicsalary);
        $staffprovidentfund = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
        $grossincome = Vamedcalculations::grossincome($basicsalary, $otherbenefits, $staffssnit, $staffprovidentfund); // 2021
        $loanbenefits = Vamedcalculations::loanbenefits($loanrepayment); // 2021
          $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief,$loanbenefits,$category,$quantifiable); // 2021
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
        $secondtier = Vamedcalculations::secondtier($basicsalary, $category,$totalssnit); // 2021

        
        $paysliptotalpay = Vamedcalculations::paysliptotal($vamednetpay,$otherbenefits,$bonus,$loanbenefits,$totaltaxpayable,$salaryadvance,$basicsalary); // 2021

        $employerprovidentfund  = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
        $totalprovident =  Vamedcalculations::totalprovidentfunc($basicsalary,$category);//2021
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

        $objPHPExcel->getActiveSheet()->SetCellValue('A11', 'Position');
        $objPHPExcel->getActiveSheet()->SetCellValue('B11', $position);

        $objPHPExcel->getActiveSheet()->SetCellValue('A12', 'Job Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('B12', $jobcat);

        $objPHPExcel->getActiveSheet()->SetCellValue('A13', 'Location');
        $objPHPExcel->getActiveSheet()->SetCellValue('B13', $location);

        $objPHPExcel->getActiveSheet()->SetCellValue('A14', 'Social Security');
        $objPHPExcel->getActiveSheet()->SetCellValue('B14', $ssnitnumber);

        $objPHPExcel->getActiveSheet()->SetCellValue('A16', 'BBG Details');
        $objPHPExcel->getActiveSheet()->SetCellValue('B16', $accountnumber.' - '. $branch);

        $objPHPExcel->getActiveSheet()->SetCellValue('A18', 'Tier 2 Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('B18', $empdata->tiernumber);

        $objPHPExcel->getActiveSheet()->SetCellValue('A20', 'Tier 3 Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('B20', $empdata->tier3number);

        $objPHPExcel->getActiveSheet()->SetCellValue('A22', 'Basic Calculations');
        $objPHPExcel->getActiveSheet()->SetCellValue('D22', 'Total (GH¢)');

        $objPHPExcel->getActiveSheet()->SetCellValue('A23', 'Consolidated Salary');
        $objPHPExcel->getActiveSheet()->SetCellValue('D23', $basicsalary);

        $objPHPExcel->getActiveSheet()->SetCellValue('A24', '5.5% Staff SSNIT Contribution');
        $objPHPExcel->getActiveSheet()->SetCellValue('D24', $staffssnit);

        $objPHPExcel->getActiveSheet()->SetCellValue('A25', '5% Provident Fund');
        $objPHPExcel->getActiveSheet()->SetCellValue('D25', $staffprovidentfund);

        $objPHPExcel->getActiveSheet()->SetCellValue('A26', 'Other Benefit / Allowances');
        $objPHPExcel->getActiveSheet()->SetCellValue('D26', $otherbenefits);

        

        $objPHPExcel->getActiveSheet()->SetCellValue('A27', 'Gross Salary');
        $objPHPExcel->getActiveSheet()->SetCellValue('D27', $grossincome);


        $objPHPExcel->getActiveSheet()->SetCellValue('A28', 'Monthly Loan Repayment');
        $objPHPExcel->getActiveSheet()->SetCellValue('D28', $loanrepayment);

        $objPHPExcel->getActiveSheet()->SetCellValue('A29', ' Loan Benefits');
        $objPHPExcel->getActiveSheet()->SetCellValue('D29', $loanbenefits);

        $objPHPExcel->getActiveSheet()->SetCellValue('A30', 'Tax Relief');
        $objPHPExcel->getActiveSheet()->SetCellValue('D30', $taxrelief);

        $objPHPExcel->getActiveSheet()->SetCellValue('A31',  'Taxable Income');
        $objPHPExcel->getActiveSheet()->SetCellValue('D31', $taxableincome);

        $objPHPExcel->getActiveSheet()->SetCellValue('A32', 'PAYE Tax Payable');
        $objPHPExcel->getActiveSheet()->SetCellValue('D32', $paye);

        $objPHPExcel->getActiveSheet()->SetCellValue('A33', 'Bonus');
        $objPHPExcel->getActiveSheet()->SetCellValue('D33', $bonus);

        $objPHPExcel->getActiveSheet()->SetCellValue('A34', 'Bonus Tax');
        $objPHPExcel->getActiveSheet()->SetCellValue('D34', $bonustax);

        $objPHPExcel->getActiveSheet()->SetCellValue('A35', 'Total Tax Payable');
        $objPHPExcel->getActiveSheet()->SetCellValue('D35', $totaltaxpayable);

        $objPHPExcel->getActiveSheet()->SetCellValue('A36', 'Total Cash Emoluments');
        $objPHPExcel->getActiveSheet()->SetCellValue('D36', payround($paysliptotalpay));

        $objPHPExcel->getActiveSheet()->SetCellValue('A37', 'Salary Advance');
        $objPHPExcel->getActiveSheet()->SetCellValue('D37',  $salaryadvance);

        $objPHPExcel->getActiveSheet()->SetCellValue('A38', 'Net Salary');
        $objPHPExcel->getActiveSheet()->SetCellValue('D38',  payround($vamednetpay));

        $objPHPExcel->getActiveSheet()->SetCellValue('A39', 'Staff Welfare Association Contribution');
        $objPHPExcel->getActiveSheet()->SetCellValue('D39', $staffwelfare);

        $objPHPExcel->getActiveSheet()->SetCellValue('A40', 'Other deductible');
        $objPHPExcel->getActiveSheet()->SetCellValue('D40', $otherdeductible);

        $objPHPExcel->getActiveSheet()->SetCellValue('A41', 'Amount Paid into Staff Account');
        $objPHPExcel->getActiveSheet()->SetCellValue('D41', payround($vamednetpay));

        $objPHPExcel->getActiveSheet()->SetCellValue('A42', 'Monthly Contributions');

        $objPHPExcel->getActiveSheet()->SetCellValue('A43', 'Tier 1 - SSF @ 13.5%');
        $objPHPExcel->getActiveSheet()->SetCellValue('D43', $ssnitact);

        $objPHPExcel->getActiveSheet()->SetCellValue('A44', 'Tier 2 - OPS @ 5%');
        $objPHPExcel->getActiveSheet()->SetCellValue('D44', $secondtier);

        $objPHPExcel->getActiveSheet()->SetCellValue('A45', 'Tier 3 - PF @ 10% ');
        $objPHPExcel->getActiveSheet()->SetCellValue('D45', $totalprovident);



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
