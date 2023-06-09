<?php

namespace Server\Repository;

use Server\Models\TrainingHistory;
use Server\Repository\IDGenerator;
use PDO;

class TrainingHistoryRepository
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
        $query =
            "SELECT *"
            . " FROM TrainingHistory";
        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $trainingHistories = [];
        while ($trainingHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $trainingHistory = new TrainingHistory(
                $trainingHistoryData['historyID'],
                $trainingHistoryData['userID'],
                $trainingHistoryData['packageID'],
                $trainingHistoryData['trainingDate'],
                $trainingHistoryData['correctAnswers'],
                $trainingHistoryData['totalQuestions'],
            );
            $trainingHistories[] = $trainingHistory;
        }
        return $trainingHistories;
    }
    public function fetchByID(string $historyID): TrainingHistory
    {
        $query =
            "SELECT *"
            . " FROM TrainingHistory"
            . " WHERE historyID = :historyID";

        $parameters = [
            ':historyID' => $historyID
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        while ($trainingHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $trainingHistory = new TrainingHistory(
                $trainingHistoryData['historyID'],
                $trainingHistoryData['userID'],
                $trainingHistoryData['packageID'],
                $trainingHistoryData['trainingDate'],
                $trainingHistoryData['correctAnswers'],
                $trainingHistoryData['totalQuestions'],
            );
        }
        return $trainingHistory;
    }


    public function fetchByUserID(string $userID): array
    {
        $query =
            "SELECT *"
            . " FROM TrainingHistory"
            . " WHERE userID = :userID";

        $parameters = [
            ':userID' => $userID
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $trainingHistories = [];
        while ($trainingHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $trainingHistory = new TrainingHistory(
                $trainingHistoryData['historyID'],
                $trainingHistoryData['userID'],
                $trainingHistoryData['packageID'],
                $trainingHistoryData['trainingDate'],
                $trainingHistoryData['correctAnswers'],
                $trainingHistoryData['totalQuestions'],
            );
            $trainingHistories[] = $trainingHistory;
        }
        return $trainingHistories;
    }

    public function fetchUserTrainingAccuracyByUserID(string $userID): float
    {
        $query =
            "SELECT SUM(correctAnswers)/SUM(totalQuestions) AS accuracy"
            . " FROM TrainingHistory"
            . " WHERE userID = :userID";

        $parameters = [
            ':userID' => $userID
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $accuracy = 0;
        while ($trainingHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $accuracy = $trainingHistoryData['accuracy'];
        }
        return $accuracy * 100;
    }

    public function fetchLastTrainingDate($userID)
    {
        $query =
            "SELECT trainingDate"
            . " FROM TrainingHistory"
            . " WHERE userID = :userID"
            . " ORDER BY trainingDate DESC"
            . " LIMIT 1";

        try {
            $statement = $this->queryExecutor->execute($query, [':userID' => $userID]);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $lastTrainingDate = null;
        while ($trainingHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $lastTrainingDate = $trainingHistoryData['trainingDate'];
        }
        return $lastTrainingDate;
    }

    public function create(TrainingHistory $trainingHistory): bool
    {
        $userID = $trainingHistory->getUserID();
        $packageID = $trainingHistory->getPackageID();
        $trainingDate = $trainingHistory->getTrainingDate()->format('Y-m-d H:i:s');

        if ($this->checkIfAlreadyExist($userID, $packageID, $trainingDate)) {
            throw new \Exception("This training history already exists");
        }
        $query =
            "INSERT INTO TrainingHistory (historyID, userID, packageID, trainingDate, correctAnswers, totalQuestions)"
            . " VALUES (:historyID, :userID, :packageID, :trainingDate, :correctAnswers, :totalQuestions)";
        $generatedID = $this->idGenerator->generateID();
        $trainingHistory->setHistoryID($generatedID);
        $parameters = [
            ':historyID' => $generatedID,
            ':userID' => $trainingHistory->getUserID(),
            ':packageID' => $trainingHistory->getPackageID(),
            ':trainingDate' => $trainingHistory->getTrainingDate()->format('Y-m-d H:i:s'),
            ':correctAnswers' => $trainingHistory->getCorrectAnswers(),
            ':totalQuestions' => $trainingHistory->getTotalQuestions(),
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() > 0;
    }

    public function update(TrainingHistory $trainingHistory): bool
    {
        $query =
            "UPDATE TrainingHistory"
            . " SET userID = :userID, packageID = :packageID, trainingDate = :trainingDate, correctAnswers = :correctAnswers, totalQuestions = :totalQuestions"
            . " WHERE historyID = :historyID";
        $parameters = [
            ':historyID' => $trainingHistory->getHistoryID(),
            ':userID' => $trainingHistory->getUserID(),
            ':packageID' => $trainingHistory->getPackageID(),
            ':trainingDate' => $trainingHistory->getTrainingDate()->format('Y-m-d H:i:s'),
            ':correctAnswers' => $trainingHistory->getCorrectAnswers(),
            ':totalQuestions' => $trainingHistory->getTotalQuestions(),
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() > 0;
    }
    public function delete(string $historyID): bool
    {
        $query =
            "DELETE FROM TrainingHistory"
            . " WHERE historyID = :historyID";
        $parameters = [
            ':historyID' => $historyID
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() > 0;
    }
    private function checkIfAlreadyExist(string $packageID, string $userID, string $trainingDate): bool
    {
        $query =
            "SELECT *"
            . " FROM TrainingHistory"
            . " WHERE packageID = :packageID AND userID = :userID AND trainingDate = :trainingDate";
        $parameters = [
            ':packageID' => $packageID,
            ':userID' => $userID,
            ':trainingDate' => $trainingDate,
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packageData = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$packageData) {
            return false;
        }
        return true;
    }
}