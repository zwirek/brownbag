<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$interval = $loop->addPeriodicTimer(1, function() {
    echo "Interval\n";
});

$loop->addSignal(SIGINT, function($listener) use ($loop, $interval) {
    echo "SIGINT\n";

    $loop->cancelTimer($interval);
    $loop->removeSignal(SIGINT, $listener);
});

$loop->run();