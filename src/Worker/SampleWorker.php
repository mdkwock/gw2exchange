<?php
namespace GW2Exchange\Worker;
use \PHPQueue\Worker;
class SampleWorker extends Worker
{
    /**
     * @param \PHPQueue\Job $jobObject
     */
    public function runJob($jobObject)
    {
        parent::runJob($jobObject);
        $jobData = $jobObject->data;
        if(is_array($jobData)){
            $jobData['var2'] = "Welcome back!";
        }else{
            $orig = $jobData;
            $jobData = array($orig);
            $jobData['var2'] = "Welcome back!";    
        }
        
        d($jobData);
        $this->result_data = $jobData;
    }
}