<?php
namespace Server\Repository;

use Server\Models\CompetitionPackage;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Models\User;
use PDO;

class CompetitionPackageRepository
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
        $query = "SELECT * from CompetitionPackages";
        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packages = [];
        while ($packageData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $package = new CompetitionPackage(
                $packageData['packageID'],
                $packageData['name'],
            );
            $packages[] = $package;
        }
        return $packages;
    }
    public function fetchByID(string $id)
    {
        $query = "SELECT * from CompetitionPackages where packageID = :packageID";
        $parameters = [':packageID' => $id];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packageData = $statement->fetch(PDO::FETCH_ASSOC);
        $package = new CompetitionPackage(
            $packageData['packageID'],
            $packageData['name'],

        );
        return $package;
    }
    public function create(CompetitionPackage $package): bool
    {
        $query = "INSERT INTO CompetitionPackages (packageID, name) VALUES (:packageID, :name)";
        $packageID = $this->idGenerator->generateID();
        $package->setPackageID($packageID);
        $parameters = [
            ':packageID' => $packageID,
            ':name' => $package->getName(),
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() > 0;
    }
    public function update(CompetitionPackage $package): bool
    {
        $query = "UPDATE CompetitionPackages SET name = :name WHERE packageID = :packageID";
        $parameters = [
            ':packageID' => $package->getPackageID(),
            ':name' => $package->getName(),
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() > 0;
    }

    public function delete(CompetitionPackage $package)
    {
        $query = "DELETE FROM CompetitionPackages WHERE packageID = :packageID";
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