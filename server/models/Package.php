<?php
namespace Server\Models;

class Package
{
    private $packageID;
    private $name;
    private $userID;
    private $isApproved;

    public function __construct(
        ?string $packageID,
        string $name,
        ?string $userID,
        int $isApproved
    ) {
        $this->packageID = $packageID;
        $this->name = $name;
        $this->userID = $userID;
        $this->isApproved = $isApproved;
    }

    public function getPackageID(): ?string
    {
        return $this->packageID;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getUserID():  ?string
    {
        return $this->userID;
    }
    public function getIsApproved(): int
    {
        return $this->isApproved;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setIsApproved(bool $isApproved): void
    {
        $this->isApproved = $isApproved;
    }
    public function setUserID(string $userID): void
    {
        $this->userID = $userID;
    }
    public function setPackageID(string $packageID): void
    {
        $this->packageID = $packageID;
    }
}