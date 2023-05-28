<?php

use PHPUnit\Framework\TestCase;
use Server\Repository\UserRepository;
use Server\Repository\QueryExecutor;
use Server\Repository\Database;
use Server\Models\User;
use function PHPUnit\Framework\assertEquals;

class UserRepositoryTest extends TestCase
{
    private $userRepository;
    private $database;
    private $queryExecutor;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=quiz_db_3', 'root', '');
        $database = new Database($pdo);
        $this->queryExecutor = new QueryExecutor($database->getConnection());
        $this->userRepository = new UserRepository($this->queryExecutor);
    }
    public function testCreate(): void
    {
        // Create a new user
        $user = new User(
            null,
            'Demo User',
            'example2@example.com',
            'password',
            'user'
        );

        // Save the user to the database
        $this->userRepository->create($user);

        // Assert that the user was successfully saved to the database
        $this->assertNotEmpty($this->userRepository->findByEmail($user->getEmail()));
    }

    public function testFindById(): void
    {
        // Retrieve the user using findById
        $foundUser = $this->userRepository->findById('a6d1b4d6-2c99-4c1c-9951-cab2dcc55367');

        // Assert that the retrieved user matches the expected values
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals('Morrigan Doe', $foundUser->getName());
        $this->assertEquals('example2@example.com', $foundUser->getEmail());
        $this->assertEquals('password', $foundUser->getPassword());
        $this->assertEquals('user', $foundUser->getRoleName());
    }
    public function testFetchAll(): void
    {
        // Retrieve all users
        $users = $this->userRepository->fetchAll();

        // Assert that the users array is not empty
        $this->assertNotEmpty($users);

        // Assert that each element in the users array is an instance of the User class
        foreach ($users as $user) {
            $this->assertInstanceOf(User::class, $user);
        }
    }
    public function testUpdate(): void
    {
        // Retrieve the user using findById
        $user = $this->userRepository->findById('a6d1b4d6-2c99-4c1c-9951-cab2dcc55367');

        // Update the user's name and email address
        $user->setName('Morrigan Doe');

        // Save the updated user to the database
        $this->userRepository->update($user);

        // Retrieve the user again using findById
        $updatedUser = $this->userRepository->findById('a6d1b4d6-2c99-4c1c-9951-cab2dcc55367');
        assertEquals('Morrigan Doe', $updatedUser->getName());
    }
    /* public function testDelete(): void
    {
        // Retrieve the user using findById
        $user = $this->userRepository->findById('9797c38d-53dd-445c-b95c-e9aa4879bbf3');

        // Delete the user from the database
        $this->userRepository->delete($user);

        // Assert that the user was successfully deleted from the database
        $this->assertEmpty($this->userRepository->findById('9797c38d-53dd-445c-b95c-e9aa4879bbf3'));
    } */
}