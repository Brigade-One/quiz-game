<?php
use PHPUnit\Framework\TestCase;
use Server\Models\PackageQuestionLink;
use Server\Repository\Database;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\PackageQuestionLinkRepository;
use Server\Repository\QuestionRepository;

class PackageQuestionLinkRepositoryTest extends TestCase
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
    public function testFetchQuestionsByID()
    {
        $packageID = "1";
        $questions = $this->packageQuestionLinkRepository->fetchQuestionsByPackageID($packageID);
        $this->assertIsArray($questions);
        $this->assertNotEmpty($questions);
        $this->assertContainsOnlyInstancesOf('Server\Models\Question', $questions);
        var_dump($questions);
    }
}