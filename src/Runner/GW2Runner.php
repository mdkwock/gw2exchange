<?php
namespace GW2Exchange\Runner;
use GW2Exchange\Item\ItemAssembler;

class GW2Runner extends Runner
{
    private $itemAssembler;

    public function __construct($queue='', $options=array()){
      parent::__construct($queue, $options);
      $this->itemAssembler = $options['ItemAssembler'];
    }

    protected function processWorker($worker_name, $new_job)
    {
        $this->logger->addInfo(sprintf("Running new job (%s) with worker: %s", $new_job->job_id, $worker_name));
        $worker = Base::getWorker($worker_name);
        $worker->init($this->itemAssembler);//add the required classes into the worker
        Base::workJob($worker, $new_job);
        $this->logger->addInfo(sprintf('Worker is done. Updating job (%s). Result:', $new_job->job_id), $worker->result_data);

        return $worker->result_data;
    }
}