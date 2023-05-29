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
        $query = "SELECT q.*, t.name, t.imgURL
                FROM Questions q
                JOIN Themes t ON q.themeID = t.themeID";

        $parameters = [];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
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
                $questionData['themeID'],
                $questionData['difficulty']
            );
            $questions[] = $question;
        }
        return $questions;
    }
    public function fetchByID(string $id): ?Question
    {
        $query = "SELECT q.*, t.name, t.imgURL
        FROM questions q
        JOIN themes t ON q.themeID = t.themeID
        WHERE questionID = :questionID";

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
            $questionData['themeID'],
            $questionData['difficulty']
        );
        return $question;
    }
    public function create(Question $question): bool
    {
        if ($this->checkIfQuestionExists($question)) {
            return false;
        }
        $query = "INSERT INTO questions (questionID, question, answer, hint, difficulty, themeID)
        VALUES (:questionID, :question, :answer, :hint,  :difficulty, :themeID)";

        $questionID = $this->idGenerator->generateID();
        $question->setQuestionID($questionID);

        $parameters = [
            ':questionID' => $questionID,
            ':question' => $question->getQuestion(),
            ':answer' => $question->getAnswer(),
            ':hint' => $question->getHint(),
            ':difficulty' => $question->getDifficulty(),
            ':themeID' => $question->getThemeID()
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
    SET themeID = :themeID, question = :question, answer = :answer, hint = :hint, difficulty = :difficulty
    WHERE questionID = :questionID";

        $parameters = [
            ':themeID' => $question->getThemeID(),
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