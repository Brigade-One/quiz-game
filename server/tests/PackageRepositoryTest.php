<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Repository\IDGenerator;
use Server\Models\Package;
use Server\Repository\PackageRepository;
use Server\Repository\UserRepository;

class PackageRepositoryTest extends TestCase
{
    private $packageRepository;
    private $database;
    private $queryExecutor;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db_3', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->packageRepository = new PackageRepository($this->queryExecutor, $idGenerator);

    }
    public function testCreatePackage(): void
    {
        // Create a new package
        $package = new Package(
            null,
            'Demo package',
            false,
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
        $testID = 'f50717e6-637b-472f-b0c0-629a51f6ba8a';
        $package = $this->packageRepository->fetchByID($testID);
        $package->setIsApproved(true);
        $package->setName("UpdatedPackageName");
        $this->packageRepository->update($package);
        $package = $this->packageRepository->fetchByID($testID);
        $this->assertEquals('UpdatedPackageName', $package->getName());
        $this->assertEquals(true, $package->getIsApproved());
    }

}