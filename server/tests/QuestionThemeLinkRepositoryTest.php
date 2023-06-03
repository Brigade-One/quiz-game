<?php
use PHPUnit\Framework\TestCase;
use Server\Models\QuestionThemeLink;
use Server\Repository\Database;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\QuestionThemeLinkRepository;
use Server\Repository\PackageRepository;

class QuestionThemeLinkRepositoryTest extends TestCase
{
    private $queryExecutor;
    private $idGenerator;
    private $qtLinkRepository;
    private $packageRepository;
    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->packageRepository = new PackageRepository($this->queryExecutor, $idGenerator);
        $this->qtLinkRepository = new QuestionThemeLinkRepository($this->queryExecutor, $idGenerator);
    }
    /* public function testCreate()
    {
        $questionID = "3cc70713-70cd-4e0c-9f87-b0fd91fdc1d7";

        $qtLink1 = new QuestionThemeLink(null, $questionID, 0); // TODO: represent id as a string while creating the link
        $qtLink2 = new QuestionThemeLink(null, $questionID, 8);

        $qtLink1 = $this->qtLinkRepository->create($qtLink1);
        $qtLink2 = $this->qtLinkRepository->create($qtLink2);

        $this->assertTrue($qtLink1);
        $this->assertTrue($qtLink2);

    } */
    public function testFetchThemesByQuestionID()
    {
        $questionID = "3cc70713-70cd-4e0c-9f87-b0fd91fdc1d7";

        $themes = $this->qtLinkRepository->fetchThemesByQuestionID($questionID);
        $this->assertIsArray($themes);
        $this->assertNotEmpty($themes);
        $this->assertContainsOnlyInstancesOf('Server\Models\Theme', $themes);
        var_dump($themes);
    }

}