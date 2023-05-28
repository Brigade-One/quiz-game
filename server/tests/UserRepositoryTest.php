<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\UserRepository;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Models\User;

class UserRepositoryTest extends TestCase
{
    private $userRepository;
    private $database;
    private $queryExecutor;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=test_quiz_db', 'root', '');
        $database = new Database($pdo);
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->userRepository = new UserRepository($this->queryExecutor);
    }
    public function testFindById(): void
    {
        // Retrieve the user using findById
        $foundUser = $this->userRepository->findById('105cb99d-eed6-4b20-b599-2c1cec737998');

        // Assert that the retrieved user matches the expected values
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals('John Doe', $foundUser->getName());
        $this->assertEquals('john@example.com', $foundUser->getEmail());
        $this->assertEquals('password', $foundUser->getPassword());
    }
}