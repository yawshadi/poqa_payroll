<?php

class Calculations{

  public static function overallgross($totalwage,$transportactualpresent,$totalovertime,$otherallowance,$nightshiftallowance, $otherdeductions){
      $overallgross = ($totalwage + $transportactualpresent + $totalovertime + $otherallowance + $nightshiftallowance) - $otherdeductions;
      return round($overallgross, 2);
  }

  public static function taxable($totalwage, $overallgross,$totalovertime, $ssfemp){

    if($totalwage <= 1500 ){
      $taxable = $overallgross - $ssfemp - $totalovertime;
        return round($taxable , 2);
    }else if($totalwage > 1500 ){
        $taxable = $overallgross - $ssfemp;
        return round($taxable , 2);
    }else{
      return $taxable = 0;
    }

  }

  public static function paye($taxable){

    if($taxable < 261){
       return $paye = 0;
     }elseif($taxable > 261 && $taxable<=330){
       $paye = ($taxable - 261) * 0.05;
       return  round($paye , 2);
     }elseif($taxable > 331 && $taxable <= 430){
        $paye = (($taxable - 331) * 0.10) + 3.5;
        return  round($paye , 2);
     }elseif($taxable > 431 && $taxable <= 3240){
         $paye = (($taxable - 431) * 0.175) + 13.5;
         return  round($paye , 2);
     }elseif($taxable > 3241){
       $paye = (($taxable - 3241) * 0.25) + 505.25;
       return  round($paye , 2);
     }else{
      return $paye = 0;
     }
  }

  public static function weekdayshiftbasic($weekday_hourly_rate, $weekday_dayshift){
   return round($weekday_hourly_rate * $weekday_dayshift, 2);
  }

  public static function   weekdaynightshitbasic($weekday_hourly_rate,$weekday_nightshift){
   return round($weekday_hourly_rate * $weekday_nightshift, 2);
  }

  public static function   weekdayovertimeallowance($weekday_overtime_rate,$weekday_overtime){
   return round($weekday_overtime_rate  * $weekday_overtime, 2);
  }

  public static function  holidayandweekovertimeallowance($holiday_overtime_rate,$holiday_weekend_overtime){
   return  round($holiday_overtime_rate  * $holiday_weekend_overtime, 2);
  }

  public static function  nightshiftallowance($night_shift_allowance, $weekday_nightshift){
   return  round($night_shift_allowance   * $weekday_nightshift, 2);
  }


  public static function  transportactualpresent($total_full_present, $transport_allowance, $weekday_dayshift,  $weekday_nightshift){
    if($total_full_present == 0 ||  $total_full_present == '' ){
    return $transportactualpresent = 0;
    }else{
    $transportactualpresent = ($transport_allowance / $total_full_present) * ($weekday_dayshift + $weekday_nightshift);
    return round($transportactualpresent, 2);
    }
  }

  public static function totalwage($weekdayshiftbasic, $weekdaynightshitbasic){
    return round($weekdayshiftbasic + $weekdaynightshitbasic, 2);
  }

  public static function totalovertime($weekdayovertimeallowance, $holidayandweekovertimeallowance){
    return round($weekdayovertimeallowance + $holidayandweekovertimeallowance, 2);
  }

  public static function overtimetax($totalwage, $totalovertime, $overtimepercent){
    if($totalwage <= 1500 ){
      $dummy = 0.5 * $totalwage;
      if($totalovertime <= $dummy){
        return $overtimetax = $totalovertime * 0.05;
      }else{
        $overtimetax = ($totalwage * 0.5) * 0.05 + ($totalovertime- $totalwage * 0.5) * 0.10;
        return $overtimetax;
        }

    }
    else if($totalwage > 1500 && $totalovertime > $overtimepercent){
      $dummyamount = $totalwage * 0.5;
      return $overtimetax = ($dummyamount * 0.05) + (($totalovertime - $dummyamount) * 0.10);
     }

     else if($totalwage > 1500 && $totalovertime <= $overtimepercent){
     return $overtimetax = $totalovertime * 0.05;
     }
  }

  public static function overtimepercent($totalwage){
     $overtimepercent = 0.5 * $totalwage;
     return round($overtimepercent, 2);
  }

  public static function totaltax($overtimetax, $paye){
      $totaltax =   $overtimetax + $paye;
      return round($totaltax,2);

  }

  public static function totaldeduction($ssfemp, $totaltax){
    return  round($ssfemp + $totaltax, 2);
  }

  public static function netpay($overallgross, $totaldeduction){
    return round($overallgross -$totaldeduction, 2);
  }

  public static function ssnitocompany($totalwage){
    return $totalwage * 0.13;
  }

