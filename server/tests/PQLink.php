<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\PackageQuestionLinkRepository;
use Server\Models\PackageQuestionLink;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Repository\IDGenerator;

class PQLink extends TestCase
{
    private $linkRepository;
    private $database;
    private $queryExecutor;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->linkRepository = new PackageQuestionLinkRepository($this->queryExecutor, $idGenerator);
    }
    public function testCreatePackageQuestionLink(): void
    {
        $testPackageID = '47c01ae1-387c-4d6d-9b44-b72036fb8a36';
        $testQuestionID = '03cc19ff-5cd6-4b45-aec5-55ac79d03769';

        $link = new PackageQuestionLink(
            null,
            $testPackageID,
            $testQuestionID
        );
        
        // Save the package to the database
        $result = $this->linkRepository->create($link);
        // Assert that the package was successfully saved to the database        
        $id = $link->getPackageID();
        $result = $this->linkRepository->fetchByID($id);
        $this->assertNotEmpty($result);
    }
    public function testFetchAll()
    {
        $links = $this->linkRepository->fetchAll();
        $this->assertNotEmpty($links);
    }
    public function testUpdate()
    {
        $testID = '';
        $link = $this->linkRepository->fetchByID($testID);
    }

}