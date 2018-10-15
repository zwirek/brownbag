<?php
require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$read = new \React\Stream\ReadableResourceStream(STDIN, $loop);
$write = new \React\Stream\WritableResourceStream(STDOUT, $loop);

$through = new \React\Stream\ThroughStream(function($chunk) {
    return strtoupper($chunk);
});

$read->pipe($through)->pipe($write);

$loop->run();