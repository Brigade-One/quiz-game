<?php
namespace Server\Models;

class QuestionThemeLink
{
    private $linkID;
    private $questionID;
    private $themeID;

    public function __construct(?string $linkID, string $questionID, int $themeID)
    {
        $this->linkID = $linkID;
        $this->questionID = $questionID;
        $this->themeID = $themeID;
    }

    public function getLinkID(): ?string
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

    public function setLinkID(string $linkID): void
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
    public function toJSON()
    {
        return json_encode([
            'linkID' => $this->linkID,
            'questionID' => $this->questionID,
            'themeID' => $this->themeID,
        ]);
    }

    public static function fromJSON(array $json): QuestionThemeLink
    {
        return new QuestionThemeLink(
            $json['linkID'],
            $json['questionID'],
            $json['themeID'],
        );
    }

}