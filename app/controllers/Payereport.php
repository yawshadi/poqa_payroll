<?php


class Payereport extends Controller{


     public function index(){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();

        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];


        if(isset($_POST['payebtn'])){

          $startdate = $_POST['startdate'];
          $enddate = $_POST['enddate'];

          $empdata = Employee::getEmployeesByType($_POST['company']);

          $companyid = Companies::getCompanybyName($_POST['company']);

          $payrolldata = [];

          foreach($empdata as $get){

            $company = $_POST['company'];
            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->surname.' '.$get->firstname;
            $basic_id = $get->basic_id;
            $category = $get->category;
            $ssnitnumber = $get->ssnitnumber;
            $location = $get->location;
            $basicsalary = $get->basicsalary;
            $tinnumber = $get->tinnumber;

            //recurrent calculation
            $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
            $taxrelief = $rec->taxrelf;
            $salaryadvance =  $rec->salaryadvance;
            $staffwelfare = $rec->staffwelfare;

            //payrollcalculations
            $staffssnit = Vamedcalculations::staffssnit($basicsalary);
            $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
            $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
            $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
            $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
            $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
            $rentallowance = Vamedcalculations::rentallowance($basicsalary);
            $grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit);
            $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief);
            $paye =  Vamedcalculations::paye($taxableincome);

            $bonusincome = Vamedcalculations::bonusincome($basicsalary);
            $excessbonus = Vamedcalculations::excessbonus($basicsalary);
            $taxonbonusincome = Vamedcalculations::taxonbonusincome($bonusincome, $excessbonus);
            $totalcashemolument = Vamedcalculations::totalcashemolument($basicsalary);
            $totalAssessableincome = Vamedcalculations::totalAssessableincome($totalcashemolument);
            $totalreliefs = Vamedcalculations::totalreliefs($staffssnit);
            $chargeableincome = Vamedcalculations::chargeableincome($totalAssessableincome, $totalreliefs);
            $overtimecallincome = Vamedcalculations::overtimecallincome($basicsalary);
            $overtimecalltax = Vamedcalculations::overtimecalltax($overtimecallincome);
            $togra = Vamedcalculations::togra($taxonbonusincome , $paye, $overtimecalltax);

