<?php
namespace Server\Models;

class QuestionThemeLink
{
    private $linkID;
    private $questionID;
    private $themeID;

    public function __construct(?int $linkID, string $questionID, int $themeID)
    {
        $this->linkID = $linkID;
        $this->questionID = $questionID;
        $this->themeID = $themeID;
    }

    public function getLinkID(): ?int
    {
        return $this->linkID;
    }

    public function getQuestionID(): string
    {
        return $this->questionID;
    }

    public function getThemeID(): int
    {
        return $this->themeID;
    }

    public function validate(): bool
    {
        if (empty($this->linkID) || empty($this->questionID) || empty($this->themeID)) {
            return false;
        }
        return true;
    }

    public function setLinkID(int $linkID): void
    {
        $this->linkID = $linkID;
    }

    public function setQuestionID(string $questionID): void
    {
        $this->questionID = $questionID;
    }

    public function setThemeID(int $themeID): void
    {
        $this->themeID = $themeID;
    }
}