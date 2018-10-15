<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$socket = new \React\Socket\TcpServer('0.0.0.0:8080', $loop);

$clients = 0;

$socket->on('connection', function(\React\Socket\ConnectionInterface $connection) use ($loop, &$clients){
    $clients++;

    $read = new \React\Stream\ReadableResourceStream(fopen(__DIR__ . '/../../bbb.mp4', 'r'), $loop);

    $read->pipe($connection);
    $read->on('end', function() use ($connection) {
        $connection->close();
        echo 'end', PHP_EOL;
    });

    $connection->on('close', function() use ($read, &$clients){
        $clients--;
        $read->close();
    });
});

$loop->addPeriodicTimer(5, function() use (&$clients) {
    echo 'Connected clients: ', $clients, PHP_EOL;
});

$loop->run();