<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$read = new \React\Stream\ReadableResourceStream(STDIN, $loop);
$write = new \React\Stream\WritableResourceStream(STDOUT, $loop);

$read->pipe($write);

$loop->run();