<?php
namespace Server\Repository;

use Server\Models\QuestionThemeLink;
use Server\Repository\QueryExecutor;
use PDO;

class QuestionThemeLinkRepository
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
        $query = "SELECT * FROM QuestionThemeLink";
        try {
            $statement = $this->queryExecutor->execute($query, []);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        $questionThemeLinks = [];
        while ($linkData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $link = new QuestionThemeLink(
                $linkData['linkID'],
                $linkData['questionID'],
                $linkData['themeID']
            );
            $questionThemeLinks[] = $link;
        }

        return $questionThemeLinks;
    }

    public function fetchByID(string $id): ?QuestionThemeLink
    {
        $query = "SELECT * FROM QuestionThemeLink WHERE linkID = :linkID";
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

        $link = new QuestionThemeLink(
            $linkData['linkID'],
            $linkData['questionID'],
            $linkData['themeID']
        );

        return $link;
    }

    public function create(QuestionThemeLink $link): bool
    {
        $generatedLink = $this->idGenerator->generateID();
        $link->setLinkID($generatedLink);

        $query = "INSERT INTO QuestionThemeLink (linkID, questionID, themeID) VALUES (:linkID, :questionID, :themeID)";
        $parameters = [
            ':linkID' => $generatedLink,
            ':questionID' => $link->getQuestionID(),
            ':themeID' => $link->getThemeID()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() > 0;
    }

    public function update(QuestionThemeLink $link): bool
    {
        $query = "UPDATE QuestionThemeLink SET questionID = :questionID, themeID = :themeID WHERE linkID = :linkID";
        $parameters = [
            ':linkID' => $link->getLinkID(),
            ':questionID' => $link->getQuestionID(),
            ':themeID' => $link->getThemeID()
        ];
        try {
            $statement = $this->queryExecutor->execute($query, $parameters);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $statement->rowCount() === 1;
    }

    public function delete(QuestionThemeLink $link): bool
    {
        $query = "DELETE FROM QuestionThemeLink WHERE linkID = :linkID";
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