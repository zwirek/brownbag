<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$conn = stream_socket_client('tcp://smtp.onet.pl:25');
$stream = new \React\Stream\DuplexResourceStream($conn, $loop);

$stream->on('data', function($chunk) use ($stream) {
    echo $chunk . PHP_EOL;

    if (false !== strpos($chunk, 'ESMTP')) {
        $stream->write("EHLO react\r\n");
    }

    if (false !== strpos($chunk, '250')) {
        $stream->write("QUIT\r\n");
    }
});

$loop->run();
