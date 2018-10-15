<?php

if(file_exists('/tmp/reactphp_server.sock')) {
    unlink('/tmp/reactphp_server.sock');
}

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$socket = new \React\Socket\UnixServer('/tmp/reactphp_server.sock', $loop);

$counter = 0;

$socket->on('connection', function(\React\Socket\ConnectionInterface $connection) use (&$counter) {
    $counter++;

    echo 'Connection nr: ', $counter, ' established', PHP_EOL;

    $connection->on('data', function($data) use ($counter) {
        echo 'Data from client nr: ', $counter, ' ', $data, PHP_EOL;
    });

    $connection->on('end', function() use ($counter) {
        echo 'Client nr: ', $counter, ' disconnected', PHP_EOL;
    });
});

$loop->run();