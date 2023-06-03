<?php

require_once '../vendor/autoload.php';
require_once 'models/User.php';
require_once 'services/HttpRouter.php';
require_once 'services/PDOConnection.php';
require_once 'repository/UserRepository.php';

use Server\Models\User;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\UserRepository;
use Server\Services\PDOConnection;
use Server\Services\HttpRouter;

header('Access-Control-Allow-Origin: http://brigade-one-quiz-game');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$router = new HttpRouter();
$connection = new PDOConnection('localhost', 'quiz_db', 'root', null);

$router->addRoute('POST', '/sign_up', function () use ($connection): bool {
    $ur = new UserRepository(
        new QueryExecutor($connection->getConnection()),
        new IDGenerator()
    );
    $user = new User(
        null,
        $_POST['name'],
        $_POST['email'],
        $_POST['password'],
        $_POST['roleName']
    );
    return $ur->create($user);
});

$router->addRoute('POST', '/sign_in', function () use ($connection): ?\Server\Models\User {
    $ur = new UserRepository(
        new QueryExecutor($connection->getConnection()),
        new IDGenerator()
    );
    $user = $ur->fetchByEmail($_POST['email']);
    return ($user->getPassword() === $_POST['password'])
        ? $user
        : null;
});

// Listen for incoming client requests
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

$router->route($method, $path);
