<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$loop->addPeriodicTimer(1, function() {
    echo "Hello\n";
});

$loop->run();