<?php

namespace Server\Services;

use PDO;

class UserPool
{
    private $pdo;
    private $tableName;

    public function __construct()
    {
        // Configure database connection
        $dsn = 'mysql:host=localhost;dbname=user_pool';
        $username = 'root';
        $password = '';

        // Create a PDO instance
        $this->pdo = new PDO($dsn, $username, $password);

        // Define the table name for storing user pool data
        $this->tableName = 'UserPool';
    }
    public function addUser($userID)
    {
        // Check if the user already exists in the table
        $query = "SELECT COUNT(*) FROM $this->tableName WHERE user_id = :userID";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $count = $statement->fetchColumn();

        if ($count > 0) {
            // User already exists, delete the existing user
            $query = "DELETE FROM $this->tableName WHERE user_id = :userID";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':userID', $userID);
            $statement->execute();
        }

        // Insert the new user with the current timestamp
        $currentTimestamp = date('Y-m-d H:i:s');
        $query = "INSERT INTO $this->tableName (user_id, search_timestamp) VALUES (:userID, :timestamp)";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':userID', $userID);
        $statement->bindParam(':timestamp', $currentTimestamp);
        $statement->execute();
    }



    public function removeUser($userID)
    {
        $query = "DELETE FROM $this->tableName WHERE user_id = :userID";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':userID', $userID);
        $statement->execute();
    }

    public function getCompetitionPair()
    {
        // Calculate the threshold timestamp (current time - 30 seconds)
        $thresholdTimestamp = time() - 30;

        $query = "SELECT user_id FROM $this->tableName WHERE search_timestamp >= FROM_UNIXTIME(:thresholdTimestamp)";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':thresholdTimestamp', $thresholdTimestamp);
        $statement->execute();
        $eligibleUsers = $statement->fetchAll(PDO::FETCH_COLUMN);

        $count = count($eligibleUsers);
        if ($count < 2) {
            return null; // Not enough eligible users for competition
        }

        // Get two random eligible users from the pool
        $index1 = array_rand($eligibleUsers);
        $user1 = $eligibleUsers[$index1];
        unset($eligibleUsers[$index1]);

        $index2 = array_rand($eligibleUsers);
        $user2 = $eligibleUsers[$index2];
        unset($eligibleUsers[$index2]);

        // Return the pair of users
        return [$user1, $user2];
    }

   /*  public function removeCompetitionPair($user1, $user2)
    {
        $query = "DELETE FROM $this->tableName WHERE user_id = :user1 OR user_id = :user2";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':user1', $user1);
        $statement->bindParam(':user2', $user2);
        $statement->execute();
    } */
}