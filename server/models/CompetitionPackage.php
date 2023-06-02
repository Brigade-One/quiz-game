<?php
namespace Server\Models;

class CompetitionPackage
{
    private $packageID;
    private $name;

    public function __construct(
        ?string $packageID,
        string $name,
    ) {
        $this->packageID = $packageID;
        $this->name = $name;
    }

    public function getPackageID(): ?string
    {
        return $this->packageID;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setPackageID(string $packageID): void
    {
        $this->packageID = $packageID;
    }

}