<?php

require_once '../vendor/autoload.php';

use Server\Models\User;
use Server\Models\User\UserRole;
use Server\Repository\Database;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\UserRepository;
use Server\Services\HttpRouter;

header('Access-Control-Allow-Origin: http://brigade-one-quiz-game');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$router = new HttpRouter();
$db = new Database(
    new PDO('mysql:host=localhost;dbname=quiz_db', 'root', null)
);

$router->addRoute('POST', '/sign_up', function () use ($db): bool {
    $ur = new UserRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );
    $user = new User(
        null,
        $_POST['name'],
        $_POST['email'],
        $_POST['password'],
        UserRole::RegularUser
    );
    return $ur->create($user);
});

$router->addRoute('POST', '/sign_in', function () use ($db): ?\Server\Models\User {
    $ur = new UserRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );
    $user = $ur->fetchByEmail($_POST['email']);
    return ($user->getPassword() === $_POST['password'])
        ? $user
        : null;
});

$router->addRoute('PUT', '/user', function () use ($db): bool {
    $ur = new UserRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );
    $user = new User(
        $_POST['id'],
        $_POST['name'],
        $_POST['email'],
        $_POST['password'],
        UserRole::from($_POST['roleId'])
    );
    return $ur->update($user);
});

$router->addRoute('DELETE', '/user', function () use ($db): bool {
    $ur = new UserRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );
    $user = $ur->fetchById($_POST['id']);
    return $ur->delete($user);
});

// Listen for incoming client requests
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

$router->route($method, $path);
