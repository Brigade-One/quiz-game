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
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db_3', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->questionRepository = new QuestionRepository($this->queryExecutor, $idGenerator);
        $this->packageQuestionLinkRepository = new PackageQuestionLinkRepository($this->queryExecutor, $idGenerator);
    }
    public function testCreate()
    {
        $packageID = "8824faa1-c84f-4eac-b573-95149f8e00c9";

        $packageQuestionLink = new PackageQuestionLink(null, $packageID, "00e5dfc2-778f-4701-a8bb-bf6f058e4316");
        $packageQuestionLink2 = new PackageQuestionLink(null, $packageID, "b68737b6-1269-461a-a08e-ce375c77c17d");

        $this->packageQuestionLinkRepository->create($packageQuestionLink);
        $this->packageQuestionLinkRepository->create($packageQuestionLink2);

        $this->assertIsObject($packageQuestionLink);
        $this->assertNotEmpty($packageQuestionLink);
        $this->assertInstanceOf('Server\Models\PackageQuestionLink', $packageQuestionLink);

    }
    public function testFetchQuestionsByID()
    {
        $packageID = "8824faa1-c84f-4eac-b573-95149f8e00c9";
        $questions = $this->packageQuestionLinkRepository->fetchQuestionsByPackageID($packageID);
        $this->assertIsArray($questions);
        $this->assertNotEmpty($questions);
        $this->assertContainsOnlyInstancesOf('Server\Models\Question', $questions);
        var_dump($questions);
    }
}