             $payrolldata[] = [
                               'fullname'=>$fullname, 'position'=>$position, 'tinnumber'=>$tinnumber, 'basicsalary'=>$basicsalary,
                               'paye'=>$paye, 'togra'=>$togra
                             ];

          }

       $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                   'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];
       $this->view('reports/payereport', $alldata);
        }else{

        $this->view('reports/payereport', $alldata);
        }

     }


     public function excel($startdate,$enddate, $companyid){

          $company = Companies::getCompanybyId($companyid);
          $empdata = Employee::getEmployeesByCompany($company);

          $objPHPExcel = new PHPExcel();

          $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                               ->setLastModifiedBy("Maarten Balliauw")
                               ->setTitle("PHPExcel Test Document")
                               ->setSubject("PHPExcel Test Document")
                               ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                               ->setKeywords("office PHPExcel php")
                               ->setCategory("Test result file");

            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A10', 'Ser. No');
            $objPHPExcel->getActiveSheet()->SetCellValue('B10', 'TIN');
            $objPHPExcel->getActiveSheet()->SetCellValue('C10', 'Name of Employee');
            $objPHPExcel->getActiveSheet()->SetCellValue('D10', 'Position');
            $objPHPExcel->getActiveSheet()->SetCellValue('E10', 'Non-Resident  (Y / N)');
            $objPHPExcel->getActiveSheet()->SetCellValue('F10', 'Basic Salary');
            $objPHPExcel->getActiveSheet()->SetCellValue('G10', 'Secondary Employment (Y / N)');
            $objPHPExcel->getActiveSheet()->SetCellValue('H10', 'Social Security Fund ');
            $objPHPExcel->getActiveSheet()->SetCellValue('I10', 'Third Tier');
            $objPHPExcel->getActiveSheet()->SetCellValue('J10', 'Cash Allowances');
            $objPHPExcel->getActiveSheet()->SetCellValue('K10', 'Bonus Income(up to 15% of Annual Basic salary)');
            $objPHPExcel->getActiveSheet()->SetCellValue('L10', 'Final Tax on Bonus Income');
            $objPHPExcel->getActiveSheet()->SetCellValue('M10', 'EXCESS BONUS');
            $objPHPExcel->getActiveSheet()->SetCellValue('N10', 'Total Cash emolument');
            $objPHPExcel->getActiveSheet()->SetCellValue('O10', 'Accomodation Element');
            $objPHPExcel->getActiveSheet()->SetCellValue('P10', 'Vehicle Element');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q10', 'Non Cash Benefit');
            $objPHPExcel->getActiveSheet()->SetCellValue('R10', 'Total Assessable Income');
            $objPHPExcel->getActiveSheet()->SetCellValue('S10', 'Deductible Reliefs');
            $objPHPExcel->getActiveSheet()->SetCellValue('T10', 'Total Reliefs');
            $objPHPExcel->getActiveSheet()->SetCellValue('U10', 'Chargeable Income');
            $objPHPExcel->getActiveSheet()->SetCellValue('V10', 'Tax Deductible');

            $objPHPExcel->getActiveSheet()->SetCellValue('W10', 'Overtime  / Call-In Income');
            $objPHPExcel->getActiveSheet()->SetCellValue('X10', 'Overtime / Call-In Tax');
            $objPHPExcel->getActiveSheet()->SetCellValue('Y10', 'Total Tax Payable to GRA ');
            $objPHPExcel->getActiveSheet()->SetCellValue('Z10', 'Severance pay paid');
            $objPHPExcel->getActiveSheet()->SetCellValue('AA10', 'Remarks');




           for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
            }

            $i = 11;

            foreach($empdata as $key=>$get){

              $count = $key + 1;
              $department =  $get->department;
              $position  = $get->position;
              $fullname =  $get->surname.' '.$get->firstname;
              $basic_id = $get->basic_id;
              $category = $get->category;
              $ssnitnumber = $get->ssnitnumber;
              $location = $get->location;
              $basicsalary = $get->basicsalary;
              $tinnumber = $get->tinnumber;

              //recurrent calculation
              $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
              $taxrelief = $rec->taxrelf;
              $salaryadvance =  $rec->salaryadvance;
              $staffwelfare = $rec->staffwelfare;

              //payrollcalculations
              $staffssnit = Vamedcalculations::staffssnit($basicsalary);
              $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
              $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
              $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
              $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
              $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
              $rentallowance = Vamedcalculations::rentallowance($basicsalary);
              $grossincome = Vamedcalculations::grossincome($basicsalary, $transportvehiclemaintenance, $rentallowance, $staffssnit);
              $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief);
              $paye =  Vamedcalculations::paye($taxableincome);

              $bonusincome = Vamedcalculations::bonusincome($basicsalary);
              $excessbonus = Vamedcalculations::excessbonus($basicsalary);
              $taxonbonusincome = Vamedcalculations::taxonbonusincome($bonusincome, $excessbonus);
              $totalcashemolument = Vamedcalculations::totalcashemolument($basicsalary);
              $totalAssessableincome = Vamedcalculations::totalAssessableincome($totalcashemolument);
              $totalreliefs = Vamedcalculations::totalreliefs($staffssnit);
              $chargeableincome = Vamedcalculations::chargeableincome($totalAssessableincome, $totalreliefs);
              $overtimecallincome = Vamedcalculations::overtimecallincome($basicsalary);
              $overtimecalltax = Vamedcalculations::overtimecalltax($overtimecallincome);
              $togra = Vamedcalculations::togra($taxonbonusincome , $paye, $overtimecalltax);


              $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $count);
             	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $tinnumber);
             	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fullname);
             	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $position );
             	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, 'No');
              $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $basicsalary);
              $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, 'No');
              $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $staffssnit);
              $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, 0.00);
              $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, 0.00);
              $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, payround($bonusincome));
              $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, payround($taxonbonusincome));
              $objPHPExcel->getActiveSheet()->SetCellValue('M' . $i, payround($excessbonus));
              $objPHPExcel->getActiveSheet()->SetCellValue('N' . $i, payround($totalcashemolument));
              $objPHPExcel->getActiveSheet()->SetCellValue('O' . $i, 0.00);
              $objPHPExcel->getActiveSheet()->SetCellValue('P' .$i, 0.00);
              $objPHPExcel->getActiveSheet()->SetCellValue('Q' .$i, 0.00);
              $objPHPExcel->getActiveSheet()->SetCellValue('R' .$i, $totalAssessableincome);
              $objPHPExcel->getActiveSheet()->SetCellValue('S' .$i, 0.00);
              $objPHPExcel->getActiveSheet()->SetCellValue('T' .$i, payround($totalreliefs));
              $objPHPExcel->getActiveSheet()->SetCellValue('U' .$i, payround($chargeableincome));
              $objPHPExcel->getActiveSheet()->SetCellValue('V' .$i, payround($paye));

              $objPHPExcel->getActiveSheet()->SetCellValue('W' .$i, payround($overtimecallincome));
              $objPHPExcel->getActiveSheet()->SetCellValue('X' .$i, payround($overtimecalltax));
              $objPHPExcel->getActiveSheet()->SetCellValue('Y' .$i, payround($togra));
              $objPHPExcel->getActiveSheet()->SetCellValue('Z' .$i, 0.00);
              $objPHPExcel->getActiveSheet()->SetCellValue('AA' .$i, 'N/A');


              $i++;
         }


         $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'GHANA REVENUE AUTHORITY');
         $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'DOMESTIC TAX REVENUE DIVISION');
         $objPHPExcel->getActiveSheet()->SetCellValue('C4', 'EMPLOYERS MONTHLY TAX DEDUCTIONS SCHEDULE (P. A. Y. E.)');

        $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'CURRENT TAX OFFICE');
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Adabraka');

        $objPHPExcel->getActiveSheet()->SetCellValue('A7', 'NAME OF EMPLOYER');
        $objPHPExcel->getActiveSheet()->SetCellValue('B7',  COMPANYNAME);

        $objPHPExcel->getActiveSheet()->SetCellValue('A8', 'EMPLOYER TIN');
        $objPHPExcel->getActiveSheet()->SetCellValue('B8', 'C	0	0	0	1	8	8	8	0	5	6');


       //Styling of Style sheet

        $objPHPExcel->getActiveSheet()->mergeCells('D2:S2');
        $objPHPExcel->getActiveSheet()->mergeCells('D3:S3');
        $objPHPExcel->getActiveSheet()->mergeCells('C4:S4');

        $styleHeader = array(
             'font'  => array(
             'bold'  => true,
             'color' => array('rgb' => '000000'),
             'size'  => 13,
             'name'  => 'Calibri'
          ));

        $titleHeader = array(
             'font'  => array(
             'bold'  => true,
             'color' => array('rgb' => '000000'),
             'size'  => 10,
             'name'  => 'Calibri'
          ));



     $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($styleHeader);
     $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleHeader);
     $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($styleHeader);

     $objPHPExcel->getActiveSheet()->getStyle('A10:AA10')->applyFromArray($titleHeader);




        $imgpath = URLROOT.'/img/gralogo.jpg';

        $gdImage = imagecreatefromjpeg($imgpath);

        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('GRA LOGO');
        $objDrawing->setDescription('GRA LOGO');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(80);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setTitle('Monthly');

        ob_end_clean();
        header( "Content-type: application/vnd.ms-excel" );
        header('Content-Disposition: attachment; filename="paye.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

     }









}



?>
