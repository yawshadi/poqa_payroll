<?php


class Payrollconfig extends Controller{


	public function fixedconfig(){

	 $posid = $_POST['posid'];
	 $pos = new Position($posid);
	 $totalfullpresent = $pos->recordObject->total_full_present;
	 $basicsalary = $pos->recordObject->basic_salary;
	 $transportallowance =  $pos->recordObject->transport_allowance;
	 $gross = $pos->recordObject->gross1;
	 $weekdayhourlyrate = $pos->recordObject->weekday_hourly_rate;
	 $weekdayovertimerate = $pos->recordObject->weekday_overtime_rate;
	 $holidayovertimerate = $pos->recordObject->holiday_overtime_rate;
	 $nightshiftallowance = $pos->recordObject->night_shift_allowance;
	 $department = $pos->recordObject->department;
	 $company = $pos->recordObject->company;
	 $position = $pos->recordObject->positionname;

	 $configdata = ['totalfullpresent'=>$totalfullpresent, 'basicsalary'=>$basicsalary, 'transportallowance'=>$transportallowance,
					 'gross'=>$gross, 'weekdayhourlyrate'=> $weekdayhourlyrate, 'weekdayovertimerate'=>$weekdayovertimerate,
					 'holidayovertimerate'=>$holidayovertimerate, 'nightshiftallowance'=>$nightshiftallowance, 'posid'=>$posid,
					  'company'=>$company, 'department'=>$department, 'position'=>$position
	                ];

	 $this->view('config/fixedconfig', $configdata);

	}


	public function updatefixedconfig(){

	    	$posid = $_POST['posid'];
        $totalfullpresent = $_POST['totalfullpresent'];
        $basicsalary = $_POST['basicsalary'];
        $transportallowance = $_POST['transportallowance'];
        $gross = $_POST['gross'];
        $weekdayhourlyrate = $_POST['weekdayhourlyrate'];
        $weekdayovertimerate = $_POST['weekdayovertimerate'];
        $holidayovertimerate = $_POST['holidayovertimerate'];
				$nightshiftallowance = $_POST['nightshiftallowance'];
				$company = $_POST['company'];
				$department = $_POST['department'];
				$position = $_POST['position'];


				$lastpayperiod = Payperiod::getLastPayperiod($_POST['company']);
				$startdate = $lastpayperiod[0]->start;
				$endate = $lastpayperiod[0]->end;


        $posdata = new Position($posid);
        $posdata->recordObject->total_full_present = $totalfullpresent;
        $posdata->recordObject->basic_salary = $basicsalary;
        $posdata->recordObject->transport_allowance =  $transportallowance;
        $posdata->recordObject->gross1 = $gross;
        $posdata->recordObject->weekday_hourly_rate = $weekdayhourlyrate ;
        $posdata->recordObject->weekday_overtime_rate = $weekdayovertimerate ;
        $posdata->recordObject->holiday_overtime_rate = $holidayovertimerate ;
        $posdata->recordObject->night_shift_allowance = $nightshiftallowance;
	      $posdata->store();

	     	$count = PayrollFixed::getFixedPayroll($company, $department, $position, $startdate, $endate);
	    	if($count == 0){
	     	$pfixed = new PayrollFixed();
        $pfixed->recordObject->total_full_present = $totalfullpresent;
        $pfixed->recordObject->basic_salary = $basicsalary;
        $pfixed->recordObject->transport_allowance =  $transportallowance;
        $pfixed->recordObject->gross = $gross;
        $pfixed->recordObject->weekday_hourly_rate = $weekdayhourlyrate ;
        $pfixed->recordObject->weekday_overtime_rate = $weekdayovertimerate ;
        $pfixed->recordObject->holiday_overtime_rate = $holidayovertimerate ;
				$pfixed->recordObject->night_shift_allowance = $nightshiftallowance;
				$pfixed->recordObject->company = $company ;
				$pfixed->recordObject->department = $department;
				$pfixed->recordObject->position = $position;
				$pfixed->recordObject->startdate = $startdate;
				$pfixed->recordObject->enddate = $endate;
				$pfixed->recordObject->positionid = $posid;
				$pfixed->store();
				}else{

				$payrollfixedid = PayrollFixed::getPayrollFixedId($company, $department, $position);
				$pfixed = new PayrollFixed($payrollfixedid);
				$pfixed->recordObject->total_full_present = $totalfullpresent;
				$pfixed->recordObject->basic_salary = $basicsalary;
				$pfixed->recordObject->transport_allowance =  $transportallowance;
				$pfixed->recordObject->gross = $gross;
				$pfixed->recordObject->weekday_hourly_rate = $weekdayhourlyrate ;
				$pfixed->recordObject->weekday_overtime_rate = $weekdayovertimerate ;
				$pfixed->recordObject->holiday_overtime_rate = $holidayovertimerate ;
				$pfixed->recordObject->night_shift_allowance = $nightshiftallowance;
				$pfixed->recordObject->company = $company ;
				$pfixed->recordObject->department = $department;
				$pfixed->recordObject->position = $position;
				$pfixed->recordObject->startdate = $startdate;
				$pfixed->recordObject->enddate = $endate;
				$pfixed->recordObject->positionid = $posid;
				$pfixed->store();

		}

	}



