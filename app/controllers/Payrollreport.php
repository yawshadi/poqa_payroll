<?php


class Payrollreport extends Controller{


     public function mainpayroll(){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();

        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];


        if(isset($_POST['mainpayrollbtn'])){

          $startdate = $_POST['startdate'];
          $enddate = $_POST['enddate'];
          $payrolltype = $_POST['payrolltype'];

          $empdata = Employee::getEmployeesByType($_POST['company'], $payrolltype);
          $companyid = Companies::getCompanybyName($_POST['company']);

          $payrolldata = [];

          foreach($empdata as $get){

            $company = $_POST['company'];
            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;
            $category = $get->category;
            $ssnitno = $get->ssnitnumber;
            $location = $get->location;
            $basic_salary = $get->basicsalary;


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
            $bonutax = Vamedcalculations::bonustax($teamdevelopment);
            $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye, $whtonstandardovertime, $whtonsatsunholovertime, $bonustax);
            $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $rentallowance,
                                               $transportvehiclemaintenance, $totaltaxpayable, $salaryadvance);
            $vamedwelfarenetsalary = Vamedcalculations::vamedwelfarenetsalary($vamednetpay, $staffwelfare);
            $employerssnit  = Vamedcalculations::employerssnit($basicsalary);
            $totalssnit =  Vamedcalculations::totalssnit($staffssnit, $employerssnit);
            $ssnitact  = Vamedcalculations::snitact($totalssnit);
            $secondtier = Vamedcalculations::econdtier($totalssnit, $ssnitact);


             $payrolldata[] = [
                              'company'=>$company, 'department'=>$department, 'position'=>$position, 'ssnitnumber'=>$ssnitnumber,
                               'location'=>$location, 'basic_salary'=>$basic_salary, '$taxrelief'=>$taxrelief, 'salaryadvance'=>$salaryadvance ,
                               'staffwelfare'=>$staffwelfare,  'staffssnit'=>$staffssnit, 'totalincome'=>$totalincome,
                               'standardovertime'=>$standardovertime, 'teamdevelopment'=>$teamdevelopment, 'satsunholovertime'=>$satsunholovertime,
                               'transportvehiclemaintenance'=>$transportvehiclemaintenance, 'rentallowance'=>$rentallowance,
                               'grossincome'=>$grossincome, 'taxableincome'=>$taxableincome, 'paye'=>$paye,
                               'whtonstandardovertime'=>$whtonstandardovertime, 'whtonsatsunholovertime'=>$whtonsatsunholovertime,
                               'bonutax'=>$bonutax, 'totaltaxpayable'=>$totaltaxpayable, 'vamednetpay'=>$vamednetpay,
                               'vamedwelfarenetsalary'=>$vamedwelfarenetsalary, 'employerssnit'=>$employerssnit,
                               'totalssnit'=>$totalssnit, 'ssnitact'=>$ssnitact, 'secondtier'=>$secondtier
                             ];

          }

       $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                   'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid, 'payrolltype'=>$payrolltype ];
       $this->view('reports/mainpayroll', $alldata);
        }else{

        $this->view('reports/mainpayroll', $alldata);
        }

     }








}



?>
