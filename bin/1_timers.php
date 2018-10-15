<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$loop->addTimer(1, function() {
    echo "Timer\n";
});

echo "After Timer\n";

$loop->run();