<?php
namespace GW2Exchange\Queue;
use \PHPQueue\JobQueue;
use \PHPQueue\Job;
use \PHPQueue\Interfaces\IndexedFifoQueueStore;

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
        $formatted_data = array('worker'=>$this->workerName, 'data'=>$newJob);
        $this->dataSource->push($formatted_data);

        return true;
    }

    public function getJob($jobId = null)
    {
        $data = $this->dataSource->pop();
        $nextJob = new Job($data, $this->dataSource->last_job_id);

        return $nextJob;
    }

    public function clearJob($jobId = null)
    {
        $this->dataSource->clear($jobId);
    }
}