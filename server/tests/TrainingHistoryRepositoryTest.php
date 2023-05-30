<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\TrainingHistoryRepository;
use Server\Models\TrainingHistory;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Repository\IDGenerator;

class TrainingHistoryRepositoryTest extends TestCase
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
        $this->historyRepository = new TrainingHistoryRepository($this->queryExecutor, $idGenerator);
    }
    public function testCreateTrainingHistory(): void
    {
        $testPackageID = '469d375a-ae5e-4bd3-b169-a9745cd888ba';
        $testUserID = '801f6709-042e-4fa7-9b2e-a28958b9cdf0';
        $testDate = '2023-05-20';
        $testCorrectAnswers = 20;
        $testTotalQuestions = 50;

        $history = new TrainingHistory(
            null,
            $testUserID,
            $testPackageID,
            $testDate,
            $testCorrectAnswers,
            $testTotalQuestions
        );

        var_dump($history->getTrainingDate());

        // Save the package to the database
        $result = $this->historyRepository->create($history);

        // Assert that the package was successfully saved to the database        
        $id = $history->getHistoryID();
        $result = $this->historyRepository->fetchByUserID($testUserID);
        var_dump($result);
        $this->assertNotEmpty($result);
    }
    public function testFetchAll()
    {
        $links = $this->historyRepository->fetchAll();
        $this->assertNotEmpty($links);
    }
    public function testUpdate()
    {
        $testID = 'a52bfcf1-3416-4c12-986c-d23cd761b27e';
        $history = $this->historyRepository->fetchByID($testID);
        // Link with other package
        $dateTime = new DateTime('2024-05-20');
        $history->setTrainingDate($dateTime);
        $result = $this->historyRepository->update($history);
        $this->assertTrue($result);
    }
    
}