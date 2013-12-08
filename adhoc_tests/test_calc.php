<?php
require_once '../vendor/autoload.php';

use Bert\Bert\Rpc\Service;

$svc = new Service('localhost', 8000);
$r = $svc->call()->calculator()->add(1, 2);
var_dump($r);