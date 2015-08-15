<?php
namespace GW2Exchange\Queue;

class SampleQueue extends \PHPQueue\JobQueue
{
    private $jobs = array();
    private $file_path;
    private $workerName;
    public function __construct()
    {
        parent::__construct();
        $this->file_path = __DIR__.'/test.queue';
        if (is_file($this->file_path)) {
            $data = unserialize(file_get_contents($this->file_path));
            if (is_array($data)) {
                $this->jobs = $data;
            }
        }
    }
    public function __destruct()
    {
        @file_put_contents($this->file_path, serialize($this->jobs));
    }
    public function setWorkerName($workerName){
        $this->workerName = $workerName;
    }
    public function addJob($newJob = null)
    {
        parent::addJob($newJob);
        array_unshift($this->jobs, $newJob);
        return true;
    }
    public function getJob($jobId = null)
    {
        parent::getJob();
        if ( empty($this->jobs) ) {
            throw new \Exception("No more jobs.");
        }
        $jobData = array_pop($this->jobs);
        $nextJob = new \PHPQueue\Job();
        $nextJob->data = $jobData;
        $nextJob->worker = $this->workerName;
        return $nextJob;
    }
    public function getQueueSize()
    {
        parent::getQueueSize();
        return count($this->jobs);
    }


}