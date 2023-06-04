<?php
namespace Server\Repository;

use Server\Models\Question;
use Server\Repository\IDGenerator;
use PDO;

class QuestionRepository
{
    private $queryExecutor;
    private $idGenerator;

    public function __construct(QueryExecutor $queryExecutor, IDGenerator $idGenerator)
    {
        $this->queryExecutor = $queryExecutor;
        $this->idGenerator = $idGenerator;
    }
    public function fetchAll(): array
    {
        $query = "SELECT * FROM  questions";

        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $questions = [];
        while ($questionData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $question = new Question(
                $questionData['questionID'],
                $questionData['question'],
                $questionData['answer'],
                $questionData['hint'],
                $questionData['difficulty']
            );
            $questions[] = $question;
        }
        return $questions;
    }
    public function fetchByID(string $id): ?Question
    {
        $query = "SELECT * FROM Questions WHERE questionID = :questionID";

        $parameters = [
            ':questionID' => $id
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $questionData = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$questionData) {
            return null;
        }
        $question = new Question(
            $questionData['questionID'],
            $questionData['question'],
            $questionData['answer'],
            $questionData['hint'],
            $questionData['difficulty']
        );
        return $question;
    }
    public function create(Question $question): bool
    {
        if ($this->checkIfQuestionExists($question)) {
            throw new \PDOException("Question already exists", 400);
        }
        $query = "INSERT INTO questions (questionID, question, answer, hint, difficulty)
        VALUES (:questionID, :question, :answer, :hint,  :difficulty)";

        $questionID = $this->idGenerator->generateID();
        $question->setQuestionID($questionID);

        $parameters = [
            ':questionID' => $questionID,
            ':question' => $question->getQuestion(),
            ':answer' => $question->getAnswer(),
            ':hint' => $question->getHint(),
            ':difficulty' => $question->getDifficulty(),
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() > 0;
    }
    public function update(Question $question): bool
    {
        $query = "UPDATE questions
    SET  question = :question, answer = :answer, hint = :hint, difficulty = :difficulty
    WHERE questionID = :questionID";

        $parameters = [
            ':questionID' => $question->getQuestionID(),
            ':question' => $question->getQuestion(),
            ':answer' => $question->getAnswer(),
            ':hint' => $question->getHint(),
            ':difficulty' => $question->getDifficulty()
        ];

        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() > 0;
    }

    public function delete(Question $question): bool
    {
        $query = "DELETE FROM questions WHERE questionID = :questionID";

        $parameters = [
            ':questionID' => $question->getQuestionID()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() > 0;
    }

    private function checkIfQuestionExists(Question $question): bool
    {
        $query = "SELECT * FROM questions WHERE question = :question";

        $parameters = [
            ':question' => $question->getQuestion()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() > 0;
    }
}