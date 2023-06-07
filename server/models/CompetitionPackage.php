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

    public function toJSON(): string
    {
        return json_encode([
            'packageID' => $this->packageID,
            'name' => $this->name,
        ]);
    }
    public static function fromJSON(string $json): CompetitionPackage
    {
        $data = json_decode($json, true);
        return new CompetitionPackage(
            $data['packageID'],
            $data['name'],
        );
    }
}