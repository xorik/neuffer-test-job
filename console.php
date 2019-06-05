<?php

use App\ActionFactory;
use App\App;
use App\CsvParser;
use App\Exceptions\DomainException;
use App\Logger;

require __DIR__.'/vendor/autoload.php';

$csvParser = new CsvParser();
$actionFactory = new ActionFactory();
$logger = new Logger();

try {
    $app = new App($csvParser, $actionFactory, $logger);
    $app->run();
} catch (DomainException $e) {
    echo 'Error occurred: '.$e->getMessage()."\n";
}
