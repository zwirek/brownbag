<?php
declare(strict_types=1);

namespace app;

class Storage
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function store($value)
    {
        $statement = $this->pdo->prepare('INSERT INTO `data` (`value`) VALUES :value');
        $statement->execute([
            'value' => $value
        ]);
    }
}
