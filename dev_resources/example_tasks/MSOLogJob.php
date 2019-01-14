<?php
/**
 * Created by PhpStorm.
 * User: astro
 * Date: 06-Jan-18
 * Time: 14:09
 */

class MSOLogJob extends MarketplaceJob {

    public function run(){

        /*
         * unique to this job, we will loop through customers and tenant ids and log them
         */

        $jro =& $this->recordObject;
        $queue = unserialize($jro->queuedata);
        if(!isset($jro->processed)){
        	$jro->processed = 0;
        }
        $batchcount = 0;
        foreach ($queue as $index => $item){
        	$cid = $item->cid;
        	$runit = MSOLogger::msoLogSubscriptionUsage($cid);
        	$jro->processed++;
        	$jro->lastprocessed = $cid;
        	$jro->lasttimestamp = date('Y-m-d H:i:s');
        	unset($queue[$index]);
        	$workremain = serialize($queue);
        	$jro->queuedata = $workremain;
        	$this->store();
        	if($batchcount >= ($jro->batchsize -1)){
        		break;
	        }
	        $batchcount ++;

        }


    }

    public function getInitialBatch(){
        $customertenants = Customer::getCidsTenantIds();
        return $customertenants;
    }

}