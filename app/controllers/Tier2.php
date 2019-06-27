<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 2/25/2019
 * Time: 11:52 AM
 */

class Tier2 extends Controller
{

    public function index(){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();
        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];

        if(isset($_POST['tierbtn'])){

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
                $tiernumber = $get->tiernumber;

                //payrollcalculations
                $staffssnit = Vamedcalculations::tierssnit($basicsalary);

                $payrolldata[] = [
                    'fullname'=>$fullname, 'position'=>$position, 'tiernumber'=>$tiernumber,
                    'basicsalary'=>$basicsalary, 'ssnit'=>$staffssnit
                ];

            }

            $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                         'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];
            $this->view('reports/tierreport', $alldata);
        }else {
            $this->view('reports/tierreport', $alldata);
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
    $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No:');
    $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Employee Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Postion');
    $objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Tier2 Number');
    $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Basic Salary');
    $objPHPExcel->getActiveSheet()->SetCellValue('F6', 'SSF (5%)');

    for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
    }

    $i = 7;

    foreach($empdata as $key=>$get){

        $count = $key + 1;
        $position  = $get->position;
        $fullname =  $get->surname.' '.$get->firstname;
        $basicsalary = $get->basicsalary;
        $tiernumber = $get->tiernumber;

        //payrollcalculations
        $staffssnit = Vamedcalculations::tierssnit($basicsalary);

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $count);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fullname);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $position);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $tiernumber );
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $basicsalary);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $staffssnit);
        $i++;
       }

        $objPHPExcel->getActiveSheet()->SetCellValue('D2', COMPANYNAME);
        $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'TIER 2 REPORT');

        //Merging cells
        $objPHPExcel->getActiveSheet()->mergeCells('D2:F2');
        $objPHPExcel->getActiveSheet()->mergeCells('D3:F3');

        //Applying Styles
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
        $objPHPExcel->getActiveSheet()->getStyle('A6:F6')->applyFromArray($titleHeader);




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

        $objPHPExcel->getActiveSheet()->setTitle('Tier2 Report');

        ob_end_clean();
        header( "Content-type: application/vnd.ms-excel" );
        header('Content-Disposition: attachment; filename="tier2report.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }

}