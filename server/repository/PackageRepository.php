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
        $query = "SELECT * from packages";
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
                $packageData['userID'],
                $packageData['isApproved']
            );
            $packages[] = $package;
        }
        return $packages;
    }
    public function fetchByID(string $id)
    {
        $query = "SELECT * from packages where packageID = :packageID";
        $parameters = [
            ':packageID' => $id
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packageData = $statement->fetch(PDO::FETCH_ASSOC);
        $package = new Package(
            $packageData['packageID'],
            $packageData['name'],
            $packageData['userID'],
            $packageData['isApproved']
        );
        return $package;
    }
    public function create(Package $package, User $user): bool
    {
        if (!$user->validate()) {
            throw new \InvalidArgumentException('Invalid user data');
        }
        // Check if user already created package. Prevent doing that
        if ($this->checkUserExistingPackages($user->getId())) {
            print("---------------------");
            return false;
        }
        $query = "INSERT INTO packages (packageID, name, userID, isApproved) VALUES (:packageID, :name, :userID, :isApproved)";
        $packageID = $this->idGenerator->generateID();

        $package->setPackageID($packageID);
        $user->setPackageID($packageID);

        $parameters = [
            ':packageID' => $packageID,
            ':name' => $package->getName(),
            ':userID' => $user->getId(),
            ':isApproved' => $package->getIsApproved()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        // Now update DB User item
        $this->userRepository->update($user);

        return $statement->rowCount() > 0;
    }
    public function update(Package $package): bool
    {
        $query = "UPDATE packages SET name = :name, userID = :userID, isApproved = :isApproved WHERE packageID = :packageID";
        $parameters = [
            ':packageID' => $package->getPackageID(),
            ':name' => $package->getName(),
            ':userID' => $package->getUserID(),
            ':isApproved' => $package->getIsApproved()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        return $statement->rowCount() > 0;
    }

    public function delete(Package $package)
    {
        $query = "DELETE FROM packages WHERE packageID = :packageID";
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
        $query = "SELECT COUNT(*) FROM packages WHERE userID = :userID";
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