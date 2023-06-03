<?php
namespace Server\Repository\Competition;

use Server\Models\PackageQuestionLink;
use Server\Repository\QuestionRepository;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use PDO;

class PackageQuestionLinkRepository
{
    private $queryExecutor;
    private $questionRepository;
    private $idGenerator;
    public function __construct(QueryExecutor $queryExecutor, IDGenerator $idGenerator)
    {
        $this->queryExecutor = $queryExecutor;
        $this->idGenerator = $idGenerator;
    }
    public function fetchAll(): array
    {
        $query = "SELECT * from  CompetitionPackageQuestionLink";
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
    // Fetch all questions for a package with a given ID.
    public function fetchQuestionsByPackageID(string $packageID): array
    {
        $questionRepository = new QuestionRepository($this->queryExecutor, $this->idGenerator);

        $query = " SELECT * FROM CompetitionPackageQuestionLink  WHERE packageID = :packageID";

        try {
            $statement = $this->queryExecutor->execute($query, [':packageID' => $packageID]);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $questions = [];
        while ($questionData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $question = $questionRepository->fetchByID($questionData['questionID']);
            $questions[] = $question;
        }
        return $questions;
    }
    public function fetchByID(string $id): ?PackageQuestionLink
    {
        $query = "SELECT * from  CompetitionPackageQuestionLink WHERE linkID = :linkID";
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
            print("No package found with ID: $id");
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
        // Check if the package already exists
        if ($this->checkIfAlreadyExist($link->getPackageID(), $link->getQuestionID())) {
            throw new \Exception("The link already exists");
        }
        $generatedLink = $this->idGenerator->generateID();
        $link->setLinkID($generatedLink);
        $query = "INSERT INTO CompetitionPackageQuestionLink (linkID, packageID, questionID) VALUES (:linkID, :packageID, :questionID)";
        $parameters = [
            ':linkID' => $generatedLink,
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
    public function update(PackageQuestionLink $link): bool
    {
        $query = "UPDATE CompetitionPackageQuestionLink SET packageID = :packageID, questionID = :questionID WHERE linkID = :linkID";
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

        return $statement->rowCount() === 1;
    }

    public function delete(PackageQuestionLink $link): bool
    {
        $query = "DELETE FROM CompetitionPackageQuestionLink WHERE linkID = :linkID";
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
    private function checkIfAlreadyExist(string $packageID, string $questionID): bool
    {
        $query = "SELECT * from  CompetitionPackageQuestionLink WHERE packageID = :packageID AND questionID = :questionID";
        $parameters = [
            ':packageID' => $packageID,
            ':questionID' => $questionID
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $packageData = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$packageData) {
            return false;
        }
        return true;
    }
}