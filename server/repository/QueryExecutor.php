<?php
namespace Server\Repository;

use PDO;
use PDOStatement;

class QueryExecutor
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function execute(string $query, array $parameters = []): PDOStatement
    {
        $statement = $this->connection->prepare($query);

        foreach ($parameters as $parameter => $value) {
            $statement->bindValue($parameter, $value);
        }

        try {
            $statement->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement;
    }
}