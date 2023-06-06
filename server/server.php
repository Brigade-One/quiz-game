<?php

require_once '../vendor/autoload.php';

use Server\Models\User;
use Server\Models\UserRole;
use Server\Models\Package;
use Server\Repository\Database;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\UserRepository;
use Server\Repository\PackageRepository;
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
    if ($ur->create($user)) {
        echo json_encode($user);
    }
    return false;
});

$router->addRoute('POST', '/sign_in', function () use ($db) {
    $ur = new UserRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );
    $user = $ur->fetchByEmail($_POST['email']);
    echo ($user->getPassword() === $_POST['password'])
        ? json_encode($user->toJSON())
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

$router->addRoute('POST', '/package', function () use ($db): bool {
    $pr = new PackageRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );
    $package = new Package(null, $_POST['name'], false);
    return $pr->create($package);
});

$router->addRoute('PUT', '/package', function () use ($db) {
    $pr = new PackageRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );
    $package = $pr->fetchByID($_POST['packageID']);
    $package->setIsApproved($_POST['isApproved']);
    $package->setName($_POST['name']);
    $pr->update($package);
});

$router->addRoute('DELETE', '/package', function () use ($db): bool {
    $pr = new PackageRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );

    $package = $pr->fetchByID($_POST['packageID']);
    return $pr->delete($package);
});

$router->addRoute('GET', '/package', function () use ($db): ?\Server\Models\Package {
    $pr = new PackageRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );
    return $pr->fetchByID($_GET['packageID']);
});

$router->addRoute('GET', '/public_packages', function () use ($db): array {
    $pr = new PackageRepository(
        new QueryExecutor($db->getConnection()),
        new IDGenerator()
    );
    echo json_encode( $pr->fetchPublicPackages());
    return [];
});

// Listen for incoming client requests
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

$router->route($method, $path);