<?php

namespace Server\Services;

use PDO;

class PDOConnection
{
    private $pdo;
    public function __construct($host, $db_name, $user_name, $password)
    {
        $dsn = "mysql:host=$host;dbname=$db_name";
        $this->pdo = new PDO($dsn, $user_name, $password);
    }
    public function getConnection()
    {
        return $this->pdo;
    }
}
