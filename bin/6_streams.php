<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$stream = new \React\Stream\ReadableResourceStream(STDIN, $loop);

$stream->on('data', function($chunk) {
    echo "$chunk\n";
});

$loop->run();