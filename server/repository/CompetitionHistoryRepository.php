<?php
namespace Server\Repository;

use Server\Models\CompetitionHistory;
use Server\Repository\IDGenerator;
use PDO;

class CompetitionHistoryRepository
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
        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $trainingHistories = [];
        while ($trainingHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $trainingHistory = new CompetitionHistory(
                $trainingHistoryData['historyID'],
                $trainingHistoryData['player1ID'],
                $trainingHistoryData['player2ID'],
                $trainingHistoryData['packageID'],
                $trainingHistoryData['competitionDate'],
                $trainingHistoryData['player1CorrectAnswers'],
                $trainingHistoryData['player2CorrectAnswers'],
                $trainingHistoryData['totalQuestions'],
            );
            $trainingHistories[] = $trainingHistory;
        }
        return $trainingHistories;
    }
    public function fetchByID(string $historyID): ?CompetitionHistory
    {
        $query = "SELECT * FROM CompetitionHistory WHERE historyID = :historyID";

        $parameters = [
            ':historyID' => $historyID
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        while ($trainingHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $trainingHistory = new CompetitionHistory(
                $trainingHistoryData['historyID'],
                $trainingHistoryData['player1ID'],
                $trainingHistoryData['player2ID'],
                $trainingHistoryData['packageID'],
                $trainingHistoryData['competitionDate'],
                $trainingHistoryData['player1CorrectAnswers'],
                $trainingHistoryData['player2CorrectAnswers'],
                $trainingHistoryData['totalQuestions'],
            );
        }
        return $trainingHistory;
    }


    public function fetchByUserID(string $userID): array
    {
        $query = "SELECT * FROM CompetitionHistory WHERE   player1ID = :userID OR player2ID = :userID";

        $parameters = [':userID' => $userID];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $trainingHistories = [];
        while ($trainingHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $trainingHistory = new CompetitionHistory(
                $trainingHistoryData['historyID'],
                $trainingHistoryData['player1ID'],
                $trainingHistoryData['player2ID'],
                $trainingHistoryData['packageID'],
                $trainingHistoryData['competitionDate'],
                $trainingHistoryData['player1CorrectAnswers'],
                $trainingHistoryData['player2CorrectAnswers'],
                $trainingHistoryData['totalQuestions'],
            );
            $trainingHistories[] = $trainingHistory;
        }
        return $trainingHistories;
    }

    public function create(CompetitionHistory $competitionHistory): bool
    {
        $player1ID = $competitionHistory->getPlayer1ID();
        $player2ID = $competitionHistory->getPlayer2ID();
        $packageID = $competitionHistory->getPackageID();
        $competitionDate = $competitionHistory->getCompetitionDate()->format('Y-m-d H:i:s');
        $p1CorrectAnswers = $competitionHistory->getPlayer1CorrectAnswers();
        $p2CorrectAnswers = $competitionHistory->getPlayer2CorrectAnswers();
        $totalQuestions = $competitionHistory->getTotalQuestions();

        $query = "INSERT INTO CompetitionHistory (historyID, player1ID, player2ID, packageID, competitionDate, player1CorrectAnswers , player2CorrectAnswers, totalQuestions) VALUES (:historyID, :player1ID, :player2ID, :packageID, :competitionDate, :player1CorrectAnswers, :player2CorrectAnswers, :totalQuestions)";
        $generatedID = $this->idGenerator->generateID();
        $competitionHistory->setHistoryID($generatedID);
        $parameters = [
            ':historyID' => $generatedID,
            ':player1ID' => $player1ID,
            ':player2ID' => $player2ID,
            ':packageID' => $packageID,
            ':competitionDate' => $competitionDate,
            ':player1CorrectAnswers' => $p1CorrectAnswers,
            ':player2CorrectAnswers' => $p2CorrectAnswers,
            ':totalQuestions' => $totalQuestions,
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() > 0;
    }

    public function update(CompetitionHistory $competitionHistory): bool
    {
        $historyID = $competitionHistory->getHistoryID();
        $player1ID = $competitionHistory->getPlayer1ID();
        $player2ID = $competitionHistory->getPlayer2ID();
        $packageID = $competitionHistory->getPackageID();
        $competitionDate = $competitionHistory->getCompetitionDate()->format('Y-m-d H:i:s');
        $p1CorrectAnswers = $competitionHistory->getPlayer1CorrectAnswers();
        $p2CorrectAnswers = $competitionHistory->getPlayer2CorrectAnswers();
        $totalQuestions = $competitionHistory->getTotalQuestions();

        $query = "UPDATE CompetitionHistory SET player1ID = :player1ID, player2ID = :player2ID, packageID = :packageID, competitionDate = :competitionDate, player1CorrectAnswers = :player1CorrectAnswers, player2CorrectAnswers = :player2CorrectAnswers, totalQuestions = :totalQuestions WHERE historyID = :historyID";
        $parameters = [
            ':historyID' => $historyID,
            ':player1ID' => $player1ID,
            ':player2ID' => $player2ID,
            ':packageID' => $packageID,
            ':competitionDate' => $competitionDate,
            ':player1CorrectAnswers' => $p1CorrectAnswers,
            ':player2CorrectAnswers' => $p2CorrectAnswers,
            ':totalQuestions' => $totalQuestions,
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
        $query = "DELETE FROM CompetitionHistory WHERE historyID = :historyID";
        $parameters = [':historyID' => $historyID];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() > 0;
    }
}