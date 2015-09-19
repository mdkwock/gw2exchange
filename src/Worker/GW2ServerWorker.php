<?php
namespace GW2Exchange\Worker;
use \PHPQueue\Worker;
use GW2Exchange\Item\ItemAssembler;
use GW2Exchange\Price\PriceAssembler;

class GW2ServerWorker extends Worker
{
  protected $itemAssembler;
  protected $priceAssembler;

  /**
   * this function is used to insert the item assembler rather than have it be created directly in this class
   * allows for a bit more dependency inversion so more testable
   * 
   * @param  ItemAssembler $itemAssembler [description]
   * @return [type]                       [description]
   */
  public function init(ItemAssembler $itemAssembler, PriceAssembler $priceAssembler){
    $this->itemAssembler = $itemAssembler;
    $this->priceAssembler = $priceAssembler;
  }

  /**
   * Goes the gw2server and checks the information as asked
   * expects the jobObject->data to be of the form 
   * {
   *     "taskType"=>'taskType',
   *     'ids'=>''
   * }
   * @param \PHPQueue\Job $jobObject
   */
  public function runJob($jobObject)
  {
    parent::runJob($jobObject);
    $jobData = $jobObject->data;
    $itemIds = $jobData['ids'];
    switch ($jobData['taskType']) {
      case 'price':
        $this->result_data = array($this->getPrices($itemIds));
        break;      
      case 'item':
      default:
        $this->result_data = array($this->getItems($itemIds));
        break;
    }
  }

  public function getItems($itemIds){
    $items = $this->itemAssembler->getByIds($itemIds);//get all the requested items
    $count = 0;
    foreach ($items as $item) {
      $item->save();//save the item
      $count++;
    }
    return $count;
  }

  public function getPrices($itemIds){
    $prices = $this->priceAssembler->getByItemIds($itemIds);
    $count = 0;
    foreach ($prices as $price) {
      $price->save();//save the price
      $count++;
    } 
    return $count;
  }
}