<?php
namespace GW2Exchange\Runner;
use GW2Exchange\Item\ItemAssembler;
use \PHPQueue\Runner;
use \PHPQueue\Base;

class GW2Runner extends Runner
{
    protected $itemAssembler;
    protected $priceAssembler;

    public function __construct($queue='', $options=array()){
      parent::__construct($queue, $options);
      $this->itemAssembler = $options['ItemAssembler'];
      $this->priceAssembler = $options['PriceAssembler'];
    }

    protected function processWorker($worker_name, $new_job)
    {
        $this->logger->addInfo(sprintf("Running new job (%s) with worker: %s", $new_job->job_id, $worker_name));
        $worker = Base::getWorker($worker_name);
        $worker->init($this->itemAssembler,$this->priceAssembler);//add the required classes into the worker
        Base::workJob($worker, $new_job);
        $this->logger->addInfo(sprintf('Worker is done. Updating job (%s). Result:', $new_job->job_id), $worker->result_data);

        return $worker->result_data;
    }


    public function run()
    {
        $this->setup();
        $this->beforeLoop();
        $this->loop();
    }
}