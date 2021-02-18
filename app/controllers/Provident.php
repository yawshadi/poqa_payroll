<?php


class Provident extends Controller
{

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
                $tier3number = $get->tier3number;
                $staffid = $get->staffid;

                $totalprovident =  Vamedcalculations::totalprovidentfunc($basicsalary,$category);//2021

                $payrolldata[] = [
                    'fullname'=>$fullname,  'ssnitnumber'=>$ssnitnumber,
                    'basicsalary'=>$basicsalary, 'totalprovident'=> $totalprovident,'memberid'=>$tier3number,'staffid'=>$staffid
                ];
            }
            $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                         'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];

            $this->view('reports/provident', $alldata);
        }else{
            $this->view('reports/provident', $alldata);
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

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'VAMED ENGINEERING GmbH');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Ghana Branch Office');

        $objPHPExcel->getActiveSheet()->SetCellValue('B8', 'SCHEME NAME');
        $objPHPExcel->getActiveSheet()->SetCellValue('C8', 'ENTERPRISE TIER 3 Provident Fund');

        $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Contribution Month');
        $objPHPExcel->getActiveSheet()->SetCellValue('C9', date('M', strtotime($enddate)));

        $objPHPExcel->getActiveSheet()->SetCellValue('D9', 'Account No:');
        $objPHPExcel->getActiveSheet()->SetCellValue('E9', '0105004777410');

        $objPHPExcel->getActiveSheet()->SetCellValue('A11', '#');
        $objPHPExcel->getActiveSheet()->SetCellValue('B11', 'Staff Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('C11', 'Name of Contributor');
        $objPHPExcel->getActiveSheet()->SetCellValue('D11', 'Monthly Basic (GHC)');
        $objPHPExcel->getActiveSheet()->SetCellValue('E11', 'SSNIT No');
        $objPHPExcel->getActiveSheet()->SetCellValue('F11', 'Member ID ');
        $objPHPExcel->getActiveSheet()->SetCellValue('G11', '10% Monthly Contribution');



        $i = 12;

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
            $tier3number = $get->tier3number;

            $totalprovident =  Vamedcalculations::totalprovidentfunc($basicsalary,$category);//2021

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $count);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fullname);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $basicsalary );
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $ssnitnumber);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $tier3number);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $totalprovident);
            $i++;
        }

        $imgpath = URLROOT.'/img/vamed.jpg';
        $gdImage = imagecreatefromjpeg($imgpath);

        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(80);
        $objDrawing->setCoordinates('D1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setTitle('SheetOne');

        ob_end_clean();
        header( "Content-type: application/vnd.ms-excel" );
        header('Content-Disposition: attachment; filename="provident fund.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }

}