<?php
namespace Server\Repository\Competition;

use Server\Models\UserPackageLink;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use PDO;

class UserCompetitionPackageLinkRepository
{
    private $queryExecutor;
    private $idGenerator;
    private $packageRepository;

    public function __construct(QueryExecutor $queryExecutor, IDGenerator $idGenerator)
    {
        $this->queryExecutor = $queryExecutor;
        $this->idGenerator = $idGenerator;
    }

    public function fetchAll(): array
    {
        $query = "SELECT * FROM UserCompPackageLink";
        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $userPackageLinks = [];
        while ($linkData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $link = new UserPackageLink(
                $linkData['linkID'],
                $linkData['userID'],
                $linkData['packageID']
            );
            $userPackageLinks[] = $link;
        }

        return $userPackageLinks;
    }
    public function fetchPackagesByUserID(string $userID): array
    {
        $packageRepository = new CompetitionPackageRepository($this->queryExecutor, $this->idGenerator);
        $query = "SELECT * FROM UserCompPackageLink WHERE userID = :userID";
        $parameters = [
            ':userID' => $userID
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packages = [];
        while ($linkData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $package = $packageRepository->fetchByID($linkData['packageID']);
            $packages[] = $package;
        }
        return $packages;
    }
    public function fetchByID(string $id): ?UserPackageLink
    {
        $query = "SELECT * FROM UserCompPackageLink WHERE linkID = :linkID";
        $parameters = [
            ':linkID' => $id
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $linkData = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$linkData) {
            print("No link found with ID: $id");
            return null;
        }

        $link = new UserPackageLink(
            $linkData['linkID'],
            $linkData['userID'],
            $linkData['packageID']
        );

        return $link;
    }

    public function create(UserPackageLink $link): bool
    {
        // Check if the link already exists
        if ($this->checkIfAlreadyExist($link->getUserID(), $link->getPackageID())) {
            throw new \Exception("The link already exists");
        }

        $generatedLink = $this->idGenerator->generateID();
        $link->setLinkID($generatedLink);

        $query = "INSERT INTO UserCompPackageLink (linkID, userID, packageID) VALUES (:linkID, :userID, :packageID)";
        $parameters = [
            ':linkID' => $generatedLink,
            ':userID' => $link->getUserID(),
            ':packageID' => $link->getPackageID()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() > 0;
    }

    public function update(UserPackageLink $link): bool
    {
        $query = "UPDATE UserCompPackageLink SET userID = :userID, packageID = :packageID WHERE linkID = :linkID";
        $parameters = [
            ':linkID' => $link->getLinkID(),
            ':userID' => $link->getUserID(),
            ':packageID' => $link->getPackageID()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() === 1;
    }

    public function delete(UserPackageLink $link): bool
    {
        $query = "DELETE FROM UserCompPackageLink WHERE linkID = :linkID";
        $parameters = [
            ':linkID' => $link->getLinkID()
        ];

        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() === 1;
    }

    private function checkIfAlreadyExist(string $userID, string $packageID): bool
    {
        $query = "SELECT * FROM UserCompPackageLink WHERE userID = :userID AND packageID = :packageID";
        $parameters = [
            ':userID' => $userID,
            ':packageID' => $packageID
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $linkData = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$linkData) {
            return false;
        }

        return true;
    }
}