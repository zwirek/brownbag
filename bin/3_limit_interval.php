<?php

require __DIR__ . "/../vendor/autoload.php";

$loop = \React\EventLoop\Factory::create();

$counter = 0;

$loop->addPeriodicTimer(1, function(\React\EventLoop\TimerInterface $timer) use (&$counter, $loop) {
    $counter++;

    if ($counter === 5) {
        $loop->cancelTimer($timer);
    }

    echo "Number $counter\n";
});

echo "Start\n";

$loop->run();

echo "End\n";
