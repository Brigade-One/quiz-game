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

// Listen for incoming client requests
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

$router = new HttpRouter();
$conn = (new Database(
    new PDO('mysql:host=localhost;dbname=quiz_db', 'root', null)
))->getConnection();

if ($method != 'GET') {
    $post_data = json_decode(file_get_contents('php://input'));
}

$router->addRoute('POST', '/sign_up', function () use ($conn, $post_data) {
    $ur = new UserRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $user = new User(
        null,
        $post_data->user,
        $post_data->email,
        $post_data->password,
        UserRole::RegularUser
    );

    if ($ur->create($user)) {
        echo $user->toJSON();
    }
});

$router->addRoute('POST', '/sign_in', function () use ($conn, $post_data) {
    $ur = new UserRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $user = $ur->fetchByEmail($post_data->email);

    echo ($user->getPassword() === $post_data->password)
        ? $user->toJSON()
        : null;
});

$router->addRoute('PUT', '/user', function () use ($conn, $post_data) {
    $ur = new UserRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $user = $ur->fetchById($post_data->userID);

    $user->setEmail($post_data->email);
    $user->setPassword($post_data->password);
    $user->setName($post_data->Name);

    $ur->update($user);
});

$router->addRoute('DELETE', '/user', function () use ($conn, $post_data) {
    $ur = new UserRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $user = $ur->fetchById($post_data->userID);

    $ur->delete($user);
});

$router->addRoute('POST', '/package', function () use ($conn, $post_data) {

    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $pqlr = new PackageQuestionLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $package = new Package(null, $post_data->name, false);
    $pr->create($package);

    $pql = new PackageQuestionLink(null, $package->getPackageID(), '');
    foreach ($post_data->questionsIDs as $questionID) {
        $pql->setQuestionID($questionID);
        $pqlr->create($pql);
    }
});

$router->addRoute('PUT', '/package', function () use ($conn, $post_data) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $package = $pr->fetchByID($post_data->packageID);
    $package->setIsApproved($post_data->isApproved);
    $package->setName($post_data->name);

    $pr->update($package);
});

$router->addRoute('DELETE', '/package', function () use ($conn, $post_data) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $package = $pr->fetchByID($post_data->packageID);

    $pr->delete($package);
});

$router->addRoute('GET', '/package', function () use ($conn, $post_data) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    echo $pr->fetchByID($post_data->packageID)->toJSON();
});

$router->addRoute('GET', '/public_packages', function () use ($conn, $post_data) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    echo json_encode($pr->fetchPublicPackages());
});

$router->route($method, $path);