<?php


class Payrollreport extends Controller{


     public function mainpayroll(){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();

        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];



        if(isset($_POST['mainpayrollbtn'])){

          $startdate = $_POST['startdate'];
         $enddate = $_POST['enddate'];

          $empdata = Employee::getEmployeesByCompany($_POST['company']);
          $companyid = Companies::getCompanybyName($_POST['company']);

          $payrolldata = [];

          foreach($empdata as $get){

            $company = $_POST['company'];
            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;



            $fix = Position::getpositiondata($company, $department, $position);

            print_r($fix);
            exit;

            $basic_salary = $fix->basic_salary;
            $transport_allowance = $fix->transport_allowance;
            $gross = $fix->gross1;
            $holiday_overtime_rate = $fix->holiday_overtime_rate;
            $total_full_present = $fix->total_full_present;


            // $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
            // $transport_allowance = Reports::transport_allowance($company, $department, $position, $startdate, $enddate);
            // $gross = Reports::gross($company, $department, $position, $startdate, $enddate);
            // $holiday_overtime_rate =Reports::holiday_overtime_rate($company, $department, $position, $startdate, $enddate);
            // $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);

            $weekday_hourly_rate =   $basic_salary / $total_full_present;
            $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
            $holiday_overtime_rate = $weekday_hourly_rate * 2;
            $night_shift_allowance = $weekday_hourly_rate * 0.25;


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
            $overtimetax = Calculations::overtimetax($totalwage, $totalovertime, $overtimepercent);


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





            $payrolldata[] = ['company'=>$company, 'department'=>$department, 'position'=>$position,
                              'basic_salary'=>$basic_salary, 'gross'=>$gross, 'weekday_overtime_rate'=>$weekday_overtime_rate,
                              'paye'=>$paye, 'otherdeductions'=>$otherdeductions, 'otherallowances'=>$otherallowance,
                              //'ssnitbasic'=>$ssfbasic, 'ssnitpercent'=>$ssnitpercent, 'ssnitocompany'=>$ssnitcompany,
                              //'totaldeduction'=>$totaldeduction, 'netsalary'=>$netpay, 'overallgross'=>$overallgross,
                              'fullname'=>$fullname, 'night_shift_allowance'=>$night_shift_allowance,
                              'weekday_hourly_rate'=> $weekday_hourly_rate, 'holiday_overtime_rate'=>$holiday_overtime_rate,
                              'transport_allowance'=>$transport_allowance, 'total_full_present'=>$total_full_present,
                              'weekday_dayshift'=>$weekday_dayshift, 'weekday_nightshift'=>$weekday_nightshift,
                              'weekday_overtime'=>$weekday_overtime, 'holiday_weekend_overtime'=>$holiday_weekend_overtime,
                              'weekdayshiftbasic'=>$weekdayshiftbasic, 'weekdaynightshitbasic'=>$weekdaynightshitbasic,
                              'weekdayovertimeallowance'=>$weekdayovertimeallowance, 'holidayandweekovertimeallowance'=>$holidayandweekovertimeallowance ,
                              'nightshiftallowance'=>$nightshiftallowance, 'transportactualpresent'=>$transportactualpresent,
                               'totalwage'=>$totalwage, 'overtimetax'=>$overtimetax, 'totalovertime'=> $totalovertime,
                               'overallgross'=>$overallgross, 'ssfbasic'=>$ssfbasic, 'ssfemp'=>$ssfemp, 'taxable'=>$taxable,
                               'totaltax'=>$totaltax,  'totaldeduction'=>$totaldeduction, 'netpay'=>$netpay,
                               'ssnitcompany'=>$ssnitcompany,  'totalsalarycost'=>$totalsalarycost, 'basic_id'=>$basic_id
                             ];

          }

       $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                   'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];
       $this->view('reports/mainpayroll', $alldata);
        }else{

        $this->view('reports/mainpayroll', $alldata);
        }

     }


     public function salarysheet(){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();

        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];



        if(isset($_POST['mainpayrollbtn'])){

          $startdate = $_POST['startdate'];
         $enddate = $_POST['enddate'];

          $empdata = Employee::getEmployeesByCompany($_POST['company']);
          $companyid = Companies::getCompanybyName($_POST['company']);

          $payrolldata = [];

          foreach($empdata as $get){

            $company = $_POST['company'];
            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;

            $fix = Reports::fixedpayrolldatadata($company, $department, $position);

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
             $overtimetax = Calculations::overtimetax($totalwage, $totalovertime, $overtimepercent);


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





            $payrolldata[] = ['company'=>$company, 'department'=>$department, 'position'=>$position,
                              'basic_salary'=>$basic_salary, 'gross'=>$gross, 'weekday_overtime_rate'=>$weekday_overtime_rate,
                              'paye'=>$paye, 'otherdeductions'=>$otherdeductions, 'otherallowances'=>$otherallowance,
                              //'ssnitbasic'=>$ssfbasic, 'ssnitpercent'=>$ssnitpercent, 'ssnitocompany'=>$ssnitcompany,
                              //'totaldeduction'=>$totaldeduction, 'netsalary'=>$netpay, 'overallgross'=>$overallgross,
                              'fullname'=>$fullname, 'night_shift_allowance'=>$night_shift_allowance,
                              'weekday_hourly_rate'=> $weekday_hourly_rate, 'holiday_overtime_rate'=>$holiday_overtime_rate,
                              'transport_allowance'=>$transport_allowance, 'total_full_present'=>$total_full_present,
                              'weekday_dayshift'=>$weekday_dayshift, 'weekday_nightshift'=>$weekday_nightshift,
                              'weekday_overtime'=>$weekday_overtime, 'holiday_weekend_overtime'=>$holiday_weekend_overtime,
                              'weekdayshiftbasic'=>$weekdayshiftbasic, 'weekdaynightshitbasic'=>$weekdaynightshitbasic,
                              'weekdayovertimeallowance'=>$weekdayovertimeallowance, 'holidayandweekovertimeallowance'=>$holidayandweekovertimeallowance ,
                              'nightshiftallowance'=>$nightshiftallowance, 'transportactualpresent'=>$transportactualpresent,
                               'totalwage'=>$totalwage, 'overtimetax'=>$overtimetax, 'totalovertime'=> $totalovertime,
                               'overallgross'=>$overallgross, 'ssfbasic'=>$ssfbasic, 'ssfemp'=>$ssfemp, 'taxable'=>$taxable,
                               'totaltax'=>$totaltax,  'totaldeduction'=>$totaldeduction, 'netpay'=>$netpay,
                               'ssnitcompany'=>$ssnitcompany,  'totalsalarycost'=>$totalsalarycost
                             ];

          }

       $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                   'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];
       $this->view('reports/mainpayroll', $alldata);
        }else{

        $this->view('reports/mainpayroll', $alldata);
        }

     }

     public function chargesheet(){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();

        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];



        if(isset($_POST['chargesbtn'])){

          $startdate = $_POST['startdate'];
         $enddate = $_POST['enddate'];

          $empdata = Employee::getEmployeesByCompany($_POST['company']);
          $companyid = Companies::getCompanybyName($_POST['company']);

          $payrolldata = [];

          foreach($empdata as $get){

            $company = $_POST['company'];
            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->fullname;
            $basic_id = $get->basic_id;


            // $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
            // $transport_allowance = Reports::transport_allowance($company, $department, $position, $startdate, $enddate);
            //
            // $gross = Reports::gross($company, $department, $position, $startdate, $enddate);
            //
            // $holiday_overtime_rate =Reports::holiday_overtime_rate($company, $department, $position, $startdate, $enddate);
            // $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);
            //
            //
            $fix = Reports::fixedpayrolldata($company, $department, $position);

            $basic_salary = $fix->basic_salary;
            $transport_allowance = $fix->transport_allowance;
            $gross = $fix->gross1;
            $holiday_overtime_rate = $fix->holiday_overtime_rate;
            $total_full_present = $fix->total_full_present;

            $weekday_hourly_rate = $basic_salary / $total_full_present;
            $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
            $holiday_overtime_rate = $weekday_hourly_rate * 2;
            $night_shift_allowance = $weekday_hourly_rate * 0.25;

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
             $overtimetax = Calculations::overtimetax($totalwage, $totalovertime, $overtimepercent);



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

              $actualfees = $transportactualpresent + $ssfbasic;
              $mgtcharges = $actualfees * 0.13;
              $vatmgtaxes = $mgtcharges * 0.175;
              $tocompany = $mgtcharges +  $vatmgtaxes;


            $payrolldata[] = ['company'=>$company, 'department'=>$department, 'position'=>$position,
                              'basic_salary'=>$basic_salary, 'gross'=>$gross, 'weekday_overtime_rate'=>$weekday_overtime_rate,
                              'paye'=>$paye, 'otherdeductions'=>$otherdeductions, 'otherallowances'=>$otherallowance,
                              'fullname'=>$fullname, 'night_shift_allowance'=>$night_shift_allowance,
                              'weekday_hourly_rate'=> $weekday_hourly_rate, 'holiday_overtime_rate'=>$holiday_overtime_rate,
                              'transport_allowance'=>$transport_allowance, 'total_full_present'=>$total_full_present,
                              'weekday_dayshift'=>$weekday_dayshift, 'weekday_nightshift'=>$weekday_nightshift,
                              'weekday_overtime'=>$weekday_overtime, 'holiday_weekend_overtime'=>$holiday_weekend_overtime,
                              'weekdayshiftbasic'=>$weekdayshiftbasic, 'weekdaynightshitbasic'=>$weekdaynightshitbasic,
                              'weekdayovertimeallowance'=>$weekdayovertimeallowance, 'holidayandweekovertimeallowance'=>$holidayandweekovertimeallowance ,
                              'nightshiftallowance'=>$nightshiftallowance, 'transportactualpresent'=>$transportactualpresent,
                               'totalwage'=>$totalwage, 'overtimetax'=>$overtimetax, 'totalovertime'=> $totalovertime,
                               'overallgross'=>$overallgross, 'ssfbasic'=>$ssfbasic, 'ssfemp'=>$ssfemp, 'taxable'=>$taxable,
                               'totaltax'=>$totaltax,  'totaldeduction'=>$totaldeduction, 'netpay'=>$netpay,
                               'ssnitcompany'=>$ssnitcompany,  'totalsalarycost'=>$totalsalarycost,
                               'actualfees'=>$actualfees,  'mgtcharges'=>$mgtcharges, 'vatmgtaxes'=>$vatmgtaxes,
                               'tocompany'=>$tocompany
                             ];

          }

       $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                   'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];
       $this->view('reports/chargesheet', $alldata);
        }else{

        $this->view('reports/chargesheet', $alldata);
        }

     }


     public function payereport(){

          $comdata =  Companies::getCompany();
          $paydata  = Payperiod::getPayrollPeriod();

          $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];



          if(isset($_POST['payebtn'])){

            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];

            $empdata = Employee::getEmployeesByCompany($_POST['company']);
            $companyid = Companies::getCompanybyName($_POST['company']);

            $payrolldata = [];

            foreach($empdata as $get){

              $company = $_POST['company'];
              $department =  $get->department;
              $position  = $get->position;
              $fullname =  $get->fullname;
              $basic_id = $get->basic_id;
              $tinnumber = $get->tinnumber;
              $staffid = $get->staffid;
              //
              // $basic_salary = Reports::basic_salary($company, $department, $position, $startdate, $enddate);
              // $transport_allowance = Reports::transport_allowance($company, $department, $position, $startdate, $enddate);
              //
              // $gross = Reports::gross($company, $department, $position, $startdate, $enddate);
              //
              // $holiday_overtime_rate =Reports::holiday_overtime_rate($company, $department, $position, $startdate, $enddate);
              // $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);

              $fix = Reports::fixedpayrolldata($company, $department, $position);

              $basic_salary = $fix->basic_salary;
              $transport_allowance = $fix->transport_allowance;
              $gross = $fix->gross1;
              $holiday_overtime_rate = $fix->holiday_overtime_rate;
              $total_full_present = $fix->total_full_present;


              $weekday_hourly_rate = $basic_salary / $total_full_present;
              $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
              $holiday_overtime_rate = $weekday_hourly_rate * 2;
              $night_shift_allowance = $weekday_hourly_rate * 0.25;

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


              $payrolldata[] = ['company'=>$company, 'department'=>$department, 'position'=>$position,
                                'basic_salary'=>$basic_salary, 'gross'=>$gross, 'weekday_overtime_rate'=>$weekday_overtime_rate,
                                'paye'=>$paye, 'otherdeductions'=>$otherdeductions, 'otherallowances'=>$otherallowances,
                                'ssnitbasic'=>$ssnitbasic, 'ssnitpercent'=>$ssnitpercent, 'ssnitocompany'=>$ssnitocompany,
                                'totaldeduction'=>$totaldeduction, 'netsalary'=>$netsalary, 'overallgross'=>$overallgross,
                                'fullname'=>$fullname, 'staffid'=>$staffid, 'tinnumber'=>$tinnumber, 'totalssf'=>$totalssf];

            }

          $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
           'startdate'=>$startdate, 'enddate'=>$enddate,  'companyid'=>$companyid ];

            $this->view('reports/payereport', $alldata);
          }else{

          $this->view('reports/payereport', $alldata);
          }

       }


       public function tierreport(){

                $comdata =  Companies::getCompany();
                $paydata  = Payperiod::getPayrollPeriod();

                $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];



                if(isset($_POST['tierbtn'])){

                  $startdate = $_POST['startdate'];
                  $enddate = $_POST['enddate'];

                  $empdata = Employee::getEmployeesByCompany($_POST['company']);
                  $companyid = Companies::getCompanybyName($_POST['company']);
                  $payrolldata = [];

                  foreach($empdata as $get){

                    $company = $_POST['company'];
                    $department =  $get->department;
                    $position  = $get->position;
                    $fullname =  $get->fullname;
                    $basic_id = $get->basic_id;
                    $tinnumber = $get->tinnumber;
                    $staffid = $get->staffid;
                    $tiernumber = $get->tiernumber;

                    $fix = Reports::fixedpayrolldata($company, $department, $position);

                    $basic_salary = $fix->basic_salary;
                    $transport_allowance = $fix->transport_allowance;
                    $gross = $fix->gross1;
                    $holiday_overtime_rate = $fix->holiday_overtime_rate;
                    $total_full_present = $fix->total_full_present;
                    $ssnit  = 0.05 * $basic_salary;


                    $payrolldata[] = ['company'=>$company, 'department'=>$department, 'position'=>$position,
                                      'basic_salary'=>$basic_salary, 'ssnit'=>$ssnit,'fullname'=>$fullname,
                                       'staffid'=>$staffid, 'tiernumber'=>$tiernumber];

                  }

               $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];

                  $this->view('reports/tierreport', $alldata);
                }else{

                $this->view('reports/tierreport', $alldata);
                }

       }


       public function ssnitreport(){

          $comdata =  Companies::getCompany();
          $paydata  = Payperiod::getPayrollPeriod();

          $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];



          if(isset($_POST['ssnitbtn'])){

            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];

            $empdata = Employee::getEmployeesByCompany($_POST['company']);
            $companyid = Companies::getCompanybyName($_POST['company']);

            $payrolldata = [];

            foreach($empdata as $get){

              $company = $_POST['company'];
              $department =  $get->department;
              $position  = $get->position;
              $fullname =  $get->fullname;
              $basic_id = $get->basic_id;
              $tinnumber = $get->tinnumber;
              $staffid = $get->staffid;
              $tiernumber = $get->tiernumber;

              $fix = Reports::fixedpayrolldata($company, $department, $position);

              $basic_salary = $fix->basic_salary;
              $transport_allowance = $fix->transport_allowance;
              $gross = $fix->gross1;
              $holiday_overtime_rate = $fix->holiday_overtime_rate;
              $total_full_present = $fix->total_full_present;
              $ssnit  = 0.135 * $basic_salary;


              $payrolldata[] = ['company'=>$company, 'department'=>$department, 'position'=>$position,
                                'basic_salary'=>$basic_salary, 'ssnit'=>$ssnit,'fullname'=>$fullname,
                                  'staffid'=>$staffid, 'tiernumber'=>$tiernumber];

            }

          $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                       'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];

            $this->view('reports/ssnitreport', $alldata);
          }else{

          $this->view('reports/ssnitreport', $alldata);
          }

       }

       public function branchreport(){


      if(isset($_POST['monbranchbtn'])){

          $month = $_POST['month'];
          $year = $_POST['year'];

          $startdate = $year.'-'.$month;

          $branchdata = BranchRecords::getBranchMonthlyRecordsByDate($startdate);

          $payrolldata =[];

          foreach($branchdata as $get){

          //$attendance = $get->attendance;
          $offering = $get->offering;
          $welfare = $get->welfare;
          $midweek = $get->midweek;
          $harvest = $get->harvest;
          $tithe = $get->tithe;
          $expenses = $get->expenses;
          $branchname = $get->branchname;

          $total = $offering + $welfare + $midweek + $harvest + $tithe - $expenses;

          $payrolldata[] = ['total'=>$total, 'branchname'=>$branchname];

          }

          $alldata =  ['totaldata'=>$payrolldata, 'month'=>$month, 'year'=>$year];
          $this->view('reports/branchreport', $alldata);
      }

          if(isset($_POST['branchbtn'])){

            $month = $_POST['month'];
            $year = $_POST['year'];

           $startdate = $year.'-'.$month;

           $branchdata = BranchRecords::getBranchRecordsByDate($startdate);

           $payrolldata =[];
           foreach($branchdata as $get){

            $attendance = $get->attendance;
            $offering = $get->offering;
            $welfare = $get->welfare;
            $midweek = $get->midweek;
            $harvest = $get->harvest;
            $tithe = $get->tithe;
            $expenses = $get->expenses;
            $branchname = $get->branchname;

            $total = $offering + $welfare + $midweek + $harvest + $tithe - $expenses;


            $payrolldata[] = ['total'=>$total, 'attendance'=>$attendance,
                           'offering'=>$offering, 'welfare'=>$welfare, 'midweek'=>$midweek,
                            'harvest'=>$harvest, 'tithe'=>$tithe, 'total'=>$total,
                            'branchname'=>$branchname, 'expenses'=>$expenses];

           }

           $alldata =  ['payrolldata'=>$payrolldata, 'month'=>$month, 'year'=>$year];
           $this->view('reports/branchreport', $alldata);
          }else{
          $this->view('reports/branchreport');
          }

      }


      public function bankadvice(){

        $comdata =   $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();
        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];


          if(isset($_POST['bankadvice'])){
          $startdate = $_POST['startdate'];
          $enddate = $_POST['enddate'];

          $empdata = Employee::getEmployeesByCompany($_POST['company']);
          $companyid = Companies::getCompanybyName($_POST['company']);

          $payrolldata = [];

          foreach($empdata as $get){

            $company = $_POST['company'];
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

            $gross = Reports::gross($company, $department, $position, $startdate, $enddate);

            $holiday_overtime_rate =Reports::holiday_overtime_rate($company, $department, $position, $startdate, $enddate);
            $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);

            $weekday_hourly_rate = $basic_salary / $total_full_present;
            $weekday_overtime_rate = $weekday_hourly_rate * 1.5;
            $holiday_overtime_rate = $weekday_hourly_rate * 2;
            $night_shift_allowance = $weekday_hourly_rate * 0.25;


            $total_full_present = Reports::total_full_present($company, $department, $position, $startdate, $enddate);
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

            $payrolldata[] = ['name'=> $fullname, 'accountnumber'=>$account, 'bank'=>$bank, 'branchcode'=>$branchcode, 'netpay'=> $netpay];

           }

            $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata, 'payrolldata'=>$payrolldata,
                         'companyid'=> $companyid, 'startdate'=>$startdate, 'enddate'=>$enddate];
            $this->view('reports/bankadvice', $alldata);


          }else{
              $this->view('reports/bankadvice', $alldata);
          }

      }






}



?>
