<?php

class Masterlist extends Controller{


  public function index(){

     $ghdata =  Employee::getemployeebynationality('Ghanaian');
     $exdata = Employee::getemployeebynationality('Expatriate');
     $entrydata  = Employee::getentrylist();
     $exitdata  = Employee::getexitlist();

     $lastpaydate = Payperiod::getPayperiod();
     $paystart = $lastpaydate[0]->start;
     $payend = $lastpaydate[0]->end;

     $ex = Exchangerates::getrates();
     $euro = $ex->euros;

     $data  = ['ghdata'=>$ghdata, 'exdata'=>$exdata, 'entrydata'=>$entrydata, 'exitdata'=>$exitdata,
               'paystart'=>$paystart, 'payend'=>$payend, 'euros'=>$euro
              ];
     $this->view('reports/masterlist', $data);

  }


  public function masterlistexcel(){

      $ghdata =  Employee::getemployeebynationality('Ghanaian');
      $exdata = Employee::getemployeebynationality('Expatriate');
      $entrydata  = Employee::getentrylist();
      $exitdata  = Employee::getexitlist();

      $lastpaydate = Payperiod::getPayperiod();
      $paystart = $lastpaydate[0]->start;
      $payend = $lastpaydate[0]->end;

       $objPHPExcel = new PHPExcel();
       $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                            ->setTitle("PHPExcel Test Document")
                            ->setSubject("PHPExcel Test Document")
                            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                            ->setKeywords("office PHPExcel php")
                            ->setCategory("Test result file");

         $objPHPExcel->setActiveSheetIndex(0);
         $objPHPExcel->getActiveSheet()->SetCellValue('A5',  'LIST OF GHANAIAN EMPLOYEES');
         $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
         $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Full Name');
         $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Position');
         $objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Telephone');
         $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Birth Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('F6', 'StaffID');
         $objPHPExcel->getActiveSheet()->SetCellValue('G6', 'Location');
         $objPHPExcel->getActiveSheet()->SetCellValue('H6', 'Nationality');
         $objPHPExcel->getActiveSheet()->SetCellValue('I6', 'Marital Status');
         $objPHPExcel->getActiveSheet()->SetCellValue('J6', 'ID Number');
         $objPHPExcel->getActiveSheet()->SetCellValue('K6', 'Bank');
         $objPHPExcel->getActiveSheet()->SetCellValue('L6', 'Account Number');
         $objPHPExcel->getActiveSheet()->SetCellValue('M6', 'Probation Start');
         $objPHPExcel->getActiveSheet()->SetCellValue('N6', 'Probation End');
         $objPHPExcel->getActiveSheet()->SetCellValue('O6', 'Gaurantor Name');
         $objPHPExcel->getActiveSheet()->SetCellValue('P6', 'Gaurantor Phone');
         $objPHPExcel->getActiveSheet()->SetCellValue('Q6', 'Tier 2 NO.');
         $objPHPExcel->getActiveSheet()->SetCellValue('R6', 'Employee TIN');
         $objPHPExcel->getActiveSheet()->SetCellValue('S6', 'Hire Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('T6', 'Exit Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('U6', 'Contract Allocation');
         $objPHPExcel->getActiveSheet()->SetCellValue('V6', 'Tier 3 NO.');
         $objPHPExcel->getActiveSheet()->SetCellValue('W6', 'Consolidated Salary');
         $objPHPExcel->getActiveSheet()->SetCellValue('X6', 'Academic Title');
         $objPHPExcel->getActiveSheet()->SetCellValue('Y6', 'Entry Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('Z6', 'Contract Start');
         $objPHPExcel->getActiveSheet()->SetCellValue('AA6', 'Contract End');
         $objPHPExcel->getActiveSheet()->SetCellValue('AB6', 'Monthly Salary (GHC)');
         $objPHPExcel->getActiveSheet()->SetCellValue('AC6', 'Monthly Salary (EUROS)');
         $objPHPExcel->getActiveSheet()->SetCellValue('AD6', 'Annual Bonus (GHC)');
         $objPHPExcel->getActiveSheet()->SetCellValue('AE6', 'Annual Bonus (EUROS)');
         $objPHPExcel->getActiveSheet()->SetCellValue('AF6', 'Location');
         $objPHPExcel->getActiveSheet()->SetCellValue('AG6', 'Gender');
         $objPHPExcel->getActiveSheet()->SetCellValue('AH6', 'Job Category');

       for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
             $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
         }

         $i = 7;

         foreach($ghdata as $key=>$get){

             $count = $key + 1;

             $fullname = $get->surname.' '.$get->firstname;
             $income = Payinformation::gross($get->basic_id);
             $ex = Exchangerates::getrates();
             $eurorate = $ex->euros;
             $euroincome  = payround($income / $eurorate);

           $objPHPExcel->getActiveSheet()->setCellValue('A' .  $i, $count);
           $objPHPExcel->getActiveSheet()->setCellValue('B' .  $i, $fullname);
           $objPHPExcel->getActiveSheet()->setCellValue('C' .  $i, $get->position);
           $objPHPExcel->getActiveSheet()->setCellValue('D' .  $i, $get->telephone);
           $objPHPExcel->getActiveSheet()->setCellValue('E' .  $i,	$get->dateofbirth);
           $objPHPExcel->getActiveSheet()->setCellValue('F' .  $i,	$get->staffid);
           $objPHPExcel->getActiveSheet()->setCellValue('G' .  $i,	$get->location);
           $objPHPExcel->getActiveSheet()->setCellValue('H' .  $i,	$get->nationality);
           $objPHPExcel->getActiveSheet()->setCellValue('I' .  $i,	$get->maritalstatus);
           $objPHPExcel->getActiveSheet()->setCellValue('J' .  $i,	$get->idnumber);
           $objPHPExcel->getActiveSheet()->setCellValue('K' .  $i,	$get->bankname);
           $objPHPExcel->getActiveSheet()->setCellValue('L' .  $i,	$get->accountnumber);
           $objPHPExcel->getActiveSheet()->setCellValue('M' .  $i,	$get->probationstart);
           $objPHPExcel->getActiveSheet()->setCellValue('N' .  $i,	$get->probationend);
           $objPHPExcel->getActiveSheet()->setCellValue('O' .  $i,	$get->gaurantor);
           $objPHPExcel->getActiveSheet()->setCellValue('P' .  $i,	$get->gaurantor_telephone);
           $objPHPExcel->getActiveSheet()->setCellValue('Q' .  $i,	$get->tiernumber);
           $objPHPExcel->getActiveSheet()->setCellValue('R' .  $i,	$get->tinnumber);
           $objPHPExcel->getActiveSheet()->setCellValue('S' .  $i,	$get->hiredate);
           $objPHPExcel->getActiveSheet()->setCellValue('T' .  $i,	$get->exitdate);
           $objPHPExcel->getActiveSheet()->setCellValue('U' .  $i,	$get->contractallocation);
           $objPHPExcel->getActiveSheet()->setCellValue('V' .  $i,	$get->tier3number);
           $objPHPExcel->getActiveSheet()->setCellValue('W' .  $i,	$get->basicsalary);
           $objPHPExcel->getActiveSheet()->setCellValue('X' .  $i, $get->academictitle );
           $objPHPExcel->getActiveSheet()->setCellValue('Y' .  $i, $get->entrydate);
           $objPHPExcel->getActiveSheet()->setCellValue('Z' .  $i, $get->contractstart);
           $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $get->contractend);
           $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $income);
           $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $euroincome );
           $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '');
           $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, '');
           $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $get->location);
           $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, $get->gender);
           $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $get->jobcat);
           $i++;
      }

      $y = $i + 3;
      $yt = $i + 2 ;
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$yt,  'LIST OF EXPATRIATE EMPLOYEES');
      $objPHPExcel->getActiveSheet()->mergeCells('A'.$yt.':'.'F'.$yt);
         $objPHPExcel->getActiveSheet()->SetCellValue('A6'.$y, 'No');
         $objPHPExcel->getActiveSheet()->SetCellValue('B6'.$y, 'Full Name');
         $objPHPExcel->getActiveSheet()->SetCellValue('C6'.$y, 'Position');
         $objPHPExcel->getActiveSheet()->SetCellValue('D6'.$y, 'Telephone');
         $objPHPExcel->getActiveSheet()->SetCellValue('E6'.$y, 'Birth Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('F6'.$y, 'StaffID');
         $objPHPExcel->getActiveSheet()->SetCellValue('G6'.$y, 'Location');
         $objPHPExcel->getActiveSheet()->SetCellValue('H6'.$y, 'Nationality');
         $objPHPExcel->getActiveSheet()->SetCellValue('I6'.$y, 'Marital Status');
         $objPHPExcel->getActiveSheet()->SetCellValue('J6'.$y, 'ID Number');
         $objPHPExcel->getActiveSheet()->SetCellValue('K6'.$y, 'Bank');
         $objPHPExcel->getActiveSheet()->SetCellValue('L6'.$y, 'Account Number');
         $objPHPExcel->getActiveSheet()->SetCellValue('M6'.$y, 'Probation Start');
         $objPHPExcel->getActiveSheet()->SetCellValue('N6'.$y, 'Probation End');
         $objPHPExcel->getActiveSheet()->SetCellValue('O6'.$y, 'Gaurantor Name');
         $objPHPExcel->getActiveSheet()->SetCellValue('P6'.$y, 'Gaurantor Phone');
         $objPHPExcel->getActiveSheet()->SetCellValue('Q6'.$y, 'Tier 2 NO.');
         $objPHPExcel->getActiveSheet()->SetCellValue('R6'.$y, 'Employee TIN');
         $objPHPExcel->getActiveSheet()->SetCellValue('S6'.$y, 'Hire Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('T6'.$y, 'Exit Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('U6'.$y, 'Contract Allocation');
         $objPHPExcel->getActiveSheet()->SetCellValue('V6'.$y, 'Tier 3 NO.');
         $objPHPExcel->getActiveSheet()->SetCellValue('W6'.$y, 'Consolidated Salary');
         $objPHPExcel->getActiveSheet()->SetCellValue('X6'.$y, 'Academic Title');
         $objPHPExcel->getActiveSheet()->SetCellValue('Y6'.$y, 'Entry Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('Z6'.$y, 'Contract Start');
         $objPHPExcel->getActiveSheet()->SetCellValue('AA6'.$y, 'Contract End');
         $objPHPExcel->getActiveSheet()->SetCellValue('AB6'.$y, 'Monthly Salary (GHC)');
         $objPHPExcel->getActiveSheet()->SetCellValue('AC6'.$y, 'Monthly Salary (EUROS)');
         $objPHPExcel->getActiveSheet()->SetCellValue('AD6'.$y, 'Annual Bonus (GHC)');
         $objPHPExcel->getActiveSheet()->SetCellValue('AE6'.$y, 'Annual Bonus (EUROS)');
         $objPHPExcel->getActiveSheet()->SetCellValue('AF6'.$y, 'Location');
         $objPHPExcel->getActiveSheet()->SetCellValue('AG6'.$y, 'Gender');
         $objPHPExcel->getActiveSheet()->SetCellValue('AH6'.$y, 'Job Category');

      $y = $y + 1;

      foreach($exdata as $key=>$get){

          $count = $key + 1;

          $fullname = $get->surname.' '.$get->firstname;
          $income = Payinformation::gross($get->basic_id);
          $ex = Exchangerates::getrates();
          $eurorate = $ex->euros;
          $euroincome  = payround($income / $eurorate);

          $objPHPExcel->getActiveSheet()->setCellValue('A' .  $y, $count);
          $objPHPExcel->getActiveSheet()->setCellValue('B' .  $y, $fullname);
          $objPHPExcel->getActiveSheet()->setCellValue('C' .  $y, $get->position);
          $objPHPExcel->getActiveSheet()->setCellValue('D' .  $y, $get->telephone);
          $objPHPExcel->getActiveSheet()->setCellValue('E' .  $y,	$get->dateofbirth);
          $objPHPExcel->getActiveSheet()->setCellValue('F' .  $y,	$get->staffid);
          $objPHPExcel->getActiveSheet()->setCellValue('G' .  $y,	$get->location);
          $objPHPExcel->getActiveSheet()->setCellValue('H' .  $y,	$get->nationality);
          $objPHPExcel->getActiveSheet()->setCellValue('I' .  $y,	$get->maritalstatus);
          $objPHPExcel->getActiveSheet()->setCellValue('J' .  $y,	$get->idnumber);
          $objPHPExcel->getActiveSheet()->setCellValue('K' .  $y,	$get->bankname);
          $objPHPExcel->getActiveSheet()->setCellValue('L' .  $y,	$get->accountnumber);
          $objPHPExcel->getActiveSheet()->setCellValue('M' .  $y,	$get->probationstart);
          $objPHPExcel->getActiveSheet()->setCellValue('N' .  $y,	$get->probationend);
          $objPHPExcel->getActiveSheet()->setCellValue('O' .  $y,	$get->gaurantor);
          $objPHPExcel->getActiveSheet()->setCellValue('P' .  $y,	$get->gaurantor_telephone);
          $objPHPExcel->getActiveSheet()->setCellValue('Q' .  $y,	$get->tiernumber);
          $objPHPExcel->getActiveSheet()->setCellValue('R' .  $y,	$get->tinnumber);
          $objPHPExcel->getActiveSheet()->setCellValue('S' .  $y,	$get->hiredate);
          $objPHPExcel->getActiveSheet()->setCellValue('T' .  $y,	$get->exitdate);
          $objPHPExcel->getActiveSheet()->setCellValue('U' .  $y,	$get->contractallocation);
          $objPHPExcel->getActiveSheet()->setCellValue('V' .  $y,	$get->tier3number);
          $objPHPExcel->getActiveSheet()->setCellValue('W' .  $y,	$get->basicsalary);
          $objPHPExcel->getActiveSheet()->setCellValue('X' .  $y, $get->academictitle );
          $objPHPExcel->getActiveSheet()->setCellValue('Y' .  $y, $get->entrydate);
          $objPHPExcel->getActiveSheet()->setCellValue('Z' .  $y, $get->contractstart);
          $objPHPExcel->getActiveSheet()->setCellValue('AA' . $y, $get->contractend);
          $objPHPExcel->getActiveSheet()->setCellValue('AB' . $y, $income);
          $objPHPExcel->getActiveSheet()->setCellValue('AC' . $y, $euroincome );
          $objPHPExcel->getActiveSheet()->setCellValue('AD' . $y, '');
          $objPHPExcel->getActiveSheet()->setCellValue('AE' . $y, '');
          $objPHPExcel->getActiveSheet()->setCellValue('AF' . $y, $get->location);
          $objPHPExcel->getActiveSheet()->setCellValue('AG' . $y, $get->gender);
          $objPHPExcel->getActiveSheet()->setCellValue('AH' . $y, $get->jobcat);
          $y++;
      }



      $x = $y + 3;
      $xt = $y + 2 ;
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$xt,  'LIST OF JOINING STAFF IN THE REFERRING REPORTING MONTH');
      $objPHPExcel->getActiveSheet()->mergeCells('A'.$xt.':'.'F'.$xt);
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$x, 'No');
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$x, 'Full Name');
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.$x, 'Position');
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.$x, 'Telephone');
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.$x, 'Birth Date');
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$x, 'Academic Title');
      $objPHPExcel->getActiveSheet()->SetCellValue('G'.$x, 'Entry Date');

      $x = $x + 1;
      foreach($entrydata as $key=>$get){

          $count = $key + 1;
          $fullname = $get->surname.' '.$get->firstname;

          $objPHPExcel->getActiveSheet()->setCellValue('A' . $x, $count);
          $objPHPExcel->getActiveSheet()->setCellValue('B' . $x, $fullname);
          $objPHPExcel->getActiveSheet()->setCellValue('C' . $x, $get->position);
          $objPHPExcel->getActiveSheet()->setCellValue('D' . $x, $get->telephone);
          $objPHPExcel->getActiveSheet()->setCellValue('E' . $x,	$get->dateofbirth);
          $objPHPExcel->getActiveSheet()->setCellValue('F' . $x, $get->academictitle );
          $objPHPExcel->getActiveSheet()->setCellValue('G' . $x, $get->entrydate);
          $x++;
      }


      $z = $x + 3;
      $zt = $x + 2 ;
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$zt,  'LIST OF LEAVING OF PERMANENT STAFF IN THE REFERRING REPORTING MONTH');
      $objPHPExcel->getActiveSheet()->mergeCells('A'.$zt.':'.'F'.$zt);

      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$z, 'No');
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, 'Full Name');
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, 'Position');
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, 'Telephone');
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, 'Birth Date');
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, 'Academic Title');
      $objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, 'Entry Date');


      $z = $z + 1;


      foreach($entrydata as $key=>$get){
          $count = $key + 1 ;

          $fullname = $get->surname.' '.$get->firstname;

          $objPHPExcel->getActiveSheet()->setCellValue('A' . $z, $count);
          $objPHPExcel->getActiveSheet()->setCellValue('B' . $z, $fullname);
          $objPHPExcel->getActiveSheet()->setCellValue('C' . $z, $get->position);
          $objPHPExcel->getActiveSheet()->setCellValue('D' . $z, $get->telephone);
          $objPHPExcel->getActiveSheet()->setCellValue('E' . $z,	$get->dateofbirth);
          $objPHPExcel->getActiveSheet()->setCellValue('F' . $z, $get->academictitle );
          $objPHPExcel->getActiveSheet()->setCellValue('G' . $z, $get->entrydate);
          $z++;
      }





      $objPHPExcel->getActiveSheet()->SetCellValue('A1',  COMPANYNAME);
      $objPHPExcel->getActiveSheet()->SetCellValue('A2',  'Accra-Ghana');
      $objPHPExcel->getActiveSheet()->SetCellValue('A3',  $payend);


      $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
      $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
      $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
      $objPHPExcel->getActiveSheet()->mergeCells('A5:C5');


//     $imgpath = URLROOT.'/img/plogo.jpg';
//     $gdImage = imagecreatefromjpeg($imgpath);
//
//     $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
//     $objDrawing->setName('Sample image');
//     $objDrawing->setDescription('Sample image');
//     $objDrawing->setImageResource($gdImage);
//     $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
//     $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
//     $objDrawing->setHeight(80);
//     $objDrawing->setCoordinates('A1');
//     $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

     $objPHPExcel->getActiveSheet()->setTitle('SheetOne');

     ob_end_clean();
     header( "Content-type: application/vnd.ms-excel" );
     header('Content-Disposition: attachment; filename="vamedmasterlist.xlsx"');
     header("Pragma: no-cache");
     header("Expires: 0");

     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
     $objWriter->save('php://output');
     exit;

  }
}


 ?>
