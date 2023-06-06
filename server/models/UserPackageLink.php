<?php
namespace Server\Models;

class UserPackageLink
{
    private $linkID;
    private $userID;
    private $packageID;

    public function __construct(?string $linkID, string $userID, string $packageID)
    {
        $this->linkID = $linkID;
        $this->userID = $userID;
        $this->packageID = $packageID;
    }

    public function getLinkID(): ?string
    {
        return $this->linkID;
    }

    public function getUserID(): string
    {
        return $this->userID;
    }

    public function getPackageID(): string
    {
        return $this->packageID;
    }

    public function validate(): bool
    {
        if (empty($this->linkID) || empty($this->userID) || empty($this->packageID)) {
            return false;
        }
        return true;
    }

    public function setLinkID(string $linkID): void
    {
        $this->linkID = $linkID;
    }

    public function setUserID(string $userID): void
    {
        $this->userID = $userID;
    }

    public function setPackageID(string $packageID): void
    {
        $this->packageID = $packageID;
    }
    public function toJSON()
    {
        return json_encode([
            'linkID' => $this->linkID,
            'userID' => $this->userID,
            'packageID' => $this->packageID,
        ]);
    }

    public static function fromJSON(array $json): UserPackageLink
    {
        return new UserPackageLink(
            $json['linkID'],
            $json['userID'],
            $json['packageID'],
        );
    }

}