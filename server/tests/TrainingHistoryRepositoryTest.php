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
        $testPackageID = '65a9912a-2920-4ece-bce7-a0446f59bf95';
        $testUserID = '65b22f77-849a-49cd-a9ff-a43316779c49';
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

        // Save the package to the database
        $result = $this->historyRepository->create($history);

        // Assert that the package was successfully saved to the database        
        $result = $this->historyRepository->fetchByUserID($testUserID);
        $this->assertNotEmpty($result);
    }
    public function testFetchAll()
    {
        $links = $this->historyRepository->fetchAll();
        $this->assertNotEmpty($links);
    }
     public function testUpdate()
     {
         $testID = 'badbd67d-d52d-4949-9662-cf4ee7ef227c';
         $history = $this->historyRepository->fetchByID($testID);
         $dateTime = new DateTime('2024-05-20');
         $history->setTrainingDate($dateTime);
         $result = $this->historyRepository->update($history);
         $this->assertTrue($result);
     }
 
    public function testFetchUserTrainingAccuracyByUserID()
    {
        $testUserID = '65b22f77-849a-49cd-a9ff-a43316779c49';
        $result = $this->historyRepository->fetchUserTrainingAccuracyByUserID($testUserID);
        $this->assertNotEmpty($result);
     /*    var_dump($result); */
    }

    public function testFetchLastTrainingDate()
    {
        $testUserID = '65b22f77-849a-49cd-a9ff-a43316779c49';
        $result = $this->historyRepository->fetchLastTrainingDate($testUserID);
        $this->assertNotEmpty($result);
/*         var_dump($result); */
    }

}