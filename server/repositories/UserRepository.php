<?php

namespace Server\Repository;

use Server\Repository\Database;
use Server\Models\User;
use PDO;

class UserRepository
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function findById(int $id): ?User
    {
        $pdo = $this->database->getConnection();

        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            // Create a new user model and set its properties from the database row
            $user = new User();
            $user->setId($userData['id']);
            $user->setName($userData['name']);
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);

            return $user;
        }

        return null; // User not found
    }

    public function create(User $user): bool
    {
        // Логика для создания нового пользователя в базе данных 
    }

    public function update(User $user): bool
    {
        // Логика для обновления информации о пользователе в базе данных 
    }

    public function delete(User $user): bool
    {
        // Логика для удаления  пользователя  
    }
}
// Call will look like this:
// $pdo = new PDO('mysql:host=localhost;dbname=database', 'root', '');
// $database = new Database($pdo);
// UserRepository($database);
