<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Repository\IDGenerator;
use Server\Models\Package;
use Server\Models\User;
use Server\Repository\PackageRepository;
use Server\Repository\UserRepository;

class PackageRepositoryTest extends TestCase
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
        $this->packageRepository = new PackageRepository($this->queryExecutor, $idGenerator, $this->userRepository);

    }
    public function testCreatePackage(): void
    {
        //User who creates the package
        $user = $this->userRepository->fetchByEmail("example2@example.com");

        // Create a new package
        $package = new Package(
            null,
            'Demo package',
            $user->getId(),
            0,
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
        $package = $this->packageRepository->fetchByID('194f1471-f181-495d-b734-ee81c949367e');
        $package->setIsApproved(false);
        $package->setName("PackageName");
        $this->packageRepository->update($package);
        $package = $this->packageRepository->fetchByID('194f1471-f181-495d-b734-ee81c949367e');
        $this->assertEquals('PackageName', $package->getName());
        $this->assertEquals(false, $package->getIsApproved());
    }

}