<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\QuestionsRepository;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Models\Question;
use Server\Models\Theme;

class QuestionsRepositoryTest extends TestCase
{
    private $userRepository;
    private $database;
    private $queryExecutor;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db', 'root', '');
        $database = new Database($pdo);
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->userRepository = new QuestionsRepository($this->queryExecutor);
    }

    public function testCreate(): void
    {
        // Create a new question
        $question = new Question(
            null,
            'Demo Question',
            'Demo Answer',
            'Demo Hint',
            new Theme(
                null,
                'Demo Theme',
                'Demo Theme Description'
            ),
            'Demo Difficulty'
        );
    }

    public function testFetchAll()
    {
        $questions = $this->userRepository->fetchAll();
        print($questions);
        $this->assertNotEmpty($questions);
    }

}