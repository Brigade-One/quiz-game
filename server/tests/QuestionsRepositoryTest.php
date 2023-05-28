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
    public function testUpdate()
    {
        $question = $this->questionRepository->fetchByID('194f1471-f181-495d-b734-ee81c949367e');
        $question->setQuestion('Demo Question Updated');
        $question->setAnswer('Demo Answer Updated');
        $question->setHint('Demo Hint Updated');
        $question->setThemeID(1);
        $question->setDifficulty(2);
        $this->questionRepository->update($question);
        $question = $this->questionRepository->fetchByID('194f1471-f181-495d-b734-ee81c949367e');
        $this->assertEquals('Demo Question Updated', $question->getQuestion());
        $this->assertEquals('Demo Answer Updated', $question->getAnswer());
        $this->assertEquals('Demo Hint Updated', $question->getHint());
        $this->assertEquals(1, $question->getThemeID());
        $this->assertEquals(2, $question->getDifficulty());
    }
    public function testFetchByID()
    {
        $question = $this->questionRepository->fetchByID('194f1471-f181-495d-b734-ee81c949367e');
        $this->assertInstanceOf(Question::class, $question);
        $this->assertEquals('Demo Question Updated', $question->getQuestion());
        $this->assertEquals('Demo Answer Updated', $question->getAnswer());
        $this->assertEquals('Demo Hint Updated', $question->getHint());
        $this->assertEquals(1, $question->getThemeID());
        $this->assertEquals(2, $question->getDifficulty());
    }

}