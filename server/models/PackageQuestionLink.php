<?php
namespace Server\Models;

class PackageQuestionLink
{
    private $linkID;
    private $packageID;
    private $questionID;

    public function __construct(?string $linkID, string $packageID, ?string $questionID)
    {
        $this->linkID = $linkID;
        $this->packageID = $packageID;
        $this->questionID = $questionID;
    }
    public function getLinkID(): ?string
    {
        return $this->linkID;
    }
    public function getPackageID(): string
    {
        return $this->packageID;
    }
    public function getQuestionID(): string
    {
        return $this->questionID;
    }
    public function validate(): bool
    {
        if (empty($this->linkID) || empty($this->packageID) || empty($this->questionID)) {
            return false;
        }
        return true;
    }
    public function setLinkID(string $linkID): void
    {
        $this->linkID = $linkID;
    }
    public function setPackageID(string $packageID): void
    {
        $this->packageID = $packageID;
    }
    public function setQuestionID(string $questionID): void
    {
        $this->questionID = $questionID;
    }


    public function toJSON()
    {
        return json_encode([
            'linkID' => $this->linkID,
            'packageID' => $this->packageID,
            'questionID' => $this->questionID,
        ]);
    }
    public static function fromJSON(string $json): PackageQuestionLink
    {
        $data = json_decode($json, true);
        $linkID = isset($data['linkID']) ? $data['linkID'] : null;
        $packageID = isset($data['packageID']) ? $data['packageID'] : null;
        $questionID = isset($data['questionID']) ? $data['questionID'] : null;

        return new PackageQuestionLink(
            $linkID,
            $packageID,
            $questionID
        );
    }

}