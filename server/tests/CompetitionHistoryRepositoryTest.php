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
        $testPackageID = '191b9fbf-bd57-4323-8be6-2cdc942e7e82';
        $testP1ID = '65b22f77-849a-49cd-a9ff-a43316779c49';
        $testP2ID = '6f5aa13c-4de4-4ebc-916a-766fc8928bad';
        $testDate = '2023-06-03 08:00:00';
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
        $testID = '8fd2461a-c28d-4f44-85fe-cc6b96af6390';
        $history = $this->historyRepository->fetchByID($testID);
        // Link with other package
        $dateTime = new DateTime('2023-05-30 10:00:00');
        $history->setCompetitionDate($dateTime);
        $result = $this->historyRepository->update($history);
        $this->assertTrue($result);
    }
    public function testFetchUserCompetititonAccuracyByUserID()
    {
        $testUserID = '65b22f77-849a-49cd-a9ff-a43316779c49';
        $result = $this->historyRepository->fetchUserCompetititonAccuracyByUserID($testUserID);
        $this->assertNotEmpty($result);
        var_dump($result);
    }
}