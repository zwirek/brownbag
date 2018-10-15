<?php

require __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

$socket = new \React\Socket\TcpServer('0.0.0.0:8080', $loop);

$connections = [];

$socket->on('connection', function(\React\Socket\ConnectionInterface $connection) use (&$connections){
    $connection->write('Welcome.' . PHP_EOL);
    $connection->write('Enter your name: ');

    $connection->on('data', function($data) use ($connection, &$connections) {
        $name = trim($data);

        if (array_key_exists($name, $connections)) {
            $connection->write('Name: ' . $name . ' is already taken' . PHP_EOL);
            $connection->write('Enter your name: ');
            return;
        }

        if (mb_strlen($name) === 0) {
            $connection->write('Your name can not be empty.' . PHP_EOL);
            $connection->write('Enter your name: ');
            return;
        }

        $connections[$name] = $connection;

        $connection->removeAllListeners();

        $connection->write('Welcome ' . $name . PHP_EOL);
        $connection->write('There are ' . (count($connections) - 1) . ' persons on the chat. Say hello to everyone.' . PHP_EOL . PHP_EOL);

        $connection->on('data', function($data) use (&$connections, $name, $connection) {
            foreach ($connections as $conn) {
                if ($connection === $conn) {
                    continue;
                }

                $conn->write($name . ': ' . $data);
            }
        });

        $connection->on('close', function() use (&$connections, $name) {
            unset($connections[$name]);
        });
    });
});

$loop->run();