<?php
/**
 * Created by PhpStorm.
 * User: astro
 * Date: 06-Jan-18
 * Time: 11:39
 */



class Jobs {

    public static function runjobs($jobid = null){

        // Don't require check for jobkey if DEVMODE is set
        if(DEVMODE !== true) {
            if (!isset($_REQUEST['jobkey']) || $_REQUEST['jobkey'] != JOBSEC) {
                throw new frameworkError("Missing or incorrect security secret");
            }
        }

        $files = glob(APPROOT . '/tasks' . '/*.php');

        foreach ($files as $file) {
            require($file);
        }

        if(!$nextjob = frameworkJob::getNext()){
        	/*
        	 * no jobs to run currently
        	 */
        	throw new frameworkError("No jobs pending to run");
        } else {
        	/*
        	 * activate() the job.
        	 */
        	$jobid = $nextjob->jobid;
        	$jobclass = $nextjob->jobmethod;
        	$jobobj = new $jobclass($jobid);

        	$jobobj->activate();
        	throw new frameworkError("Ran a batch of " . $jobobj->recordObject->jobmethod);

        }





        $runcount = 0;
        foreach($jobs as $job){
            $runthis = $job->jobmethod;
            $lastrun = new DateTime($job->lastrun);
            $now = new DateTime(date('Y-m-d H:i:s'));
            $interval = $lastrun->diff($now) ->format('%i');

            if(($interval > $job->frequencyminutes || $job->lastrun == null)
                && $job->active == 1 ){
                $jobout = new $runthis();

                // record that the job ran
                $logjob                        = new frameworkJob($job->jobid);
                $logjob->recordObject->lastrun = date( 'Y-m-d H:i:s' );
                $logjob->store();
                $runcount++;
            }
        }
        exit("ran $runcount jobs");
    }

    public static function jobQApi($jobid = null){
        if(isset($jobid)){
            // store single job in an array so results are
            // the same format no matter if 1 or N jobs
            $job = new frameworkJob($jobid);
            $jobs[] = $job->recordObject;
        } else {
            $jobs = frameworkJob::listAll();
        }
        $output = json_encode($jobs) . "\n";
        header("Access-Control-Allow-Origin: *");
        echo $output;
        exit();
    }

}