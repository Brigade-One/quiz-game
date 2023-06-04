<?php
use PHPUnit\Framework\TestCase;
use Server\Models\UserPackageLink;
use Server\Repository\Database;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\UserPackageLinkRepository;
use Server\Repository\PackageRepository;

class UserPackageLinkRepositoryTest extends TestCase
{
    private $queryExecutor;
    private $idGenerator;
    private $userPackageLinkRepository;
    private $packageRepository;
    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->packageRepository = new PackageRepository($this->queryExecutor, $idGenerator);
        $this->userPackageLinkRepository = new UserPackageLinkRepository($this->queryExecutor, $idGenerator);
    }
    public function testCreate()
    {
        $userID = "6f5aa13c-4de4-4ebc-916a-766fc8928bad";

        $pgID1 = "b8fef7ca-da0b-4d97-b0a3-6054d53fe6cf";
        $pgID2 = "dad3370c-e66d-4c22-84c6-4c460802b388";

        $userPackageLink1 = new UserPackageLink(null, $userID, $pgID1);
        $userPackageLink2 = new UserPackageLink(null, $userID, $pgID2);

        $userPackageLink1 = $this->userPackageLinkRepository->create($userPackageLink1);
        $userPackageLink2 = $this->userPackageLinkRepository->create($userPackageLink2);

        $this->assertNotEmpty($userPackageLink1);
        $this->assertInstanceOf('Server\Models\UserPackageLink', $userPackageLink1);
    }
    public function testFetchPackagesByUserID()
    {
        $userID = "6f5aa13c-4de4-4ebc-916a-766fc8928bad";

        $packages = $this->userPackageLinkRepository->fetchPackagesByUserID($userID);
        $this->assertIsArray($packages);
        $this->assertNotEmpty($packages);
        $this->assertContainsOnlyInstancesOf('Server\Models\Package', $packages);
        var_dump($packages);
    }

    public function testFetchUserPackagesNumber()
    {
        $userID = "6f5aa13c-4de4-4ebc-916a-766fc8928bad";
        $userPackagesNumber = $this->userPackageLinkRepository->fetchUserPackagesNumber($userID);
        $this->assertIsInt($userPackagesNumber);
        $this->assertNotEmpty($userPackagesNumber);

        var_dump($userPackagesNumber);
    }
}