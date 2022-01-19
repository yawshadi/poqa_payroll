<?php


class Bankadvice extends Controller{


    public function index(){

        $comdata =  Companies::getCompany();
        $paydata  = Payperiod::getPayrollPeriod();

        $alldata =  ['companies'=>$comdata, 'payperiod'=>$paydata];


        if(isset($_POST['bankadvice'])){

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
                $ssnitnumber = $get->ssnitnumber;
                $otherbenefits = $get->otherbenefit;

                $account  = $get->accountnumber;
                $branchname = $get->branch;
                $bank = $get->bankname;

                $branchcode = Bank::getbanksortcode($bank, $branchname);

                //recurrent calculation
                $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
                $taxrelief = $rec->taxrelf;
                $salaryadvance =  $rec->salaryadvance;
                $staffwelfare = $rec->staffwelfare;
                $otherdeductible = $rec->otherdeductions;
                $bonus = $rec->bonus;
                $loanrepayment = $rec->loanrepayment;
  
  
  
                //payrollcalculations
                $staffssnit = Vamedcalculations::staffssnit($basicsalary,$category);  
$quantifiable= Vamedcalculations::quantifiablebenefits($basicsalary,$category);
                $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
                $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
                $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
                $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
                $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
                $rentallowance = Vamedcalculations::rentallowance($basicsalary);
                $staffprovidentfund = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
                $grossincome = Vamedcalculations::grossincome($basicsalary, $otherbenefits, $staffssnit, $staffprovidentfund); // 2021
                $loanbenefits = Vamedcalculations::loanbenefits($loanrepayment); // 2021
                  $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief,$loanbenefits,$category,$quantifiable); // 2021
                $paye =  Vamedcalculations::paye($taxableincome); // 2021 explain
                $whtonstandardovertime = Vamedcalculations::whtonstandardovertime($standardovertime);
                $whtonsatsunholovertime =  Vamedcalculations::whtonsatsunholovertime($satsunholovertime);
                $bonustax = Vamedcalculations::bonustax($bonus); // 2021
                $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye,$bonustax); //2021
                $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $totaltaxpayable, $salaryadvance, $loanrepayment,$bonus,$basicsalary,$category); // 2021
                $vamedwelfarenetsalary = Vamedcalculations::vamedwelfarenetsalary($vamednetpay, $staffwelfare,$otherdeductible);
                $employerssnit  = Vamedcalculations::employerssnit($basicsalary,$category);
                $totalssnit =  Vamedcalculations::totalssnit($staffssnit, $employerssnit,$category);
                $ssnitact  = Vamedcalculations::ssnitact($basicsalary,$category); // 2021
                $secondtier = Vamedcalculations::secondtier($basicsalary, $category,$totalssnit); // 2021
  
                $employerprovidentfund  = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
                $totalprovident =  Vamedcalculations::totalprovidentfunc($basicsalary,$category);//2021

                $payrolldata[] = [
                    'bank'=>$bank, 'accountnumber'=>$account, 'location'=>$location, 'branchcode'=>$branchcode,'fullname'=>$fullname,'vamednetpay'=>$vamedwelfarenetsalary
                ];

            }

            $alldata =  ['companies'=>$comdata, 'payrolldata'=>$payrolldata, 'payperiod'=>$paydata,
                'startdate'=>$startdate, 'enddate'=>$enddate, 'companyid'=>$companyid ];
            $this->view('reports/bankadvice', $alldata);
        }else{

            $this->view('reports/bankadvice', $alldata);
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
        $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Employee Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Location');
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Bank');
        $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Account Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Branch Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Sort Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Net Salary');


        for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $i = 6;

        foreach($empdata as $get){

            $department =  $get->department;
            $position  = $get->position;
            $fullname =  $get->surname.' '.$get->firstname;
            $basic_id = $get->basic_id;
            $category = $get->category;
            $ssnitnumber = $get->ssnitnumber;
            $location = $get->location;
            $basicsalary = $get->basicsalary;
            $ssnitnumber = $get->ssnitnumber;
            $otherbenefits = $get->otherbenefit;

            $account  = $get->accountnumber;
            $branchname = $get->branch;
            $bank = $get->bankname;

            $branchcode = Bank::getbanksortcode($bank, $branchname);

            //recurrent calculation
            $rec = Reports::getpayrollrecurrent($basic_id, $startdate, $enddate);
            $taxrelief = $rec->taxrelf;
            $salaryadvance =  $rec->salaryadvance;
            $staffwelfare = $rec->staffwelfare;
            $otherdeductible = $rec->otherdeductions;
            $bonus = $rec->bonus;
            $loanrepayment = $rec->loanrepayment;



            //payrollcalculations
            $staffssnit = Vamedcalculations::staffssnit($basicsalary,$category);  
$quantifiable= Vamedcalculations::quantifiablebenefits($basicsalary,$category);
            $totalincome = Vamedcalculations::totalincome($basicsalary, $staffssnit);
            $standardovertime = Vamedcalculations::standardovertime($basicsalary, $category);
            $teamdevelopment= Vamedcalculations::teamdevelopment($basicsalary, $category);
            $satsunholovertime = Vamedcalculations::satsunholovertime($category, $basicsalary);
            $transportvehiclemaintenance = Vamedcalculations::transportvehiclemaintenance($basicsalary);
            $rentallowance = Vamedcalculations::rentallowance($basicsalary);
            $staffprovidentfund = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
            $grossincome = Vamedcalculations::grossincome($basicsalary, $otherbenefits, $staffssnit, $staffprovidentfund); // 2021
            $loanbenefits = Vamedcalculations::loanbenefits($loanrepayment); // 2021
              $taxableincome = Vamedcalculations::taxableincome($grossincome, $taxrelief,$loanbenefits,$category,$quantifiable); // 2021
            $paye =  Vamedcalculations::paye($taxableincome); // 2021 explain
            $whtonstandardovertime = Vamedcalculations::whtonstandardovertime($standardovertime);
            $whtonsatsunholovertime =  Vamedcalculations::whtonsatsunholovertime($satsunholovertime);
            $bonustax = Vamedcalculations::bonustax($bonus); // 2021
            $totaltaxpayable = Vamedcalculations::totaltaxpayable($paye,$bonustax); //2021
            $vamednetpay = Vamedcalculations::vamednetpay($grossincome, $totaltaxpayable, $salaryadvance, $loanrepayment,$bonus,$basicsalary,$category); // 2021
            $vamedwelfarenetsalary = Vamedcalculations::vamedwelfarenetsalary($vamednetpay, $staffwelfare,$otherdeductible);
            $employerssnit  = Vamedcalculations::employerssnit($basicsalary,$category);
            $totalssnit =  Vamedcalculations::totalssnit($staffssnit, $employerssnit,$category);
            $ssnitact  = Vamedcalculations::ssnitact($basicsalary,$category); // 2021
            $secondtier = Vamedcalculations::secondtier($basicsalary, $category,$totalssnit); // 2021

            $employerprovidentfund  = Vamedcalculations::employeeprovidentfund($basicsalary,$category);
            $totalprovident =  Vamedcalculations::totalprovidentfunc($basicsalary,$category);//2021


            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fullname);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $location);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $bank);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $account);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $branchname );
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $branchcode );
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, payround($vamedwelfarenetsalary));

            $i++;
        }


        $objPHPExcel->getActiveSheet()->SetCellValue('C2', $company);

        $imgpath = URLROOT.'/img/vamed.jpg';

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
        header('Content-Disposition: attachment; filename="bankadvice.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }









}



?>
