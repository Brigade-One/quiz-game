<?php
namespace Server\Models;

class CompetitionHistory
{
    private $historyID;
    private $player1ID;
    private $player2ID;
    private $packageID;
    private $competitionDate;
    private $player1CorrectAnswers;
    private $player2CorrectAnswers;
    private $totalQuestions;

    public function __construct(
        ?string $historyID,
        string $player1ID,
        string $player2ID,
        string $packageID,
        ?string $competitionDate,
        int $player1CorrectAnswers,
        int $player2CorrectAnswers,
        int $totalQuestions
    ) {
        $this->historyID = $historyID;
        $this->player1ID = $player1ID;
        $this->player2ID = $player2ID;
        $this->packageID = $packageID;
        $this->competitionDate = $competitionDate ? new \DateTime($competitionDate) : null;
        $this->player1CorrectAnswers = $player1CorrectAnswers;
        $this->player2CorrectAnswers = $player2CorrectAnswers;
        $this->totalQuestions = $totalQuestions;
    }

    public function getHistoryID(): ?string
    {
        return $this->historyID;
    }
    public function getPlayer1ID(): string
    {
        return $this->player1ID;
    }
    public function getPlayer2ID(): string
    {
        return $this->player2ID;
    }
    public function getPackageID(): string
    {
        return $this->packageID;
    }
    public function getCompetitionDate(): ?\DateTime
    {
        return $this->competitionDate;
    }
    public function getPlayer1CorrectAnswers(): int
    {
        return $this->player1CorrectAnswers;
    }
    public function getPlayer2CorrectAnswers(): int
    {
        return $this->player2CorrectAnswers;
    }

    public function getTotalQuestions(): int
    {
        return $this->totalQuestions;
    }

    public function setHistoryID(string $historyID): void
    {
        $this->historyID = $historyID;
    }
    public function setPlayer1ID(string $player1ID): void
    {
        $this->player1ID = $player1ID;
    }
    public function setPlayer2ID(string $player2ID): void
    {
        $this->player2ID = $player2ID;
    }
    public function setPackageID(string $packageID): void
    {
        $this->packageID = $packageID;
    }
    public function setCompetitionDate(\DateTime $competitionDate): void
    {
        $this->competitionDate = $competitionDate;
    }
    public function setPlayer1CorrectAnswers(int $player1CorrectAnswers): void
    {
        $this->player1CorrectAnswers = $player1CorrectAnswers;
    }
    public function setPlayer2CorrectAnswers(int $player2CorrectAnswers): void
    {
        $this->player2CorrectAnswers = $player2CorrectAnswers;
    }
    public function setTotalQuestions(int $totalQuestions): void
    {
        $this->totalQuestions = $totalQuestions;
    }
}