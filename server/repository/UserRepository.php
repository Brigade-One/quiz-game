<?php

namespace Server\Repository;

use Server\Models\User;
use Ramsey\Uuid\Uuid; //for uuid generation
use PDO;

class UserRepository
{
    private $queryExecutor;

    public function __construct(QueryExecutor $queryExecutor)
    {
        $this->queryExecutor = $queryExecutor;
    }
    public function fetchAll(): array
    {

        $query = "SELECT * FROM users";
        $parameters = [];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $users = [];
        while ($userData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $user = new User(
                $userData['userID'],
                $userData['username'],
                $userData['email'],
                $userData['password']
            );
            $users[] = $user;
        }
        return $users;
    }
    public function findByEmail(string $email): ?User
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $parameters = [
            ':email' => $email
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            // Create a new user model and set its properties from the database row
            $user = new User(
                $userData['userID'],
                $userData['username'],
                $userData['email'],
                $userData['password']
            );

            return $user;
        }

        return null; // User not found
    }
    public function findById(string $id): ?User
    {

        $query = "SELECT * FROM users WHERE userID = :id";
        $parameters = [
            ':id' => $id
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            // Create a new user model and set its properties from the database row
            $user = new User(
                $userData['userID'],
                $userData['username'],
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
        if ($this->checkIfEmailExists($user->getEmail())) {
            throw new \InvalidArgumentException('Email already exists');
        }
        $uuid = $this->generateUUID();
        $query = "INSERT INTO users (userID, username, email, password) VALUES (:id, :name, :email, :password)";

        $parameters = [
            ':id' => $uuid,
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword()
        ];

        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() > 0;
    }


    public function update(User $user): bool
    {
        if (!$user->validate()) {
            throw new \InvalidArgumentException('Invalid user data');
        }
        $query = "UPDATE users SET username = :username, email = :email, password = :password WHERE userID = :id";
        $parameters = [
            ':id' => $user->getId(),
            ':username' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() === 1; // One row should have been affected, exactly
    }

    public function delete(User $user): bool
    {
        if (!$user->validate()) {
            throw new \InvalidArgumentException('Invalid user data');
        }

        $query = "DELETE FROM users WHERE userID = :id";
        $parameters = [
            ':id' => $user->getId()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() === 1; // One row should have been affected, exactly
    }

    private function generateUUID(): string
    {
        return Uuid::uuid4()->toString();
    }
    private function checkIfEmailExists(string $email): bool
    {

        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $parameters = [
            ':email' => $email
        ];

        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $count = $statement->fetchColumn();
        if ($count > 0) {
            return true;
        }

        return false;
    }
}