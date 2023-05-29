<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Repository\IDGenerator;
use Server\Models\CompetitionPackage;
use Server\Repository\CompetitionPackageRepository;
use Server\Repository\UserRepository;

class CPackageRepositoryTest extends TestCase
{
    private $packageRepository;
    private $userRepository;
    private $database;
    private $queryExecutor;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->userRepository = new UserRepository($this->queryExecutor, $idGenerator);
        $this->packageRepository = new CompetitionPackageRepository($this->queryExecutor, $idGenerator, $this->userRepository);

    }
    public function testCreatePackage(): void
    {
        //User who creates the package (u need to check if user is actually has EXAMINER role)
        //cause I don't think I need to do role-check on DAL level
        $user = $this->userRepository->fetchByEmail("example2@example.com");

        // Create a new package
        $package = new CompetitionPackage(
            null,
            'Demo competiton package2',
            $user->getId(),
        );
        // Save the package to the database
        $result = $this->packageRepository->create($package, $user);
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
        $testID = '7c8cae4d-6773-48ff-87c4-74b6f407946c';
        $package = $this->packageRepository->fetchByID($testID);
        $package->setName("UpdatedCompetPackageName");
        $this->packageRepository->update($package);
        $package = $this->packageRepository->fetchByID($testID);
        $this->assertEquals('UpdatedCompetPackageName', $package->getName());
    }

}