<?php declare(strict_types=1);

require './vendor/autoload.php';

use Ares\AresClient;

$ares = new AresClient(['timeout' => 30]);
$entity = $ares->basic->findOneByRegNumber('45626499');

print_r($entity);
