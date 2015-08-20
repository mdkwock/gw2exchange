<?php
namespace GW2Exchange\Queue;

class FileQueue extends \PHPQueue\JobQueue
{
    private $jobs = array();
    private $filePath;
    private $lastSynced; //a time stamp of the last time that the file storage was synced
    protected $workerName;
    private static $lockFile = '/file.lock';

    public function __construct()
    {
        parent::__construct();
        $this->filePath = __DIR__.'/test.queue';
        $this->jobs = $this->readFile($this->filePath);
    }
    public function __destruct()
    {
        $this->writeFile($this->filePath, $this->jobs);
    }

    public function setWorkerName($workerName){
        $this->workerName = $workerName;
    }
    public function readFile($filePath){
        $data = array();
        if (is_file($filePath)) {
            $temp = unserialize(file_get_contents($filePath));
            if (is_array($temp)) {
                $data = $temp;
            }
        }
        return $data;    
    }

    public function writeFile($filePath,$jobs){
        file_put_contents($filePath, serialize($jobs));
    }

    public function addJob($newJob = null)
    {
        if(!is_file(__DIR__.static::$lockFile)){
            $fh = fopen(__DIR__.static::$lockFile, 'w');
            fclose($fh);
            $this->jobs = $this->readFile($this->filePath);
            parent::addJob($newJob);
            array_unshift($this->jobs, $newJob);
            $this->writeFile($this->filePath, $this->jobs);
            
            unlink(__DIR__.static::$lockFile);
            return true;
        }else{
            return false;
        }
    }
    public function getJob($jobId = null)
    {

        if(!is_file(__DIR__.static::$lockFile)){
            $fh = fopen(__DIR__.static::$lockFile, 'w');
            fclose($fh);
            $this->jobs = $this->readFile($this->filePath);
            parent::getJob();
            if ( empty($this->jobs) ) {
                throw new \Exception("No more jobs.");
            }
            $jobData = array_pop($this->jobs);            
            $nextJob = new \PHPQueue\Job();
            $nextJob->data = $jobData;
            $nextJob->worker = $this->workerName;
            
            $this->writeFile($this->filePath, $this->jobs);
            unlink(__DIR__.static::$lockFile);
        }
        return $nextJob;
    }
    public function getQueueSize()
    {
        parent::getQueueSize();
        return count($this->jobs);
    }
}