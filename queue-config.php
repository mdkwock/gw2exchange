<?php
require_once 'vendor/autoload.php';
use PHPQueue\Base;

Base::$queue_namespace = '\GW2Exchange\Queue';
Base::$worker_namespace = '\GW2Exchange\Worker';