<?php

  include('settings.php');

  Class Sendpayslipemail
  {

      public function storeDataForCron()
      {

          $crondates = Payperiod::getcronperiod();
          $startdate = $crondates->start;
          $enddate = $crondates->end;

          $listforpayroll = PayrollRecurrent::getlistforcron($startdate, $enddate);

          foreach ($listforpayroll as $get) {
              $basicid = $get->basic_id;
              $nationality = Employee::getnationality($basicid);
              $count  =  Cronpayslip::getcount($basicid, $startdate, $enddate);
              if($nationality == 'Ghanaian') {
                  if ($count == 0) {
                      $cj = new Cronpayslip();
                      $cj->recordObject->basicid = $basicid;
                      $cj->recordObject->paystart = $startdate;
                      $cj->recordObject->payend = $enddate;
                      $cj->recordObject->status = 0;
                      $cj->store();
                  }
              }
          }

          $data = ['startdate'=>$startdate, 'enddate'=>$enddate ];

          return $data;

      }


      public function getDataToProcess(){

          $crondates =  $this->storeDataForCron();
          $startdate = $crondates['startdate'];
          $enddate = $crondates['enddate'];
          $dataToprocess = Cronpayslip::getcrondataToprocess($startdate, $enddate);

          if(isset($dataToprocess)) {

              foreach ($dataToprocess as $get) {

                  $basicid = $get->basicid;

                  $empdata = Employee::getEmployeesById($basicid);

                  $company = $empdata->company;
                  $department = $empdata->department;
                  $position = $empdata->position;
                  $fullname = $empdata->fullname;
                  $basic_id = $empdata->basic_id;
                  $tinnumber = $empdata->tinnumber;
                  $staffid = $empdata->staffid;
                  $bank = $empdata->bankname;
                  $branch = $empdata->branch;
                  $accountnumber = $empdata->accountnumber;
                  $ssnitnumber = $empdata->ssnitnumber;
                  $tiernumber = $empdata->tiernumber;
                  $basicsalary = $empdata->basicsalary;
                  $category = $empdata->category;
                  $location = $empdata->location;
                  $email = $empdata->email;

                  //recurrent calculation
                  $rec = Reports::getpayrollrecurrent($basicid, $startdate, $enddate);
                  $taxrelief = $rec->taxrelf;
                  $salaryadvance = $rec->salaryadvance;
                  $staffwelfare = $rec->staffwelfare;

                  //payrollcalculations
                  $staffssnit = Vamedcalculations::staffssnit($basicsalary);
                  $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
                  $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
                  $teamdevelopment = Vamedcalculations::teamdevelopment($basicsalary, $category);
                  $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
                  $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
                  $rentallowance = Vamedcalculations::rentallowance($basicsalary);
                  $grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit);
                  $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief);
                  $paye = Vamedcalculations::paye($taxableincome);
                  $whtonstandardovertime = Vamedcalculations::whtonstandardovertime($standardovertime);
                  $whtonsatsunholovertime = Vamedcalculations::whtonsatsunholovertime($satsunholovertime);
                  $bonustax = Vamedcalculations::bonustax($teamdevelopment);
                  $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye, $whtonstandardovertime, $whtonsatsunholovertime, $bonustax);
                  $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $totaltaxpayable, $salaryadvance);
                  $vamedwelfarenetsalary = Vamedcalculations::vamedwelfarenetsalary($vamednetpay, $staffwelfare);
                  $employerssnit = Vamedcalculations::employerssnit($basicsalary);
                  $totalssnit = Vamedcalculations::totalssnit($staffssnit, $employerssnit);
                  $ssnitact = Vamedcalculations::ssnitact($totalssnit);
                  $secondtier = Vamedcalculations::secondtier($totalssnit, $ssnitact);

                  $totalbonus = Vamedcalculations::totalbonus($standardovertime, $teamdevelopment, $satsunholovertime);

                  $message = preparepaysliphtml($enddate, $fullname, $position, $ssnitnumber, $accountnumber, $branch,
                      $basicsalary, $staffssnit, $transportvehiclemaintenance, $rentallowance,
                      $grossincome, $standardovertime, $teamdevelopment,
                      $satsunholovertime, $totalbonus, $taxrelief, $taxableincome, $paye,
                      $whtonstandardovertime, $whtonsatsunholovertime, $bonustax, $totaltaxpayable,
                      $staffwelfare, $vamedwelfarenetsalary);


                  // Send Email
                  if($email != '') {
                      $emailstatus = sendEmail(SENDEREMAIL, $email, 'Payslip', $message, COMPANYNAME);
                      //return $emailstatus;
                      //Cronpayslip::updateStatus($basicid, $startdate, $enddate);
                  }

                  // update status of cron
                  Cronpayslip::updateStatus($basicid, $startdate, $enddate);

              }
          }

      }
 }





?>
