<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\PackageQuestionLinkRepository;
use Server\Models\PackageQuestionLink;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Repository\IDGenerator;

class PQLinkRepositoryTest extends TestCase
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
        $testPackageID = '469d375a-ae5e-4bd3-b169-a9745cd888ba';
        $testQuestionID = '03cc19ff-5cd6-4b45-aec5-55ac79d03769';

        $link = new PackageQuestionLink(
            null,
            $testPackageID,
            $testQuestionID
        );

        // Save the package to the database
        $result = $this->linkRepository->create($link);
        // Assert that the package was successfully saved to the database        
        $id = $link->getLinkID();
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
        $testID = 'fe2dce4d-989d-4009-8d3e-11ffb0df5780';
        $link = $this->linkRepository->fetchByID($testID);
        // Link with other package
        $link->setPackageID('aa1d7cf2-cbe6-4d7f-ab51-213816be779d');
        $result = $this->linkRepository->update($link);
        $this->assertTrue($result);
    }

}