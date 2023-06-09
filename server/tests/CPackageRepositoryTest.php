<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Repository\IDGenerator;
use Server\Models\CompetitionPackage;
use Server\Repository\Competition\CompetitionPackageRepository;

class CPackageRepositoryTest extends TestCase
{
    private $packageRepository;
    private $database;
    private $queryExecutor;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->packageRepository = new CompetitionPackageRepository($this->queryExecutor, $idGenerator);
    }
    public function testCreatePackage(): void
    {
        // Create a new package
        $package = new CompetitionPackage(
            null,
            'Demo competiton package',
        );
        // Save the package to the database
        $result = $this->packageRepository->create($package);
        // Assert that the package was successfully saved to the database        
        $id = $package->getPackageID();
        $result = $this->packageRepository->fetchByID($id);
        $this->assertNotEmpty($result);
    }

    public function testFetchAll()
    {
        $packages = $this->packageRepository->fetchAll();
        $this->assertNotEmpty($packages);
    }
    public function testUpdate()
    {
        $testID = '191b9fbf-bd57-4323-8be6-2cdc942e7e82';
        $package = $this->packageRepository->fetchByID($testID);
        $package->setName("UpdatedCompetPackageName");
        $this->packageRepository->update($package);
        $package = $this->packageRepository->fetchByID($testID);
        $this->assertEquals('UpdatedCompetPackageName', $package->getName());
    }

}