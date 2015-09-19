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

  public function workJobOnce()
  {
    $newJob = null;
    try {
      $queue = Base::getQueue($this->queue_name);
      $newJob = Base::getJob($queue);
    } catch (\Exception $ex) {
      $this->logger->addError($ex->getMessage());
    }
    if (empty($newJob)) {
      $this->logger->addNotice("No Job found.");
    } else {
      try {
        if (empty($newJob->worker)) {
          throw new Exception("No worker declared.");
        }
        if (is_string($newJob->worker)) {
          $result_data = $this->processWorker($newJob->worker, $newJob);
        } elseif (is_array($newJob->worker)) {
          $this->logger->addInfo(sprintf("Running chained new job (%s) with workers", $newJob->job_id), $newJob->worker);
          foreach ($newJob->worker as $worker_name) {
            $result_data = $this->processWorker($worker_name, $newJob);
            $newJob->data = $result_data;
          }
        }

        return Base::updateJob($queue, $newJob->job_id, $result_data);
      } catch (\Exception $ex) {
        $this->logger->addError($ex->getMessage());
        $this->logger->addInfo(sprintf('Releasing job (%s).', $newJob->job_id));
        $queue->releaseJob($newJob->job_id);
      }
    }
  }

  public function runOnce()
  {
    $this->setup();
    $this->beforeLoop();
    $this->checkAndCycleLog();
    $this->workJobOnce();
    dd('hi');
  }
}