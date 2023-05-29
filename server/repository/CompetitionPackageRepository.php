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
    private $userRepository;
    private $idGenerator;

    public function __construct(QueryExecutor $queryExecutor, IDGenerator $idGenerator, UserRepository $userRepository)
    {
        $this->queryExecutor = $queryExecutor;
        $this->idGenerator = $idGenerator;
        $this->userRepository = $userRepository;
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
                $packageData['userID'],
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
            $packageData['userID'],
        );
        return $package;
    }
    public function create(CompetitionPackage $package, User $user): bool
    {
        if (!$user->validate()) {
            throw new \InvalidArgumentException('Invalid user data');
        }
        // Check if user already created package. Prevent doing that
        if ($this->checkUserExistingPackages($user->getId())) {
            throw new \Exception('User already have package');
        }
        $query = "INSERT INTO CompetitionPackages (packageID, name, userID) VALUES (:packageID, :name, :userID)";
        $packageID = $this->idGenerator->generateID();

        $package->setPackageID($packageID);
        $user->setPackageID($packageID);

        $parameters = [
            ':packageID' => $packageID,
            ':name' => $package->getName(),
            ':userID' => $user->getId(),
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        // Now update DB User item(package must be created for that moment)
        $this->userRepository->update($user);

        return $statement->rowCount() > 0;
    }
    public function update(CompetitionPackage $package): bool
    {
        $query = "UPDATE CompetitionPackages SET name = :name, userID = :userID  WHERE packageID = :packageID";
        $parameters = [
            ':packageID' => $package->getPackageID(),
            ':name' => $package->getName(),
            ':userID' => $package->getUserID(),
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
    private function checkUserExistingPackages(string $userID): bool
    {
        $query = "SELECT COUNT(*) FROM CompetitionPackages WHERE userID = :userID";
        $parameters = [':userID' => $userID];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $count = $statement->fetchColumn();
        if ($count == 0) {
            return false;
        }

        return true;
    }
}