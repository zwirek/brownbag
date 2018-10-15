<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

function firstAsync(\React\EventLoop\LoopInterface $loop)
{
    $deferred = new \React\Promise\Deferred();

    $loop->addTimer(1, function() use ($deferred) {
        $deferred->resolve('fastest');
    });

    return $deferred->promise();
}

function secondAsync(\React\EventLoop\LoopInterface $loop)
{
    $deferred = new \React\Promise\Deferred();

    $loop->addTimer(2, function() use ($deferred) {
        $deferred->resolve('slowest');
    });

    return $deferred->promise();
}

\React\Promise\race([
    firstAsync($loop),
    secondAsync($loop)
])->then(function($resolved) {
    echo $resolved, PHP_EOL;
});

$loop->run();