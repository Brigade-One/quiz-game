<?php

namespace Server\Repository;

use Server\Repository\Database;
use Server\Models\User;
use Ramsey\Uuid\Uuid; //for uuid generation
use PDO;

class UserRepository
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function findById(string $id): ?User
    {
        $pdo = $this->database->getConnection();

        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':id', $id);

        try {
            $statement->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            // Create a new user model and set its properties from the database row
            $user = new User(
                $userData['id'],
                $userData['name'],
                $userData['email'],
                $userData['password']
            );

            return $user;
        }

        return null; // User not found
    }

    public function create(User $user): bool
    {
        if (!$user->validate()) {
            throw new \InvalidArgumentException('Invalid user data');
        }
        $uuid = Uuid::uuid4()->toString();
        $pdo = $this->database->getConnection();

        $query = "INSERT INTO users (id, name, email, password) VALUES (:id, :name, :email, :password)";

        $statement = $pdo->prepare($query);
        $statement->bindValue(':id', $uuid);
        $statement->bindValue(':name', $user->getName());
        $statement->bindValue(':email', $user->getEmail());
        $statement->bindValue(':password', $user->getPassword());
        $result = false;
        try {
            $result = $statement->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $result;
    }

    public function update(User $user): bool
    {
        if (!$user->validate()) {
            throw new \InvalidArgumentException('Invalid user data');
        }
        $pdo = $this->database->getConnection();

        $query = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':id', $user->getId());
        $statement->bindValue(':name', $user->getName());
        $statement->bindValue(':email', $user->getEmail());
        $statement->bindValue(':password', $user->getPassword());

        $result = false;
        try {
            $result = $statement->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $result;
    }

    public function delete(User $user): bool
    {
        if (!$user->validate()) {
            throw new \InvalidArgumentException('Invalid user data');
        }
        $pdo = $this->database->getConnection();

        $query = "DELETE FROM users WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':id', $user->getId());

        $result = false;
        try {
            $result = $statement->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $result;
    }
}
// Call will look like this:
// $pdo = new PDO('mysql:host=localhost;dbname=database', 'root', '');
// $database = new Database($pdo);
// UserRepository($database);
