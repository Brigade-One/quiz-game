<?php

namespace Server\Repository;

use Server\Models\Package;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Models\User;
use PDO;

class PackageRepository
{
    private $queryExecutor;
    private $idGenerator;

    public function __construct(QueryExecutor $queryExecutor, IDGenerator $idGenerator)
    {
        $this->queryExecutor = $queryExecutor;
        $this->idGenerator = $idGenerator;
    }
    public function fetchAll(): array
    {
        $query =
            "SELECT *"
            . " FROM Packages";
        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packages = [];
        while ($packageData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $package = new Package(
                $packageData['packageID'],
                $packageData['name'],
                $packageData['isApproved']
            );
            $packages[] = $package;
        }
        return $packages;
    }
    public function fetchByID(string $id)
    {
        $query =
            "SELECT *"
            . " FROM Packages"
            . " WHERE packageID = :packageID";
        $parameters = [':packageID' => $id];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packageData = $statement->fetch(PDO::FETCH_ASSOC);
        $package = new Package(
            $packageData['packageID'],
            $packageData['name'],
            $packageData['isApproved']
        );
        return $package;
    }
    public function fetchPublicPackages(): array
    {
        $query =
            "SELECT *"
            . " FROM Packages where isApproved = 1";
        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $packages = [];
        while ($packageData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $package = new Package(
                $packageData['packageID'],
                $packageData['name'],
                $packageData['isApproved']
            );
            $packages[] = $package;
        }
        return $packages;
    }
    public function create(Package $package): ?Package
    {
        $query =
            "INSERT INTO Packages (packageID, name, isApproved)"
            . " VALUES (:packageID, :name, :isApproved)";
        $packageID = $this->idGenerator->generateID();

        $package->setPackageID($packageID);

        $parameters = [
            ':packageID' => $packageID,
            ':name' => $package->getName(),
            ':isApproved' => $package->getIsApproved()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        if ($statement->rowCount() > 0) {
            return $package;
        } else {
            return null;
        }
    }
    public function update(Package $package): bool
    {
        $query =
            "UPDATE Packages"
            . " SET name = :name, isApproved = :isApproved"
            . " WHERE packageID = :packageID";

        $parameters = [
            ':packageID' => $package->getPackageID(),
            ':name' => $package->getName(),
            ':isApproved' => $package->getIsApproved()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() === 1;
    }

    public function delete(Package $package)
    {
        $query =
            "DELETE FROM Packages"
            . " WHERE packageID = :packageID";
        $parameters = [
            ':packageID' => $package->getPackageID()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() === 1;
    }
}