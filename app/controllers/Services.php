<?php

class Services extends Controller {


    //Antispam API Controller
    /*
     * Altering this to also accept a single cid -
     * In order to work in batches as a scheduled task, this
     * is required.
     */
    public function antispamLog($cid = null){

        $result = AntispamData::getAntispamCustomers($cid);

        foreach($result as $sp){
            $antispamname = $sp->antispam;
            $an = new Antispam();
            $result = $an->getAntispam($antispamname);
            $xml = new SimpleXMLElement($result);
            // echo '<pre>';
            // print_r($xml);

            $name = $xml->Domain_Group->name;
            $antidate = $xml->Domain_Group->date;
            $licencecount = $xml->Domain_Group->licensecount;
            $weeklyaverage = $xml->Domain_Group->weeklyaverage;

            $antispamdata = new AntispamData();
            $datarow =& $antispamdata->recordObject;
            $datarow->antispam = $name;
            $datarow->antidate = $antidate;
            $datarow->licencecount = $licencecount;
            $datarow->weeklyaverage = $weeklyaverage;
            $datarow->logdate = date('Y-m').'-01';

            echo $name. '--------------'.$weeklyaverage.'<br/>';

            if($datarow->antispam != null){
                $antispamdata->store();
            }

        }
    }

    // Logging Maximum Antispam API Controller
    public function maximumAntispamLog(){
        $mx = new MaxAntispamlog();
        $result = $mx->getMaxAntispamlog();
        $xml = new SimpleXMLElement($result);

        $dailyusage = $xml->Max_Daily_Usage;
        $averageusage = $xml->Average_Daily_Usage;

        $maxspamdata = new MaxAntispamData();
        $datarow =& $maxspamdata->recordObject;
        $datarow->dailyusage = $dailyusage;
        $datarow->averageusage = $averageusage;
        $datarow->logdate = date('Y-m-d');

        $maxspamdata->store();

    }

    // Monitoring API Controller

    public function monitoringLog(){

        $mo = new Monitoring();
        $result = $mo->getMonitoring();

        foreach($result['result'] as $mon){
            $hostname = $mon['hostname'];
            $hostgroup =  $mon['attributes']['tag_Hostgroup'];


            $monitoringdata = new MonitoringData();
            $datarow =& $monitoringdata->recordObject;
            $datarow->hostname = $hostname;
            $datarow->hostgroup = $hostgroup;
            $datarow->datadate = date('Y-m').'-01';

            if($datarow->hostname != null){
                $monitoringdata->store();
            }
        }
    }


    /**
     * @param $dateToLog
     *
     * $dateToLog must be Y-m-d for the first date of the
     * desired log month.
     *
     * @throws frameworkError
     */
    public function bitDefenderMonthlyLog($dateToLog){

        $effectivedate = date($dateToLog);


        $result = BitDefender::getBitCompanies();

        BitDefenderData::flagAllForDelete($effectivedate);


        foreach($result->result as $key=>$bit){

            $company = $bit->name;
            $companyid = $bit->id;
            $targetDate = date('m/Y',strtotime($effectivedate));
            //$targetDate = 'February 2018';
            $licenceresult = BitDefender::getMonthlyUsage($companyid, $targetDate);
            $lic = $licenceresult->result;

            $endpointMonthlyUsage  = $lic->endpointMonthlyUsage;
            $encryptionMonthlyUsage = $lic->encryptionMonthlyUsage;
            $exchangeMonthlyUsage = $lic->exchangeMonthlyUsage;

            $bitdata = new BitDefenderData();
            $datarow =&  $bitdata->recordObject;
            $datarow->company = $company;
            $datarow->companyid = $companyid;
            $datarow->endpointquantity = $endpointMonthlyUsage;
            $datarow->exchangequantity = $exchangeMonthlyUsage;
            $datarow->encryptionquantity = $encryptionMonthlyUsage;
            $datarow->effective_date = $effectivedate;
            $bitdata->store();
            echo '<pre>';
            echo  $company .'---------------------'.$endpointMonthlyUsage.'<br/>';

        }

        BitDefenderData::deleteFlagged($effectivedate);

    }


    public function msusers($type){
        $msuserdata = MicrosoftSubscriptions::getNewMicrosoftPartner($type);

        if($type == 'Germany'){ $type = 'DE'; }
        //print_r($res['items']);
        foreach($msuserdata->items as $key=>$ms){
            $tenantid = $ms->companyProfile->tenantId;
            $domain =   $ms->companyProfile->domain;
            $companyname = $ms->companyProfile->companyName;
            $relation  =  $ms->companyProfile->relationshipToPartner;
            //exit;
            $customercount = Customer::checkcustomerTenant($tenantid);


            if($customercount == 0){
                echo '<pre>';
                echo $companyname .'----------------------------'.$customercount.'<br/>';
                $customerdata = new Customer();
                $datarow =&  $customerdata->recordObject;
                $datarow->companyname = $companyname;
                $datarow->domain = $domain;
                $datarow->type = $type;
                $customerdata->store();
                $cid = $datarow->cid;
                Customer::enterCustomerTenants($cid, $tenantid);
            }
        }


    }

    public static function azurePriceLog($type){
        $prices = MicrosoftSubscriptions::getAzurePrizes($type);
        $meterobject = $prices->meters;
        $currency = $prices->currency;

        foreach($meterobject as $key=>$m){

            $meterid =  $m->id;
            $metername =  $m->name;
            $category =  $m->category;
            $subcategory = $m->subcategory;
            $rates = $m->rates;
            $quantity =  $m->includedQuantity;
            $unit =   $m->unit;
            $effectivedate = $m->effectiveDate;

            $azuredata = new AzurePrices();
            $datarow =&  $azuredata->recordObject;
            $datarow->type = $type;
            $datarow->id = $meterid;
            $datarow->name = $metername;
            $datarow->category = $category;
            $datarow->subcategory = $subcategory;
            $datarow->rate = $rates;
            $datarow->includedQuantity = $quantity;
            $datarow->effectivedate = $effectivedate;
            $datarow->currency = $currency;
            $datarow->unit = $unit;
            $azuredata->store();



        }
        return "stored " . count($meterobject) . " meters";


    }

    public function LogMsOffers($region){

        $subs = MicrosoftSubscriptions::getMSSubscriptionOffers('DE',$region);
        $list = $subs->items;
        // echo '<pre>';
        // print_r($subs->items);
        // echo '</pre>';
        SubscriptionOffer::flagAllForDelete($region);

        foreach($list as $get){

            $offername = $get->name;
            $offerid = $get->id;
            $category = $get->category->name;
            $addon  = $get->isAddOn;
            if($addon == ''){$addon = 0;}
            $msdata = new SubscriptionOffer();
            $datarow =&  $msdata->recordObject;
            $datarow->offername = $offername ;
            $datarow->offerid = $offerid;
            $datarow->category = $category;
            $datarow->addon = $addon;
            $datarow->region = $region;

            $msdata->store();

        }
        SubscriptionOffer::deleteFlagged($region);




    }




}
