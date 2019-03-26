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
         $objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Birth Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Academic Title');
         $objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Entry Date');
         $objPHPExcel->getActiveSheet()->SetCellValue('G6', 'Monthly Salary (GHC)');
         $objPHPExcel->getActiveSheet()->SetCellValue('H6', 'Monthly Salary (EUROS)');
         $objPHPExcel->getActiveSheet()->SetCellValue('I6', 'Annual Bonus (GHC)');
         $objPHPExcel->getActiveSheet()->SetCellValue('J6', 'Annual Bonus (EUROS)');
         $objPHPExcel->getActiveSheet()->SetCellValue('K6', 'Location');
         $objPHPExcel->getActiveSheet()->SetCellValue('L6', 'Gender');

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

           $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $count);
           $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fullname);
           $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $get->position);
           $objPHPExcel->getActiveSheet()->setCellValue('D' . $i,	$get->dateofbirth);
           $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $get->academictitle );
           $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $get->entrydate);
           $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $income);
           $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $euroincome );
           $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
           $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, '');
           $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $get->location);
           $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $get->gender);
           $i++;
      }

      $y = $i + 3;
      $yt = $i + 2 ;
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$yt,  'LIST OF EXPATRIATE EMPLOYEES');
      $objPHPExcel->getActiveSheet()->mergeCells('A'.$yt.':'.'F'.$yt);
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$y, 'No');
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$y, 'Full Name');
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.$y, 'Position');
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.$y, 'Birth Date');
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.$y, 'Academic Title');
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$y, 'Entry Date');
      $objPHPExcel->getActiveSheet()->SetCellValue('G'.$y, 'Monthly Salary (GHC)');
      $objPHPExcel->getActiveSheet()->SetCellValue('H'.$y, 'Monthly Salary (EUROS)');
      $objPHPExcel->getActiveSheet()->SetCellValue('I'.$y, 'Annual Bonus (GHC)');
      $objPHPExcel->getActiveSheet()->SetCellValue('J'.$y, 'Annual Bonus (EUROS)');
      $objPHPExcel->getActiveSheet()->SetCellValue('K'.$y, 'Location');
      $objPHPExcel->getActiveSheet()->SetCellValue('L'.$y, 'Gender');

      $y = $y + 1;

      foreach($exdata as $key=>$get){

          $count = $key + 1;

          $fullname = $get->surname.' '.$get->firstname;
          $income = Payinformation::gross($get->basic_id);
          $ex = Exchangerates::getrates();
          $eurorate = $ex->euros;
          $euroincome  = payround($income / $eurorate);

          $objPHPExcel->getActiveSheet()->setCellValue('A' . $y, $count);
          $objPHPExcel->getActiveSheet()->setCellValue('B' . $y, $fullname);
          $objPHPExcel->getActiveSheet()->setCellValue('C' . $y, $get->position);
          $objPHPExcel->getActiveSheet()->setCellValue('D' . $y,	$get->dateofbirth);
          $objPHPExcel->getActiveSheet()->setCellValue('E' . $y, $get->academictitle );
          $objPHPExcel->getActiveSheet()->setCellValue('F' . $y, $get->entrydate);
          $objPHPExcel->getActiveSheet()->setCellValue('G' . $y, $income);
          $objPHPExcel->getActiveSheet()->setCellValue('H' . $y, $euroincome );
          $objPHPExcel->getActiveSheet()->setCellValue('I' . $y, '');
          $objPHPExcel->getActiveSheet()->setCellValue('J' . $y, '');
          $objPHPExcel->getActiveSheet()->setCellValue('K' . $y, $get->location);
          $objPHPExcel->getActiveSheet()->setCellValue('L' . $y, $get->gender);
          $y++;
      }



      $x = $y + 3;
      $xt = $y + 2 ;
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$xt,  'LIST OF JOINING STAFF IN THE REFERRING REPORTING MONTH');
      $objPHPExcel->getActiveSheet()->mergeCells('A'.$xt.':'.'F'.$xt);
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$x, 'No');
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$x, 'Full Name');
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.$x, 'Position');
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.$x, 'Birth Date');
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.$x, 'Academic Title');
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$x, 'Entry Date');

      $x = $x + 1;
      foreach($entrydata as $key=>$get){

          $count = $key + 1;
          $fullname = $get->surname.' '.$get->firstname;

          $objPHPExcel->getActiveSheet()->setCellValue('A' . $x, $count);
          $objPHPExcel->getActiveSheet()->setCellValue('B' . $x, $fullname);
          $objPHPExcel->getActiveSheet()->setCellValue('C' . $x, $get->position);
          $objPHPExcel->getActiveSheet()->setCellValue('D' . $x,	$get->dateofbirth);
          $objPHPExcel->getActiveSheet()->setCellValue('E' . $x, $get->academictitle );
          $objPHPExcel->getActiveSheet()->setCellValue('F' . $x, $get->entrydate);
          $x++;
      }


      $z = $x + 3;
      $zt = $x + 2 ;
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$zt,  'LIST OF LEAVING OF PERMANENT STAFF IN THE REFERRING REPORTING MONTH');
      $objPHPExcel->getActiveSheet()->mergeCells('A'.$zt.':'.'F'.$zt);

      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$z, 'No');
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$z, 'Full Name');
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, 'Position');
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.$z, 'Birth Date');
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.$z, 'Academic Title');
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, 'Exit Date');


      $z = $z + 1;


      foreach($entrydata as $key=>$get){
          $count = $key + 1 ;

          $fullname = $get->surname.' '.$get->firstname;

          $objPHPExcel->getActiveSheet()->setCellValue('A' . $z, $count);
          $objPHPExcel->getActiveSheet()->setCellValue('B' . $z, $fullname);
          $objPHPExcel->getActiveSheet()->setCellValue('C' . $z, $get->position);
          $objPHPExcel->getActiveSheet()->setCellValue('D' . $z,	$get->dateofbirth);
          $objPHPExcel->getActiveSheet()->setCellValue('E' . $z, $get->academictitle );
          $objPHPExcel->getActiveSheet()->setCellValue('F' . $z, $get->entrydate);
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
