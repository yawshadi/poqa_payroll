<?php

class Masterlist extends Controller{

  public function visamasterlistexcel(){

       $empdata = Employee::getvisaemployees();

       $objPHPExcel = new PHPExcel();

       $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                            ->setTitle("PHPExcel Test Document")
                            ->setSubject("PHPExcel Test Document")
                            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                            ->setKeywords("office PHPExcel php")
                            ->setCategory("Test result file");

         $objPHPExcel->setActiveSheetIndex(0);
         $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
         $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Full Name');
         $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Firstname');
         $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Family name');
         $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Gender');
         $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Date of Birth');
         $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Year of Birth');
         $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Original Profession');
         $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Intended Profession');
         $objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Passport Number');
         $objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Date of issue of passport');
         $objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Date of expiry of passport');
         $objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Fathers name');
         $objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Mothers name');
         $objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Spouse Name');
         $objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Date of Birth of spouse');
         $objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'Place of birth of spouse');
         $objPHPExcel->getActiveSheet()->SetCellValue('R5', 'Contact Phone Number of spouse');
         $objPHPExcel->getActiveSheet()->SetCellValue('S5', 'Family Address');
         $objPHPExcel->getActiveSheet()->SetCellValue('T5', 'Height -cm');
         $objPHPExcel->getActiveSheet()->SetCellValue('U5', 'Number of Children');
         $objPHPExcel->getActiveSheet()->SetCellValue('V5', 'Name and Date of birth of children');

       for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
             $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
         }

         $i = 6;

         foreach($empdata as $get){

           $fullname = $get->firstname. ' '. $get->surname;

           $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i);
           $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fullname);
           $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $get->firstname);
           $objPHPExcel->getActiveSheet()->setCellValue('D' . $i,	$get->surname);
           $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $get->gender );
           $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $get->dateofbirth);
           $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $get->yearofbirth);
           $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $get->profession );
           $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $get->intendedprofession);
           $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $get->passportnumber);
           $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $get->dateofpassportissue);
           $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $get->dateofpassportexpiry);
           $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $get->fathersname);
           $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $get->mothersname);
           $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $get->spousename);
           $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $get->dateofbirthofspouse);
           $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $get->placeofbirthofspouse );
           $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $get->telephoneofspouse);
           $objPHPExcel->getActiveSheet()->SetCellValue('S' . $i, $get->familyaddress);
           $objPHPExcel->getActiveSheet()->SetCellValue('T' . $i, $get->height );
           $objPHPExcel->getActiveSheet()->SetCellValue('U' . $i, $get->numberofchildren );
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $i, '' );
           $i++;
      }


     $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'LABOR POWER MASTER LIST');

     $imgpath = URLROOT.'/img/plogo.jpg';

     $gdImage = imagecreatefromjpeg($imgpath);

     $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
     $objDrawing->setName('Sample image');
     $objDrawing->setDescription('Sample image');
     $objDrawing->setImageResource($gdImage);
     $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
     $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
     $objDrawing->setHeight(80);
     $objDrawing->setCoordinates('A1');
     $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

     $objPHPExcel->getActiveSheet()->setTitle('SheetOne');

     ob_end_clean();
     header( "Content-type: application/vnd.ms-excel" );
     header('Content-Disposition: attachment; filename="visamasterlist.xlsx"');
     header("Pragma: no-cache");
     header("Expires: 0");

     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
     $objWriter->save('php://output');
     exit;

  }
}


 ?>
