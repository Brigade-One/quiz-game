<?php
namespace Server\Repository;

use Server\Models\PackageQuestionLink;
use Server\Repository\QueryExecutor;
use PDO;

class PackageQuestionLinkRepository
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
        $query = "SELECT * from  PackageQuestionLink";
        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packages = [];
        while ($packageData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $package = new PackageQuestionLink(
                $packageData['linkID'],
                $packageData['packageID'],
                $packageData['questionID'],

            );
            $packages[] = $package;
        }
        return $packages;
    }
    public function fetchByID(string $id): ?PackageQuestionLink
    {
        $query = "SELECT * from  PackageQuestionLink WHERE linkID = :linkID";
        $parameters = [
            ':linkID' => $id
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packageData = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$packageData) {
            return null;
        }
        $package = new PackageQuestionLink(
            $packageData['linkID'],
            $packageData['packageID'],
            $packageData['questionID'],

        );
        return $package;
    }

    public function create(PackageQuestionLink $link): bool
    {
        $link->setLinkID($this->idGenerator->generateID());
        $query = "INSERT INTO PackageQuestionLink (linkID, packageID, questionID) VALUES (:linkID, :packageID, :questionID)";
        $parameters = [
            ':linkID' => $link->getLinkID(),
            ':packageID' => $link->getPackageID(),
            ':questionID' => $link->getQuestionID()
        ];

        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() > 0;
    }

    public function delete(PackageQuestionLink $link): bool
    {
        $query = "DELETE FROM package_question_links WHERE linkID = :linkID";
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
}