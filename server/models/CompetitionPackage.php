<?php
namespace Server\Models;

class Package
{
    private $packageID;
    private $name;
    private $userID;

    public function __construct(
        ?string $packageID,
        string $name,
        ?string $userID,

    ) {
        $this->packageID = $packageID;
        $this->name = $name;
        $this->userID = $userID;

    }

    public function getPackageID(): ?string
    {
        return $this->packageID;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getUserID(): ?string
    {
        return $this->userID;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
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