  public static function totalsalarycost($overallgross,$ssnitcompany){
    return $overallgross + $ssnitcompany;
  }

  public static function ssfbasic($weekdayshiftbasic, $weekdaynightshitbasic){
     return $weekdayshiftbasic + $weekdaynightshitbasic;
  }

  public static function ssfemp($ssfbasic){
     return $ssfbasic * 0.055;
  }

  public static function actualfees($transportactualpresent,$ssfbasic){
     return  $transportactualpresent + $ssfbasic;
  }

  public static function managementcharges($actualfees){
     return  $actualfees * 0.13;
  }

  public static function vatcharges($mgtcharges){
     return   $mgtcharges * 0.175;
  }

  public static function chargesheettocompany($mgtcharges, $vatmgtaxes){
     return  $mgtcharges + $vatmgtaxes;
  }

  public static function ssnitpercent($ssfbasic){
    return $ssfbasic * 0.13;
  }

  public static function totalssf($ssnitpercent, $ssnitocompany){
    return $ssnitpercent + $ssnitocompany;
  }

  public static function salarytocompany($overallgross,$ssnitpercent){
     return number_format($overallgross + $ssnitpercent, 2);
  }

  // officer Payroll Calculations

  public static function fixovertime($officerbasic){
    return number_format($officerbasic * 0.15, 2);
  }

  public static function weekdaypresentsalary($officerbasic, $officertransport, $fixovertime){
    return number_format($officerbasic + $officertransport + $fixovertime, 2);
  }

  public static function weekdaydailyrate($officerbasic, $weekdays){
    return number_format($officerbasic / $weekdays, 2);
  }

  public static function weekendrate($weekdaydailyrate){
    return number_format($weekdaydailyrate * 2, 2);
  }

  public static function holidayrate($weekdaydailyrate){
    return number_format($weekdaydailyrate * 2, 2);
  }


  public static function weekdaysalary($weekdaypresentdays, $weekdaydailyrate){
    return number_format($weekdaydailyrate * $weekdaypresentdays, 2);
  }

  public static function saturdaysalary($saturdaypresentdays, $weekendrate){
    return number_format($saturdaypresentdays * $weekendrate, 2);
  }

  public static function sundaysalary($sundaypresentdays, $weekendrate){
    return number_format($sundaypresentdays * $weekendrate, 2);
  }

  public static function holidaysalary($holidaypresentdays, $holidayrate){
    return number_format($holidaypresentdays * $holidayrate, 2);
  }

  public static function officertandtpresent($officertransport, $weekdays, $weekdaypresentdays){
      $offtt = ($officertransport / $weekdays) * $weekdaypresentdays;
     return number_format($offtt, 2);
  }

  public static function fixedovertimepresent($fixovertime, $weekdays, $weekdaypresentdays){
      $offtt = ($fixovertime / $weekdays) * $weekdaypresentdays;
      return number_format($offtt, 2);
  }

  public static function officertotalovertime($saturdaysalary, $sundaysalary, $holidaysalary, $fixedovertimesalary){
     return number_format($saturdaysalary + $sundaysalary  + $holidaysalary + $fixedovertimesalary, 2);
  }

  public static function officergross($weekdaysalary, $saturdaysalary, $sundaysalary, $holidaysalary, $officertandtpresent, $fixedovertimesalary, $officerotherallowance, $officerotherdeduction){
     return number_format($weekdaysalary + $saturdaysalary + $sundaysalary + $holidaysalary+ $officertandtpresent+ $fixedovertimesalary + $officerotherallowance + $officerotherdeduction, 2);
  }

  public static function acturebasic($officerbasic, $weekdays, $weekdaypresentdays){
    $offtt = ($officerbasic / $weekdays) * $weekdaypresentdays;
    return number_format($offtt, 2);

  }


  public static function officerovertimetax($weekdaysalary, $officertotalovertime){

     $percentagevalue = 0.50 * $weekdaysalary ;

    if($weekdaysalary <= 1500 ){
       if($officertotalovertime > $percentagevalue){
         return (0.50 * $weekdaysalary * 0.05) + ($officertotalovertime - (0.50 * $weekdaysalary)) * 0.10 ;
       }elseif($officertotalovertime <= $percentagevalue){
         return $officertotalovertime * 0.05;
       }
    }else{
      return 0;
    }

  }

  public static function officerssf($acturebasic){
      return $acturebasic * 0.055;
  }

  public static function officertaxable($weekdaysalary,  $officergross, $officerssf, $officertotalovertime){
      if($weekdaysalary < 1500){
        return $officergross - $officerssf - $officertotalovertime;
      }else{
        return  $officergross - $officerssf ;
      }
  }








}



 ?>
