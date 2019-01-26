<?php

class Payslip extends Controller{


   public function slip($employeeid){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();
        $empdata = Employee::getEmployeesById($employeeid);
        $company = $empdata->company;
        $fullname =  $empdata->fullname;
        $alldata =  ['company'=>$company, 'payperiod'=>$paydata, 'name'=>$fullname];



        if(isset($_POST['slipbtn'])){

           $startdate = $_POST['startdate'];
           $enddate = $_POST['enddate'];

            $company =    $empdata->company;
            $department =  $empdata->department;
            $position  = $empdata->position;
            $fullname =  $empdata->fullname;
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
        $fullname =  $empdata->fullname;
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




}

 ?>
