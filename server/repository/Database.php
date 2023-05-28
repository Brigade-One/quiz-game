<?php
namespace Server\Repository;

use PDO;

class Database implements DatabaseInterface
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

interface DatabaseInterface
{
    public function getConnection();
}