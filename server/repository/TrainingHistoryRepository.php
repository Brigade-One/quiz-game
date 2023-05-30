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
        $query = "SELECT * FROM TrainingHistory";

        $parameters = [];
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
    //TODO: ADD dublication check
    public function fetchByID(string $historyID): TrainingHistory
    {
        $query = "SELECT * FROM TrainingHistory WHERE historyID = :historyID";

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
        $query = "SELECT * FROM TrainingHistory WHERE userID = :userID";

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

    public function create(TrainingHistory $trainingHistory): bool
    {
        $query = "INSERT INTO TrainingHistory (historyID, userID, packageID, trainingDate, correctAnswers, totalQuestions) VALUES (:historyID, :userID, :packageID, :trainingDate, :correctAnswers, :totalQuestions)";
        $generatedID = $this->idGenerator->generateID();
        $trainingHistory->setHistoryID($generatedID);
        $parameters = [
            ':historyID' => $generatedID,
            ':userID' => $trainingHistory->getUserID(),
            ':packageID' => $trainingHistory->getPackageID(),
            ':trainingDate' => $trainingHistory->getTrainingDate()->format('Y-m-d'),
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
        $query = "UPDATE TrainingHistory SET userID = :userID, packageID = :packageID, trainingDate = :trainingDate, correctAnswers = :correctAnswers, totalQuestions = :totalQuestions WHERE historyID = :historyID";
        $parameters = [
            ':historyID' => $trainingHistory->getHistoryID(),
            ':userID' => $trainingHistory->getUserID(),
            ':packageID' => $trainingHistory->getPackageID(),
            ':trainingDate' => $trainingHistory->getTrainingDate()->format('Y-m-d'),
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
        $query = "DELETE FROM TrainingHistory WHERE historyID = :historyID";
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
}