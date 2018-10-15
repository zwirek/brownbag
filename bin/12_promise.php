<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

function asyncSuccess(\React\EventLoop\LoopInterface $loop)
{
    $deferred = new \React\Promise\Deferred();

    $loop->addTimer(2, function() use ($deferred) {
        $deferred->resolve('Hello World!');
    });

    return $deferred->promise();
}

asyncSuccess($loop)
    ->then(function($data) {
        echo $data, PHP_EOL;
    });



##############################
##############################
##############################


function asyncFail(\React\EventLoop\LoopInterface $loop)
{
    $deferred = new \React\Promise\Deferred();

    $loop->addTimer(2, function() use ($deferred) {
        $deferred->reject('Something went wrong :(');
    });

    return $deferred->promise();
}

asyncFail($loop)
    ->then(function($data) {
        echo $data, PHP_EOL;
    },function ($reason) {
        echo 'Rejected: ',$reason, PHP_EOL;
    });

$loop->run();