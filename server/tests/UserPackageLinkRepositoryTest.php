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
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db_3', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->packageRepository = new PackageRepository($this->queryExecutor, $idGenerator);
        $this->userPackageLinkRepository = new UserPackageLinkRepository($this->queryExecutor, $idGenerator);
    }
    /* public function testCreate()
    {
        $userID = "74fde1a1-469b-428d-9d34-e9dfb4988654";

        $pgID1 = "8824faa1-c84f-4eac-b573-95149f8e00c9";
        $pgID2 = "34a08dbe-e637-4600-9dd0-f069c870596f";

        $userPackageLink1 = new UserPackageLink(null, $userID, $pgID1);
        $userPackageLink2 = new UserPackageLink(null, $userID, $pgID2);

        $userPackageLink1 = $this->userPackageLinkRepository->create($userPackageLink1);
        $userPackageLink2 = $this->userPackageLinkRepository->create($userPackageLink2);


        $this->assertIsObject($userPackageLink1);
        $this->assertNotEmpty($userPackageLink1);
        $this->assertInstanceOf('Server\Models\UserPackageLink', $userPac
        kageLink1);
    } */
    public function testFetchPackagesByUserID()
    {
        $userID = "74fde1a1-469b-428d-9d34-e9dfb4988654";

        $packages = $this->userPackageLinkRepository->fetchPackagesByUserID($userID);
        $this->assertIsArray($packages);
        $this->assertNotEmpty($packages);
        $this->assertContainsOnlyInstancesOf('Server\Models\Package', $packages);
        var_dump($packages);
    }
}