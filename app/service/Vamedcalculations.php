<?php

class Vamedcalculations{


   public static function staffssnit($basicsalary){

       $amount =  $basicsalary * 0.055;
        return $amount;
   }


    public static function tierssnit($basicsalary){

        $amount =  $basicsalary * 0.05;
        return $amount;
    }

   public static function totalincome($basicsalary, $staffssnit){
     $amount =  $basicsalary - $staffssnit;
      return $amount;
   }

   public static function standardovertime($basicsalary, $category){

       if($category == 'Officer 1' || $category == 'Officer 2') {
           return $basicsalary * 0.5;
       }elseif($category == 'Manager'){
          $amount = ($basicsalary / 22) * 0.10 * 66;
           return $amount;
       }
   }

   public static function teamdevelopment($basicsalary, $category){
       if($category == 'Manager') {
         $amount =  $basicsalary * 0.25;
          return $amount;
       }else{
           $amount =  $basicsalary * 0.15;
           return $amount;
       }

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

   public static function grossincome($basicsalary, $transportallowance, $rentallowance, $staffssnit){
     $amount =  $basicsalary + $transportallowance + $rentallowance - $staffssnit;
      return $amount;
   }

   public static function taxableincome($grossincome, $taxrelief){
     $amount =  $grossincome - $taxrelief;
      return $amount;
   }

   public static function paye($taxable){

     if($taxable < 261){
        return $paye = 0;
      }elseif($taxable > 261 && $taxable<=330){
        $paye = ($taxable - 261) * 0.05;
        return $paye ;
      }elseif($taxable > 331 && $taxable <= 430){
         $paye = (($taxable - 331) * 0.10) + 3.5;
         return $paye ;
      }elseif($taxable > 431 && $taxable <= 3240){
          $paye = (($taxable - 431) * 0.175) + 13.5;
          return  $paye;
      }elseif($taxable > 3241){
        $paye = (($taxable - 3241) * 0.25) + 505.25;
        return  $paye;
      }else{
       return $paye = 0;
      }
   }

   public static function whtonstandardovertime($standardovertime){
     $amount =  $standardovertime * 0.05;
      return $amount;
   }

   public static function whtonsatsunholovertime($satsunholovertime){
     $amount =  $satsunholovertime * 0.10;
      return $amount;
   }

   public static function bonustax($teamdevelopment){
     $amount =  $teamdevelopment * 0.05;
      return $amount;
   }

   public static function totaltaxpayable($paye, $whtonstandardovertime, $whtonsatsunholovertime, $bonustax ){
     $amount =  $paye + $whtonstandardovertime + $whtonsatsunholovertime + $bonustax;
      return $amount;
   }

   public static function vamednetpay($grossincome, $standardovertime, $teamdevelopment, $satsunholovertime, $totaltaxpayable, $salaryadvance)
   {
     $amount = $grossincome + $standardovertime + $teamdevelopment + $satsunholovertime  - $totaltaxpayable - $salaryadvance;
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
      $amount = $totalssnit - $ssnitact;
      return $amount;
   }

   public static function totalbonus($standardovertime, $teamdevelopment, $satsunholovertime){
     $amount = $standardovertime+ $teamdevelopment+ $satsunholovertime;
     return $amount;
   }

   public static function bonusincome ($basicsalary){
     return $basicsalary * 0.15;
   }


   public static function taxonbonusincome ($bonusincome, $excessbonus){
     return ($bonusincome * 0.05) + ($excessbonus * 0.10);
   }

   public static function excessbonus ($basicsalary){
     return $basicsalary * (0.925-0.5-0.15);
   }

   public static function totalcashemolument ($basicsalary, $cashallowance = 0){
     return $basicsalary + $cashallowance;
   }

   public static function totalAssessableincome($totalcashemolument, $accomodation=0, $vehicle=0, $noncashbenefit=0){

      return $totalcashemolument + $accomodation + $vehicle + $noncashbenefit;
   }

   public static function totalreliefs($staffssnit, $thirdtier=0, $dedrelief=0){

      return $staffssnit + $thirdtier + $dedrelief;
   }

   public static function chargeableincome ($totalAssessableincome, $totalreliefs){
      return $totalAssessableincome - $totalreliefs;
   }

   public static function overtimecallincome ($basicsalary){
      return $basicsalary * 0.5;
   }

   public static function overtimecalltax ($overtimecallincome){
      return $overtimecallincome * 0.05;
   }

   public static function togra ($taxonbonusincome , $paye, $overtimecalltax){
      return $taxonbonusincome + $paye + $overtimecalltax;
   }


    public static function ssnitforschedule($basicsalary){
        $amount =  $basicsalary * 0.135;
        return $amount;
    }




}


 ?>
