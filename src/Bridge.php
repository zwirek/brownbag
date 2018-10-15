<?php
declare(strict_types=1);

namespace app;

use PHPPM\Bridges\BridgeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Bridge implements BridgeInterface
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * Bootstrap an application
     *
     * @param string|null $appBootstrap The environment your application will use to bootstrap (if any)
     * @param string $appenv
     * @param boolean $debug If debug is enabled
     */
    public function bootstrap($appBootstrap, $appenv, $debug)
    {
        $pdo = new \PDO('mysql:host=mysql;dbname=test', 'root', 'password');

        $this->storage = new Storage($pdo);
    }

    /**
     * Handle the request and return a response.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        $value = sha1((string) time());

        $this->storage->store($value);

        return new \React\Http\Response(200, [], $value);
    }
}
