<?php
namespace GW2Exchange\Queue;
use \PHPQueue\JobQueue;
use \PHPQueue\Job;

class GW2Queue extends JobQueue
{
    private $dataSource;
    private $workerName;

    public function __construct()
    {
    }

    public function setWorkerName($workerName){
        $this->workerName = $workerName;
    }

    public function setDataSource($dataSource){
        $this->dataSource = $dataSource;
    }

    public function addJob($newJob = null)
    {
        $formatted_data = json_encode(array('worker'=>$this->workerName, 'data'=>$newJob));
        $this->dataSource->push($formatted_data);

        return true;
    }

    public function getJob($jobId = null)
    {
        $data = json_decode($this->dataSource->pop(),true);
        $nextJob = new Job($data, $this->dataSource->last_job_id);

        return $nextJob;
    }

    public function clearJob($jobId = null)
    {
        $this->dataSource->clear($jobId);
    }
}