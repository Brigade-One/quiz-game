<?php
namespace Server\Models;
class Question
{
    private $questionID;
    private $question;
    private $answer;
    private $hint;
    private $theme;
    private $difficulty;

    public function __construct(
        string $questionID,
        string $question,
        string $answer,
        string $hint,
        Theme $theme,
        string $difficulty
    ) {
        $this->questionID = $questionID;
        $this->question = $question;
        $this->answer = $answer;
        $this->hint = $hint;
        $this->theme = $theme;
        $this->difficulty = $difficulty;
    }
    public function validateAnswer(string $answer): bool
    {
        return $this->answer === $answer;
    }
    public function getQuestionID(): string
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
    public function getTheme(): Theme
    {
        return $this->theme;
    }
    public function getDifficulty(): string
    {
        return $this->difficulty;
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
    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
    }
    public function setDifficulty(string $difficulty): void
    {
        $this->difficulty = $difficulty;
    }
}