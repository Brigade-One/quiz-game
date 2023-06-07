<?php

require_once '../vendor/autoload.php';

use Server\Models\User;
use Server\Repository\Database;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\PackageQuestionLinkRepository;
use Server\Repository\UserPackageLinkRepository;
use Server\Repository\UserRepository;
use Server\Repository\PackageRepository;
use Server\Services\HttpRouter;


header('Access-Control-Allow-Origin: http://quiz-game');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

$router = new HttpRouter();
$conn = (
    new Database(
        new PDO('mysql:host=localhost;dbname=quiz_db', 'root', null)
    )
)->getConnection();

$json = file_get_contents('php://input');

$router->addRoute('POST', '/sign_up', function () use ($conn, $json) {
    $ur = new UserRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $user = User::fromJSON($json);

    if ($ur->create($user)) { //TODO: id is not sending to client
        echo $user->toJSON();
    }
});

$router->addRoute('POST', '/sign_in', function () use ($conn, $json) {
    $ur = new UserRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $receivedUser = User::fromJSON($json);

    $user = $ur->fetchByEmail($receivedUser->getEmail());

    echo ($user->getPassword() === $receivedUser->getPassword())
        ? $user->toJSON()
        : null;
});

$router->addRoute('GET', '/public_packages', function () use ($conn, $json) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $packages = $pr->fetchPublicPackages();
    foreach ($packages as $package) {
        echo $package->toJSON();
    }
});

$router->addRoute('GET', '/user_packages', function () use ($conn, $json) {
    $uplr = new UserPackageLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $userID = $_GET['userID'];
    $packages = $uplr->fetchPackagesByUserID($userID);

    foreach ($packages as $package) {
        echo $package->toJSON();
    }
});

// Works
$router->addRoute('GET', '/package_questions', function () use ($conn, $json) {
    $qr = new PackageQuestionLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $packageID = $_GET['packageID'];
    $questions = $qr->fetchQuestionsByPackageID($packageID);
    foreach ($questions as $question) {
        echo $question->toJSON();
    }
});

$router->route($method, $path);