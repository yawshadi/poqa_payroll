<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 3/8/2019
 * Time: 11:27 AM
 */

class Payinformation
{


    public static  function gross($employeeid, $startdate=null, $enddate=null){

        $empdata = Employee::getEmployeesById($employeeid);

        $basicsalary = $empdata->basicsalary;
        $category = $empdata->category;
        $location = $empdata->location;

        //payrollcalculations
        $staffssnit = Vamedcalculations::staffssnit($basicsalary);
        $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
        $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
        $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
        $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
        $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
        $rentallowance = Vamedcalculations::rentallowance($basicsalary);
        $grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit);

        return payround($grossincome);
    }


}