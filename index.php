<?php

require __DIR__ . '/vendor/autoload.php';

$pdo = new PDO('mysql:host=mysql;dbname=test', 'root', 'password');

$storage = new \app\Storage($pdo);

$value = sha1((string) time());

echo $value;

$storage->store($value);

