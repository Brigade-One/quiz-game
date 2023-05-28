<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\QuestionRepository;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Repository\IDGenerator;
use Server\Models\Question;
use Server\Models\Theme;

class QuestionsRepositoryTest extends TestCase
{
    private $questionRepository;
    private $database;
    private $queryExecutor;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db', 'root', '');
        $database = new Database($pdo);
        $idGenerator = new IDGenerator();
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->questionRepository = new QuestionRepository($this->queryExecutor, $idGenerator);
    }

    public function testCreateQuestion(): void
    {
        // Create a new question
        $question = new Question(
            null,
            'Demo Question',
            'Demo Answer',
            'Demo Hint',
            0,
            1
        );

        // Save the question to the database
        $result = $this->questionRepository->create($question);

        // Assert that the question was successfully saved to the database        
        $id = $question->getQuestionID();
        $result = $this->questionRepository->fetchByID($id);
        $this->assertNotEmpty($result);

    }

    public function testFetchAll()
    {
        $questions = $this->questionRepository->fetchAll();
        $this->assertNotEmpty($questions);
    }

}