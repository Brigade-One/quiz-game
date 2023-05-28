<?php
namespace Server\Repository;

use Server\Models\User;
use Server\Repository\IDGenerator;
use PDO;

class UserRepository
{
    private $queryExecutor;
    private $idGenerator;

    public function __construct(QueryExecutor $queryExecutor, IDGenerator $idGenerator)
    {
        $this->queryExecutor = $queryExecutor;
        $this->idGenerator = $idGenerator;
    }

    public function fetchAll(): array
    {
        $query = "SELECT u.*, r.roleName
                FROM users u
                JOIN roles r ON u.roleID = r.roleID";

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
                $userData['password'],
                $userData['roleName']
            );
            $users[] = $user;
        }
        return $users;
    }

    public function fetchByEmail(string $email): ?User
    {
        $query = "SELECT u.*, r.roleName
        FROM users u
        JOIN roles r ON u.roleID = r.roleID
        WHERE email = :email";

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
                $userData['password'],
                $userData['roleName']
            );

            return $user;
        }

        return null; // User not found
    }

    public function fetchById(string $id): ?User
    {
        $query = "SELECT u.*, r.roleName
        FROM users u
        JOIN roles r ON u.roleID = r.roleID
        WHERE userID = :id";

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
                $userData['password'],
                $userData['roleName']
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

        $uuid = $this->idGenerator->generateID();
        $query = "INSERT INTO users (userID, username, email, password, roleID) VALUES (:id, :name, :email, :password, :roleID)";
        $roleID = $this->getRoleIDByName($user->getRoleName());
        $parameters = [
            ':id' => $uuid,
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':roleID' => $roleID
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
        $query = "UPDATE users SET username = :username, email = :email, password = :password, roleID = :roleID WHERE userID = :id";
        $roleID = $this->getRoleIDByName($user->getRoleName());
        $parameters = [
            ':id' => $user->getId(),
            ':username' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':roleID' => $roleID
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

    private function getRoleIDByName(string $roleName): int
    {
        $query = "SELECT roleID FROM Roles WHERE roleName = :roleName";
        $parameters = [
            ':roleName' => $roleName
        ];

        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
            $roleID = $statement->fetchColumn();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $roleID;
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