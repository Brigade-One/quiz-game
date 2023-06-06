<?php

namespace Server\Repository;

use Server\Models\QuestionThemeLink;
use Server\Repository\QueryExecutor;
use Server\Models\Theme;
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
        $query =
            "SELECT *"
            . " FROM QuestionThemeLink";
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
        $query =
            "SELECT *"
            . " FROM QuestionThemeLink WHERE linkID = :linkID";
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
    public function fetchThemesByQuestionID(string $questionID): array
    {
        $query =
            "SELECT *"
            . " FROM QuestionThemeLink"
            . " JOIN Themes ON QuestionThemeLink.themeID = Themes.themeID"
            . " WHERE questionID = :questionID";
        try {
            $statement = $this->queryExecutor->execute($query, [':questionID' => $questionID]);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
        $themes = [];
        while ($linkData = $statement->fetch(PDO::FETCH_ASSOC)) {
            print_r($linkData);
            $theme = new Theme(
                $linkData['themeID'],
                $linkData['name'],
                $linkData['imgURL']
            );
            $themes[] = $theme;
        }
        return $themes;
    }
    public function create(QuestionThemeLink $link): bool
    {
        if ($this->checkIfLinkExists($link)) {
            throw new \PDOException("QuestionTheme Link already exists");
        }
        $generatedLink = $this->idGenerator->generateID();
        $link->setLinkID($generatedLink);

        $query =
            "INSERT INTO QuestionThemeLink (linkID, questionID, themeID)"
            . " VALUES (:linkID, :questionID, :themeID)";
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
        $query =
            "UPDATE QuestionThemeLink"
            . " SET questionID = :questionID, themeID = :themeID"
            . " WHERE linkID = :linkID";
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
        $query =
            "DELETE FROM QuestionThemeLink"
            . " WHERE linkID = :linkID";
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
    private function checkIfLinkExists(QuestionThemeLink $link): bool
    {
        $query =
            "SELECT *"
            . " FROM QuestionThemeLink"
            . " WHERE questionID = :questionID AND themeID = :themeID";
        $parameters = [
            ':questionID' => $link->getQuestionID(),
            ':themeID' => $link->getThemeID()
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