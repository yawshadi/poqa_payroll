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

       if($category == 'Officer 1' || $category == 'Officer 2' || $category == 'Officer 11' || $category == 'Officer 22') {
           return $basicsalary * 0.5;
       }elseif($category == 'Manager'){
          $amount = ($basicsalary / 22) * 0.10 * 66;
           return $amount;
       }
   }

    public static function staffprovidentfund($basicsalary){
        $amount = $basicsalary * 0.05;
        return $amount;
    }

    public static function employeeprovidentfund($basicsalary){
            $amount = $basicsalary * 0.05;
            return $amount;
    }
    public static function totalprovidentfunc($basicsalary ,$category){
       if($category == 'Pensioner'){
          $amount = 0;
       }else{
         $amount = self::staffprovidentfund($basicsalary) +  self::employeeprovidentfund($basicsalary);

       }
        return $amount;
    }

    public static function basicsalarypercent($basicsalary){
        $amount = $basicsalary * 0.055;
        return $amount;
    }

   public static function teamdevelopment($basicsalary, $category){
       if($category == 'Manager') {
           $amount = $basicsalary * 0.25;
           return $amount;
       }if($category == 'Officer 11' || $category == 'Officer 22') {
           $amount = $basicsalary * 0.25;
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

     }elseif($category == 'Officer 1' || $category == 'Officer 11'){
       $amount =  $basicsalary * 0.275;
        return $amount;

     }elseif($category == 'Officer 2' || $category == 'Officer 22'){
       $amount =  $basicsalary * 0.025;
        return $amount;
     }

   }

   public static function transportvehiclemaintenance($basicsalary){
     //$amount =  $basicsalary * 0.10;
     $amount =  ($basicsalary * 0.10) *  ( 1 + 0.40);
      return $amount;
   }

   public static function rentallowance($basicsalary){
     //$amount =  $basicsalary * 0.10;
      $amount =  ($basicsalary * 0.10) *  ( 1 + 0.40);
      return $amount;
   }

   public static function grossincome($basicsalary, $otherbenefits, $staffssnit, $providentfund = null){

     $amount =  $basicsalary + $otherbenefits - $staffssnit -  $providentfund;
      return $amount;
   }

   public static function loanbenefits($loanrepayment){
      $amount =  ($loanrepayment*24*0.1458*2)*0.25;
       return $amount;
    }

   public static function taxableincome($grossincome, $taxrelief,$loanbenefits){
     $amount =  $grossincome + $loanbenefits - $taxrelief;
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

   public static function bonustax($bonus){
     $amount =  $bonus * 0.05;
      return $amount;
   }

   public static function totaltaxpayable($paye, $bonustax ){
     $amount =  $paye + $bonustax;
      return $amount;
   }

   public static function vamednetpay($grossincome, $totaltaxpayable, $salaryadvance, $loanrepayment,$bonus,$basicsalary,$category)
   {
      if($category == 'Pensioner'){

         $amount = ($grossincome + $bonus  - $totaltaxpayable - $salaryadvance - $loanrepayment) + ($basicsalary*0.185 + $basicsalary*0.10) ;
         return $amount;
      }else{
     $amount = $grossincome + $bonus  - $totaltaxpayable - $salaryadvance - $loanrepayment;
      return $amount;
      }
   }

   public static function vamedwelfarenetsalary($vamednetpay, $staffwelfare,$otherdeductible){
     $amount =  $vamednetpay - $staffwelfare - $otherdeductible;
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


   public static function ssnitact($basicsalary,$category){
      if($category == "Normal"){
         $amount = 0.135  * $basicsalary;
      }else{
      $amount = 0;
      }
     
      return $amount;
   }


   public static function secondtier($basicsalary, $category){
      if($category == "Normal"){
         $amount = 0.05  * $basicsalary;
      }elseif ($category == 'Pensioner'){
      $amount = 0;
      }else{
         $amount = 0.185  * $basicsalary;
      }
     
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

   public static function cashallowance($basicsalary){
       $amount = ($basicsalary + 0.10) * (1+.40) + ($basicsalary * 0.10) * (1+0.40);
       return $amount;
   }

   public static function totalcashemolument ($basicsalary){
     return $basicsalary + self::cashallowance($basicsalary);
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