	public function updaterecurrent(){

		// $lastpayperiod = Payperiod::getLastPayperiod($_POST['company']);
		// $startdate = $lastpayperiod[0]->start;
		// $endate = $lastpayperiod[0]->end;

		// $count = PayrollRecurrent::getRecurrentPayroll($basic, $startdate, $endate);
        // if($count > 0){
		//}
		$recurrentid =  $_POST['recurrentid'];
		$field = $_POST['field'];
		$value = $_POST['value'];

	  $recut = new PayrollRecurrent($recurrentid);
		$recut->recordObject->$field = $value;
		$recut->store();


	}

	public function officerconfig(){

	 $posid = $_POST['posid'];
	 $pos = new Position($posid);
	 $weekdays = $pos->recordObject->weekdays;
	 $basicsalary = $pos->recordObject->officerbasic;
	 $transportallowance =  $pos->recordObject->officertransport;
	 $department = $pos->recordObject->department;
	 $company = $pos->recordObject->company;
	 $position = $pos->recordObject->positionname;

	 $configdata = ['weekdays'=>$weekdays, 'basicsalary'=>$basicsalary, 'transportallowance'=>$transportallowance,
								  'posid'=>$posid,'company'=>$company, 'department'=>$department, 'position'=>$position
								  ];

	 $this->view('config/officerconfig', $configdata);

	}

	public function updateofficerconfig(){

				$posid = $_POST['posid'];
				$basicsalary = $_POST['basicsalary'];
				$company = $_POST['company'];
				$department = $_POST['department'];
				$position = $_POST['position'];


				$lastpayperiod = Payperiod::getLastPayperiod($_POST['company']);
				$startdate = $lastpayperiod[0]->start;
				$endate = $lastpayperiod[0]->end;


				$posdata = new Position($posid);
				$posdata->recordObject->weekdays = $weekdays;
				$posdata->recordObject->officerbasic = $basicsalary;
				$posdata->recordObject->officertransport =  $transportallowance;
				$posdata->store();

				$count = PayrollFixed::getFixedPayroll($company, $department, $position, $startdate, $endate);
				if($count == 0){
				$pfixed = new PayrollFixed();
				$pfixed->recordObject->weekdays = $weekdays;
				$pfixed->recordObject->officerbasic = $basicsalary;
				$pfixed->recordObject->officertransport =  $transportallowance;
				$pfixed->recordObject->company = $company ;
				$pfixed->recordObject->department = $department;
				$pfixed->recordObject->position = $position;
				$pfixed->recordObject->startdate = $startdate;
				$pfixed->recordObject->enddate = $endate;
				$pfixed->recordObject->positionid = $posid;
				$pfixed->store();
				}else{

				$payrollfixedid = PayrollFixed::getPayrollFixedId($company, $department, $position);
				$pfixed = new PayrollFixed($payrollfixedid);
				$pfixed->recordObject->weekdays = $weekdays;
				$pfixed->recordObject->officerbasic= $basicsalary;
				$pfixed->recordObject->officertransport =  $transportallowance;
				$pfixed->recordObject->company = $company ;
				$pfixed->recordObject->department = $department;
				$pfixed->recordObject->position = $position;
				$pfixed->recordObject->startdate = $startdate;
				$pfixed->recordObject->enddate = $endate;
				$pfixed->recordObject->positionid = $posid;
				$pfixed->store();

		}

	}



}

?>
