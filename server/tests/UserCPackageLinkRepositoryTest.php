<?php
use PHPUnit\Framework\TestCase;
use Server\Models\UserPackageLink;
use Server\Repository\Database;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\Competition\UserCompetitionPackageLinkRepository;
use Server\Repository\PackageRepository;

class UserCPackageLinkRepositoryTest extends TestCase
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
        $this->userPackageLinkRepository = new UserCompetitionPackageLinkRepository($this->queryExecutor, $idGenerator);
    }
    public function testCreate()
    {
        $userID = "6f5aa13c-4de4-4ebc-916a-766fc8928bad";

        $pgID1 = "191b9fbf-bd57-4323-8be6-2cdc942e7e82";
        $pgID2 = "44bb661f-6c5d-4c07-9d0f-5529321988d8";

        $userPackageLink1 = new UserPackageLink(null, $userID, $pgID1);
        $userPackageLink2 = new UserPackageLink(null, $userID, $pgID2);

        $userPackageLink1 = $this->userPackageLinkRepository->create($userPackageLink1);
        $userPackageLink2 = $this->userPackageLinkRepository->create($userPackageLink2);

        $this->assertTrue($userPackageLink1);
        $this->assertTrue($userPackageLink2);
    }

    public function testFetchPackagesByUserID()
    {
        $userID = "6f5aa13c-4de4-4ebc-916a-766fc8928bad";

        $packages = $this->userPackageLinkRepository->fetchPackagesByUserID($userID);
        $this->assertIsArray($packages);
        $this->assertNotEmpty($packages);
        var_dump($packages);
    }

}