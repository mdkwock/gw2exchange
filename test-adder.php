<?php
require_once __DIR__ . '/vendor/autoload.php';
use \PHPQueue\Runner;
require_once __DIR__ . '/queue-config.php';

use GW2Exchange\Queue\FileQueue;
use GW2Exchange\Runner\SampleRunner;
use PHPQueue\Base;

$queueName = 'FileQueue';
//$queue = new FileQueue();
$queue = Base::getQueue($queueName);
$queue->addJob('happy');
$queue->addJob('sad');
$queue->addJob('nervous');


$runner = new SampleRunner($queueName,array('logPath'=>__DIR__));
$runner->run();