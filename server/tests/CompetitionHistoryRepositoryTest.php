<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\Competition\CompetitionHistoryRepository;
use Server\Models\CompetitionHistory;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Repository\IDGenerator;

class CompetitionHistoryRepositoryTest extends TestCase
{
    private $historyRepository;
    private $database;
    private $queryExecutor;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->historyRepository = new CompetitionHistoryRepository($this->queryExecutor, $idGenerator);
    }
    public function testCreateTrainingHistory(): void
    {
        $testPackageID = '7c8cae4d-6773-48ff-87c4-74b6f407946c';
        $testP1ID = '801f6709-042e-4fa7-9b2e-a28958b9cdf0';
        $testP2ID = 'd08adb1a-353a-47cf-b829-efc386c58e79';
        $testDate = '2023-05-31 08:00:00';
        $testP1CorrectAnswers = 40;
        $testP2CorrectAnswers = 30;
        $testTotalQuestions = 50;

        $history = new CompetitionHistory(
            null,
            $testP1ID,
            $testP2ID,
            $testPackageID,
            $testDate,
            $testP1CorrectAnswers,
            $testP2CorrectAnswers,
            $testTotalQuestions
        );

        // Save the package to the database
        $result = $this->historyRepository->create($history);

        // Assert that the package was successfully saved to the database        
        $result = $this->historyRepository->fetchByUserID($testP1ID);
        $this->assertNotEmpty($result);
    }
    public function testFetchAll()
    {
        $history = $this->historyRepository->fetchAll();
        $this->assertNotEmpty($history);
    }
    public function testUpdate()
    {
        $testID = 'b7964e9e-af52-4cb9-97ae-272350493dfe';
        $history = $this->historyRepository->fetchByID($testID);
        // Link with other package
        $dateTime = new DateTime('2023-05-30 10:00:00');
        $history->setCompetitionDate($dateTime);
        $result = $this->historyRepository->update($history);
        $this->assertTrue($result);
    }

}