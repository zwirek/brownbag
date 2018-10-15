<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$counter = 0;

$interval = $loop->addPeriodicTimer(1, function() use (&$counter) {
    $counter++;

    echo "Interval number $counter\n";
});

$loop->addTimer(3, function() {
    echo "Start blocking\n";
    sleep(3);
    echo "Stop blocking\n";
});

$loop->addTimer(10, function() use ($interval, $loop) {
    $loop->cancelTimer($interval);
});

$loop->run();