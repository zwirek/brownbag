<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

function firstAsync(\React\EventLoop\LoopInterface $loop)
{
    $deferred = new \React\Promise\Deferred();

    $loop->addTimer(1, function() use ($deferred) {
        $deferred->resolve('first async');
    });

    return $deferred->promise();
}

function secondAsync(\React\EventLoop\LoopInterface $loop)
{
    $deferred = new \React\Promise\Deferred();

    $loop->addTimer(2, function() use ($deferred) {
        $deferred->resolve('second async');
    });

    return $deferred->promise();
}

\React\Promise\all([
    firstAsync($loop),
    secondAsync($loop)
])->then(function($resolved) {
    var_dump($resolved);
});

$loop->run();
