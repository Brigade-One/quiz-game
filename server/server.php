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
$conn = (new Database(
    new PDO('mysql:host=localhost;dbname=quiz_db', 'root', null)
))->getConnection();

if ($method != 'GET') {
    $post_data = json_decode(file_get_contents('php://input'));
    echo "ok";
    echo $post_data;
    print_r($post_data);
}
echo "not ok";
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

$router->addRoute('POST', '/question', function () use ($conn, $post_data) {
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $question = new Question(
        null,
        $post_data->question,
        $post_data->answer,
        $post_data->hint,
        $post_data->difficulty,
    );

    $qr->create($question);
});

$router->addRoute('GET', '/question', function () use ($conn, $post_data) {
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $question = $qr->fetchByID($post_data->questionID);

    echo $question->toJSON();
});

$router->addRoute('PUT', '/question', function () use ($conn, $post_data) {
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $question = $qr->fetchByID($post_data->questionID);

    $question->setAnswer($post_data->answer);
    $question->setHint($post_data->hint);
    $question->setDifficulty($post_data->difficulty);
    $question->setQuestion($post_data->question);

    $qr->update($question);
});

$router->addRoute('DELETE', '/question', function () use ($conn, $post_data) {
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $question = $qr->fetchByID($post_data->questionID);

    $qr->delete($question);
});

$router->route($method, $path);