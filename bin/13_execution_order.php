<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

function firstAsync(\React\EventLoop\LoopInterface $loop, callable $callback)
{
    $loop->addTimer(1, function() use ($loop, $callback) {
        $data = 'first async';

        echo $data, PHP_EOL;

        $callback($loop, $data);
    });
}

function secondAsync(\React\EventLoop\LoopInterface $loop, $data)
{
    $loop->addTimer(1, function() {
        echo 'second async', PHP_EOL;
    });
}

firstAsync($loop, 'secondAsync');

$loop->run();