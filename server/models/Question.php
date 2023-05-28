<?php
namespace Server\Models;

class Question
{
    private $questionID;
    private $question;
    private $answer;
    private $hint;
    private $themeID;
    private $difficulty;

    public function __construct(
        ?string $questionID,
        string $question,
        string $answer,
        string $hint,
        int $themeID,
        int $difficulty
    ) {
        $this->questionID = $questionID;
        $this->question = $question;
        $this->answer = $answer;
        $this->hint = $hint;
        $this->themeID = $themeID;
        $this->difficulty = $difficulty;
    }
    public function validateAnswer(string $answer): bool
    {
        return $this->answer === $answer;
    }
    public function getQuestionID(): ?string
    {
        return $this->questionID;
    }
    public function getQuestion(): string
    {
        return $this->question;
    }
    public function getAnswer(): string
    {
        return $this->answer;
    }
    public function getHint(): string
    {
        return $this->hint;
    }
    public function getThemeID(): int
    {
        return $this->themeID;
    }
    public function getDifficulty(): string
    {
        return $this->difficulty;
    }
    public function setQuestionID(string $questionID): void
    {
        $this->questionID = $questionID;
    }
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }
    public function setHint(string $hint): void
    {
        $this->hint = $hint;
    }
    public function setThemeID(string $themeID): void
    {
        $this->themeID = $themeID;
    }
    public function setDifficulty(string $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

}