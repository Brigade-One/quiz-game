<?php
namespace Server\Models;

class TrainingHistory
{
    private $historyID;
    private $userID;
    private $packageID;
    private $trainingDate;
    private $correctAnswers;
    private $totalQuestions;

    public function __construct(
        ?string $historyID,
        string $userID,
        string $packageID,
        ?string $trainingDate,
        int $correctAnswers,
        int $totalQuestions
    ) {
        $this->historyID = $historyID;
        $this->userID = $userID;
        $this->packageID = $packageID;
        $this->trainingDate = $trainingDate ? new \DateTime($trainingDate) : null;
        $this->correctAnswers = $correctAnswers;
        $this->totalQuestions = $totalQuestions;
    }

    public function getHistoryID(): ?string
    {
        return $this->historyID;
    }
    public function getUserID(): string
    {
        return $this->userID;
    }
    public function getPackageID(): string
    {
        return $this->packageID;
    }
    public function getTrainingDate(): ?\DateTime
    {
        return $this->trainingDate;
    }
    public function getCorrectAnswers(): int
    {
        return $this->correctAnswers;
    }
    public function getTotalQuestions(): int
    {
        return $this->totalQuestions;
    }

    public function setHistoryID(string $historyID): void
    {
        $this->historyID = $historyID;
    }
    public function setUserID(string $userID): void
    {
        $this->userID = $userID;
    }
    public function setPackageID(string $packageID): void
    {
        $this->packageID = $packageID;
    }
    public function setTrainingDate(?\DateTime $trainingDate): void
    {
        $this->trainingDate = $trainingDate;
    }
    public function setCorrectAnswers(int $correctAnswers): void
    {
        $this->correctAnswers = $correctAnswers;
    }
    public function setTotalQuestions(int $totalQuestions): void
    {
        $this->totalQuestions = $totalQuestions;
    }

    public function toJSON()
    {
        return json_encode([
            'historyID' => $this->historyID,
            'userID' => $this->userID,
            'packageID' => $this->packageID,
            'trainingDate' => $this->trainingDate,
            'correctAnswers' => $this->correctAnswers,
            'totalQuestions' => $this->totalQuestions,
        ]);
    }
    public static function fromJSON(string $json): TrainingHistory
    {
        $data = json_decode($json, true);

        $historyID = $data['historyID'] ?? null;
        $userID = $data['userID'] ?? null;
        $packageID = $data['packageID'] ?? null;
        $trainingDate = $data['trainingDate'] ?? null;
        $correctAnswers = $data['correctAnswers'] ?? null;
        $totalQuestions = $data['totalQuestions'] ?? null;


        return new TrainingHistory(
            $historyID,
            $userID,
            $packageID,
            $trainingDate,
            $correctAnswers,
            $totalQuestions
        );
    }

}