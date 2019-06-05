<?php

use App\ActionFactory;
use App\App;
use App\CsvParser;
use App\Exceptions\DomainException;

require __DIR__.'/vendor/autoload.php';

$csvParser = new CsvParser();
$actionFactory = new ActionFactory();

try {
    $app = new App($csvParser, $actionFactory);
    $app->run();
} catch (DomainException $e) {
    echo 'Error occurred: '.$e->getMessage()."\n";
}
