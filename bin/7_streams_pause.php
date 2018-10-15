<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$stream = new \React\Stream\ReadableResourceStream(STDIN, $loop, 1);

$stream->on('data', function($chunk) use ($stream, $loop) {
    echo "$chunk\n";

    $stream->pause();

    $loop->addTimer(0.2, function() use ($stream) {
        $stream->resume();
    });
});

$loop->run();