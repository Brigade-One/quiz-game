<?php
namespace Server\Repository\Competition;

use Server\Models\CompetitionHistory;
use Server\Repository\IDGenerator;
use Server\Repository\QueryExecutor;
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
        $query = "SELECT * FROM CompetitionHistory";
        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $competitionsHistory = [];
        while ($competitionHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $competitionHistory = new CompetitionHistory(
                $competitionHistoryData['historyID'],
                $competitionHistoryData['player1ID'],
                $competitionHistoryData['player2ID'],
                $competitionHistoryData['packageID'],
                $competitionHistoryData['competitionDate'],
                $competitionHistoryData['player1CorrectAnswers'],
                $competitionHistoryData['player2CorrectAnswers'],
                $competitionHistoryData['totalQuestions'],
            );
            $competitionsHistory[] = $competitionHistory;
        }
        return $competitionsHistory;
    }
    public function fetchByID(string $historyID): ?CompetitionHistory
    {
        $query = "SELECT * FROM CompetitionHistory WHERE historyID = :historyID";

        $parameters = [':historyID' => $historyID];

        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        while ($competitionHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $competitionHistory = new CompetitionHistory(
                $competitionHistoryData['historyID'],
                $competitionHistoryData['player1ID'],
                $competitionHistoryData['player2ID'],
                $competitionHistoryData['packageID'],
                $competitionHistoryData['competitionDate'],
                $competitionHistoryData['player1CorrectAnswers'],
                $competitionHistoryData['player2CorrectAnswers'],
                $competitionHistoryData['totalQuestions'],
            );
        }
        return $competitionHistory;
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

        $competitionsHistory = [];
        while ($competitionHistoryData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $competitionHistory = new CompetitionHistory(
                $competitionHistoryData['historyID'],
                $competitionHistoryData['player1ID'],
                $competitionHistoryData['player2ID'],
                $competitionHistoryData['packageID'],
                $competitionHistoryData['competitionDate'],
                $competitionHistoryData['player1CorrectAnswers'],
                $competitionHistoryData['player2CorrectAnswers'],
                $competitionHistoryData['totalQuestions'],
            );
            $competitionsHistory[] = $competitionHistory;
        }
        return $competitionsHistory;
    }
    public function fetchUserCompetititonAccuracyByUserID(string $userID): float
    {
        $history = $this->fetchByUserID($userID);

        if (count($history) == 0) {
            return 0;
        }
        foreach ($history as $competitionHistory) {
            $totalQuestions += $competitionHistory->getTotalQuestions();
            $correctAnswers += $competitionHistory->getPlayer1ID() == $userID ? $competitionHistory->getPlayer1CorrectAnswers() : $competitionHistory->getPlayer2CorrectAnswers();
        }
        return $correctAnswers / $totalQuestions;
    }

    public function create(CompetitionHistory $competitionHistory): bool
    {
        $totalQuestionsAmount = $competitionHistory->getTotalQuestions();
        $player1CorrectAnswers = $competitionHistory->getPlayer1CorrectAnswers();
        $player2CorrectAnswers = $competitionHistory->getPlayer2CorrectAnswers();

        if ($totalQuestionsAmount < $player1CorrectAnswers || $totalQuestionsAmount < $player2CorrectAnswers) {
            throw new \PDOException("Invalid number of correct answers", 1);
        }

        $query = "INSERT INTO CompetitionHistory (historyID, player1ID, player2ID, packageID, competitionDate, player1CorrectAnswers , player2CorrectAnswers, totalQuestions) VALUES (:historyID, :player1ID, :player2ID, :packageID, :competitionDate, :player1CorrectAnswers, :player2CorrectAnswers, :totalQuestions)";

        $generatedID = $this->idGenerator->generateID();
        $competitionHistory->setHistoryID($generatedID);

        $parameters = [
            ':historyID' => $competitionHistory->getHistoryID(),
            ':player1ID' => $competitionHistory->getPlayer1ID(),
            ':player2ID' => $competitionHistory->getPlayer2ID(),
            ':packageID' => $competitionHistory->getPackageID(),
            ':competitionDate' => $competitionHistory->getCompetitionDate()->format('Y-m-d H:i:s'),
            ':player1CorrectAnswers' => $competitionHistory->getPlayer1CorrectAnswers(),
            ':player2CorrectAnswers' => $competitionHistory->getPlayer2CorrectAnswers(),
            ':totalQuestions' => $competitionHistory->getTotalQuestions(),
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
        $totalQuestionsAmount = $competitionHistory->getTotalQuestions();
        $player1CorrectAnswers = $competitionHistory->getPlayer1CorrectAnswers();
        $player2CorrectAnswers = $competitionHistory->getPlayer2CorrectAnswers();

        if ($totalQuestionsAmount < $player1CorrectAnswers || $totalQuestionsAmount < $player2CorrectAnswers) {
            throw new \PDOException("Invalid number of correct answers", 1);
        }
        $query = "UPDATE CompetitionHistory SET player1ID = :player1ID, player2ID = :player2ID, packageID = :packageID, competitionDate = :competitionDate, player1CorrectAnswers = :player1CorrectAnswers, player2CorrectAnswers = :player2CorrectAnswers, totalQuestions = :totalQuestions WHERE historyID = :historyID";
        $parameters = [
            ':historyID' => $competitionHistory->getHistoryID(),
            ':player1ID' => $competitionHistory->getPlayer1ID(),
            ':player2ID' => $competitionHistory->getPlayer2ID(),
            ':packageID' => $competitionHistory->getPackageID(),
            ':competitionDate' => $competitionHistory->getCompetitionDate()->format('Y-m-d H:i:s'),
            ':player1CorrectAnswers' => $competitionHistory->getPlayer1CorrectAnswers(),
            ':player2CorrectAnswers' => $competitionHistory->getPlayer2CorrectAnswers(),
            ':totalQuestions' => $competitionHistory->getTotalQuestions(),
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