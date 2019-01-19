<?php

class Vamedcalculations{


   public static function staffssnit($basicsalary){

       $amount =  $basicsalary * 0.055;
        return $amount;
   }

   public static function totalincome($basicsalary, $staffssnit){
     $amount =  $basicsalary - $staffssnit;
      return $amount;
   }

   public static function standardovertime($basicsalary){
     $amount =  $basicsalary * 0.5;
      return $amount;
   }

   public static function teamdevelopment($basicsalary){
     $amount =  $basicsalary * 0.15;
      return $amount;
   }

   public static function satsunholovertime($category, $basicsalary){

     if($category == 'Manager'){
       $amount = 0;
        return $amount;

     }elseif($category == 'Officer 1'){
       $amount =  $basicsalary * 0.275;
        return $amount;

     }elseif($category == 'Officer 2'){
       $amount =  $basicsalary * 0.025;
        return $amount;
     }

   }

   public static function transportvehiclemaintenance($basicsalary){
     $amount =  $basicsalary * 0.10;
      return $amount;
   }

   public static function rentallowance($basicsalary){
     $amount =  $basicsalary * 0.10;
      return $amount;
   }

   public static function grossincome($totalincome, $transportvehiclemaintenance, $rentallowance){
     $amount =  $totalincome + $transportvehiclemaintenance +  $rentallowance;
      return $amount;
   }

   public static function taxableincome($grossincome, $taxrelief){
     $amount =  $grossincome - $taxrelief;
      return $amount;
   }

   public static function paye($taxableincome){

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

   public static function whtonstandardovertime($standardovertime){
     $amount =  $standardovertime * 0.10;
      return $amount;
   }

   public static function whtonsatsunholovertime($satsunholovertime){
     $amount =  $satsunholovertime * 0.10;
      return $amount;
   }

   public static function bonustax($teamdevelopment){
     $amount =  $satsunholovertime * 0.05;
      return $amount;
   }

   public static function totaltaxpayable($paye, $whtonstandardovertime, $whtonsatsunholovertime, $bonustax ){
     $amount =  $paye + $whtonstandardovertime + $whtonsatsunholovertime + $bonustax;
      return $amount;
   }

   public static function vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $rentallowance,
                                      $transportvehiclemaintenance, $totaltaxpayable, $salaryadvance)
                                      {
     $amount = $grossincome + $standardovertime + $teamdevelopment + $satsunholovertime + $rentallowance +
                                        $transportvehiclemaintenance + $totaltaxpayable - $salaryadvance;
      return $amount;
   }

   public static function vamedwelfarenetsalary($vamednetpay, $staffwelfare){
     $amount =  $vamednetpay - $staffwelfare;
      return $amount;
   }

   public static function employerssnit($basicsalary){
      $amount =  $basicsalary * 0.13;
      return $amount;
   }

   public static function totalssnit($staffssnit, $employerssnit){
      $amount =  $staffssnit + $employerssnit;
      return $amount;
   }


   public static function ssnitact($totalssnit){
      $amount = 0.135 / 0.185 * $totalssnit;
      return $amount;
   }


   public static function secondtier($totalssnit, $ssnitact){
      $amount = $totalssnit - $ssnitact
      return $amount;
   }



}


 ?>
