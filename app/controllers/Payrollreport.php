<?php


class Payrollreport extends Controller{


     public function mainpayroll(){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();

        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];


        if(isset($_POST['mainpayrollbtn'])){

          $startdate = $_POST['startdate'];
          $enddate = $_POST['enddate'];

          $empdata = Employee::getEmployeesByType($_POST['company']);
          // print_r($empdata);
          // exit;
          $companyid = Companies::getCompanybyName($_POST['company']);

          $payrolldata = [];

          foreach($empdata as $get){

            $company = $_POST['company'];
            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->surname.' '.$get->firstname;
            $basic_id = $get->basic_id;
            $category = $get->category;
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
$quantifiable= Vamedcalculations::quantifiablebenefits($basicsalary,$category);
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

              $employerprovidentfund  = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
              $totalprovident =  Vamedcalculations::totalprovidentfunc($basicsalary,$category);//2021


             $payrolldata[] = [
                               'company'=>$company, 'department'=>$department, 'position'=>$position, 'ssnitnumber'=>$ssnitnumber,
                                'fullname'=>$fullname,
                               'location'=>$location, 'basic_salary'=>$basicsalary, '$taxrelief'=>$taxrelief, 'salaryadvance'=>$salaryadvance ,
                               'staffwelfare'=>$staffwelfare,  'staffssnit'=>$staffssnit, 'totalincome'=>$totalincome,
                               'standardovertime'=>$standardovertime, 'teamdevelopment'=>$teamdevelopment, 'satsunholovertime'=>$satsunholovertime,
                               'transportvehiclemaintenance'=>$transportvehiclemaintenance, 'rentallowance'=>$rentallowance,
                               'grossincome'=>$grossincome, 'taxableincome'=>$taxableincome, 'paye'=>$paye,
                               'whtonstandardovertime'=>$whtonstandardovertime, 'whtonsatsunholovertime'=>$whtonsatsunholovertime,
                               'bonustax'=>$bonustax, 'totaltaxpayable'=>$totaltaxpayable, 'vamednetpay'=>$vamednetpay,
                               'vamedwelfarenetsalary'=>$vamedwelfarenetsalary, 'employerssnit'=>$employerssnit,
                               'totalssnit'=>$totalssnit, 'ssnitact'=>$ssnitact, 'secondtier'=>$secondtier, 'quantifiable'=>$quantifiable
                             ];

          }

       $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                   'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid,'company'=>$_POST['company'] ];
       $this->view('reports/mainpayroll', $alldata);
        }else{

        $this->view('reports/mainpayroll', $alldata);
        }

     }
     public function leavereport(){

      $this->view('reports/leavereport');
     }








}



?>
