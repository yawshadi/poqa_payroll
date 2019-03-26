<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 2/25/2019
 * Time: 12:33 PM
 */

class Ssnit extends Controller
{
    public function index(){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();
        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];

        if(isset($_POST['ssnitbtn'])){

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
                $firstname  = $get->firstname;
                $surname  = $get->surname;
                $othernames  = $get->othernames;

                $basic_id = $get->basic_id;
                $category = $get->category;
                $ssnitnumber = $get->ssnitnumber;
                $location = $get->location;
                $basicsalary = $get->basicsalary;
                $tinnumber = $get->tinnumber;
                $tiernumber = $get->tiernumber;

                //payrollcalculations
                $employerssnit = Vamedcalculations::ssnitforschedule($basicsalary);

                $payrolldata[] = [
                     'firstname'=>$firstname, 'lastname'=>$surname, 'othernames'=>$othernames,
                     'basicsalary'=>$basicsalary, 'ssnit'=>$employerssnit,
                     'ssnitnumber'=>$ssnitnumber
                ];

            }

            $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];
            $this->view('reports/ssnitreport', $alldata);
        }else {
            $this->view('reports/ssnitreport', $alldata);
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
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Firstname');
        $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Surname');
        $objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Othernames');
        $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'SNNIT Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Basic Salary');
        $objPHPExcel->getActiveSheet()->SetCellValue('G6', 'SSF (13.5%)');

        for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $i = 7;

        foreach($empdata as $key=>$get){

            $count = $key + 1;
            $company = $_POST['company'];
            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->surname.' '.$get->firstname;
            $firstname  = $get->firstname;
            $surname  = $get->surname;
            $othernames  = $get->othernames;

            $basic_id = $get->basic_id;
            $category = $get->category;
            $ssnitnumber = $get->ssnitnumber;
            $location = $get->location;
            $basicsalary = $get->basicsalary;
            $tinnumber = $get->tinnumber;
            $tiernumber = $get->tiernumber;

            //payrollcalculations
            $employerssnit = Vamedcalculations::ssnitforschedule($basicsalary);

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $count);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $surname);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $firstname);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $othernames);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ssnitnumber);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $basicsalary);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $employerssnit);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->SetCellValue('D2', COMPANYNAME);
        $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'SSNIT SCHEDULE REPORT');

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
        $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->applyFromArray($titleHeader);




        $imgpath = URLROOT.'/img/ssnitlogo.jpg';

        $gdImage = imagecreatefromjpeg($imgpath);

        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('SSNIT LOGO');
        $objDrawing->setDescription('SSNIT LOGO');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(80);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setTitle('SSNIT Schdule Report');

        ob_end_clean();
        header( "Content-type: application/vnd.ms-excel" );
        header('Content-Disposition: attachment; filename="ssnitreport.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }


}