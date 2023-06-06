<?php
namespace Server\Models;

class Package
{
    private $packageID;
    private $name;
    private $isApproved;

    public function __construct(
        ?string $packageID,
        string $name,
        int $isApproved
    ) {
        $this->packageID = $packageID;
        $this->name = $name;
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
    public function setPackageID(string $packageID): void
    {
        $this->packageID = $packageID;
    }

    public function toJSON(): array
    {
        return [
            'packageID' => $this->packageID,
            'name' => $this->name,
            'isApproved' => $this->isApproved,
        ];
    }

    public static function fromJSON(string $json): Package
    {
        $data = json_decode($json, true);
        return new Package(
            $data['packageID'],
            $data['name'],
            $data['isApproved'],
        );
    }
}