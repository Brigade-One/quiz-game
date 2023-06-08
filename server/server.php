<?php

require_once '../vendor/autoload.php';

use Server\Models\PackageQuestionLink;
use Server\Models\User;
use Server\Models\Package;
use Server\Models\Question;
use Server\Models\UserPackageLink;
use Server\Repository\Database;
use Server\Repository\QuestionRepository;
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

    $ur->create($user);

    echo $user->toJSON();
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

    $packagesJSON = [];
    foreach ($packages as $package) {
        $packagesJSON[] = $package->toJSON();
    }
    echo json_encode($packagesJSON);
});

// Works
$router->addRoute('GET', '/user_packages', function () use ($conn, $json) {
    $uplr = new UserPackageLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $userID = $_GET['userID'];
    $packages = $uplr->fetchPackagesByUserID($userID);
    $packagesJSON = [];
    foreach ($packages as $package) {
        $packagesJSON[] = $package->toJSON();
    }
    echo json_encode($packagesJSON);
});

$router->addRoute('GET', '/package_questions', function () use ($conn, $json) {
    $qr = new PackageQuestionLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $packageID = $_GET['packageID'];
    $questions = $qr->fetchQuestionsByPackageID($packageID);

    $questionsJSON = [];
    foreach ($questions as $question) {
        $questionsJSON[] = $question->toJSON();
    }
    echo json_encode($questionsJSON);
});
// Works
$router->addRoute('POST', '/create_package', function () use ($conn, $json) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $pqlr = new PackageQuestionLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $uplr = new UserPackageLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $decodedJSON = json_decode($json);

    // Retrieve package name and questions from JSON
    $packageName = $decodedJSON->packageName;
    $userID = $decodedJSON->userID;
    $receivedQuestions = $decodedJSON->questions;

    // Create package and questions instances from received data
    $receivedPackage = new Package(null, $packageName, false);
    $receivedQuestionInstances = [];
    foreach ($receivedQuestions as $receivedQuestion) {
        $receivedQuestionInstances[] = Question::fromJSON(json_encode($receivedQuestion));
    }

    // Create package and questions in database
    $package = $pr->create($receivedPackage);
    $questions = [];
    foreach ($receivedQuestionInstances as $receivedQuestionInstance) {
        $questions[] = $qr->create($receivedQuestionInstance);
    }

    // Link questions to packages
    foreach ($questions as $question) {
        $pql = new PackageQuestionLink(
            null,
            $package->getPackageID(),
            $question->getQuestionID(),
        );
        if (!$pqlr->create($pql)) {
            echo 'Something went wrong while linking questions to package';
        }
    }

    // Link user to package
    $upl = new UserPackageLink(
        null,
        $userID,
        $package->getPackageID(),
    );
    if (!$uplr->create($upl)) {
        echo 'Something went wrong while linking user to package';
    }

    echo "Package created successfully";
});

$router->route($method, $path);