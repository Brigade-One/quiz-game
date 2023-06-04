<?php
use PHPUnit\Framework\TestCase;
use Server\Models\PackageQuestionLink;
use Server\Repository\Database;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\PackageQuestionLinkRepository;
use Server\Repository\QuestionRepository;

class PackageQuestionLinkTest extends TestCase
{
    private $queryExecutor;
    private $idGenerator;
    private $packageQuestionLinkRepository;
    private $questionRepository;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->questionRepository = new QuestionRepository($this->queryExecutor, $idGenerator);
        $this->packageQuestionLinkRepository = new PackageQuestionLinkRepository($this->queryExecutor, $idGenerator);
    }
    public function testCreate()
    {
        $packageID = "65a9912a-2920-4ece-bce7-a0446f59bf95";

        $packageQuestionLink = new PackageQuestionLink(null, $packageID, "3cc70713-70cd-4e0c-9f87-b0fd91fdc1d7");
        $packageQuestionLink2 = new PackageQuestionLink(null, $packageID, "d48a20d8-c50f-416a-9c8b-4d1618997613");

        $this->packageQuestionLinkRepository->create($packageQuestionLink);
        $this->packageQuestionLinkRepository->create($packageQuestionLink2);

        $this->assertIsObject($packageQuestionLink);
        $this->assertNotEmpty($packageQuestionLink);
        $this->assertInstanceOf('Server\Models\PackageQuestionLink', $packageQuestionLink);

    }
    public function testFetchQuestionsByID()
    {
        $packageID = "65a9912a-2920-4ece-bce7-a0446f59bf95";
        
        $questions = $this->packageQuestionLinkRepository->fetchQuestionsByPackageID($packageID);
        $this->assertIsArray($questions);
        $this->assertNotEmpty($questions);
        $this->assertContainsOnlyInstancesOf('Server\Models\Question', $questions);
        var_dump($questions);
    }
}