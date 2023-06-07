<?php

require_once '../vendor/autoload.php';

use Server\Models\User;
use Server\Models\UserRole;
use Server\Models\Package;
use Server\Models\PackageQuestionLink;
use Server\Models\Question;
use Server\Repository\Database;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\PackageQuestionLinkRepository;
use Server\Repository\UserRepository;
use Server\Repository\PackageRepository;
use Server\Repository\QuestionRepository;
use Server\Services\HttpRouter;


header('Access-Control-Allow-Origin: http://brigade-one-quiz-game');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Listen for incoming client requests
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

    if ($ur->create($user)) {
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

$router->addRoute('PUT', '/user', function () use ($conn, $json) {
    $ur = new UserRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $user = $ur->fetchById($json->userID);

    $user->setEmail($json->email);
    $user->setPassword($json->password);
    $user->setName($json->Name);

    $ur->update($user);
});

$router->addRoute('DELETE', '/user', function () use ($conn, $json) {
    $ur = new UserRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $user = $ur->fetchById($json->userID);

    $ur->delete($user);
});

$router->addRoute('POST', '/package', function () use ($conn, $json) {

    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $pqlr = new PackageQuestionLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $package = new Package(null, $json->name, false);
    $pr->create($package);

    $pql = new PackageQuestionLink(null, $package->getPackageID(), '');
    foreach ($json->questionsIDs as $questionID) {
        $pql->setQuestionID($questionID);
        $pqlr->create($pql);
    }
});

$router->addRoute('PUT', '/package', function () use ($conn, $json) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $package = $pr->fetchByID($json->packageID);
    $package->setIsApproved($json->isApproved);
    $package->setName($json->name);

    $pr->update($package);
});

$router->addRoute('DELETE', '/package', function () use ($conn, $json) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $package = $pr->fetchByID($json->packageID);

    $pr->delete($package);
});

$router->addRoute('GET', '/package', function () use ($conn, $json) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    echo $pr->fetchByID($json->packageID)->toJSON();
});

$router->addRoute('GET', '/public_packages', function () use ($conn, $json) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    echo json_encode($pr->fetchPublicPackages());
});

$router->addRoute('POST', '/question', function () use ($conn, $json) {
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $question = new Question(
        null,
        $json->question,
        $json->answer,
        $json->hint,
        $json->difficulty,
    );

    $qr->create($question);
});

$router->addRoute('GET', '/question', function () use ($conn, $json) {
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $question = $qr->fetchByID($json->questionID);

    echo $question->toJSON();
});

$router->addRoute('PUT', '/question', function () use ($conn, $json) {
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $question = $qr->fetchByID($json->questionID);

    $question->setAnswer($json->answer);
    $question->setHint($json->hint);
    $question->setDifficulty($json->difficulty);
    $question->setQuestion($json->question);

    $qr->update($question);
});

$router->addRoute('DELETE', '/question', function () use ($conn, $json) {
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $question = $qr->fetchByID($json->questionID);

    $qr->delete($question);
});

$router->route($method, $path);