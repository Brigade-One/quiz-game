<?php

require_once '../vendor/autoload.php';

use Server\Models\PackageQuestionLink;
use Server\Models\TrainingHistory;
use Server\Models\User;
use Server\Models\Package;
use Server\Models\Question;
use Server\Models\UserPackageLink;
use Server\Repository\Competition\CompetitionPackageQuestionLinkRepository;
use Server\Repository\Competition\CompetitionPackageRepository;
use Server\Repository\Database;
use Server\Repository\QuestionRepository;
use Server\Repository\QueryExecutor;
use Server\Repository\IDGenerator;
use Server\Repository\PackageQuestionLinkRepository;
use Server\Repository\UserPackageLinkRepository;
use Server\Repository\TrainingHistoryRepository;
use Server\Repository\Competition\CompetitionHistoryRepository;
use Server\Repository\UserRepository;
use Server\Repository\PackageRepository;
use Server\Services\HttpRouter;
use Server\Services\UserPool;


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
    if (!$user) {
        echo "No user with such email";
        return;
    }
    echo ($user->getPassword() === $receivedUser->getPassword())
        ? $user->toJSON()
        : "Password is incorrect";
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

$router->addRoute('POST', '/user_pool', function () {
    $userID = $_GET['userID'];
    $userPool = new UserPool();
    $userPool->addUser($userID);
    $pair = $userPool->getCompetitionPair();
    if (!$pair) {
        return;
    }
    if ($pair[0] === $userID) {
        echo json_encode([
            'opponentID' => $pair[1]
        ]);
    } else {
        echo json_encode([
            'opponentID' => $pair[0]
        ]);
    }
});
$router->addRoute('GET', '/competition_package', function () use ($conn) {
    $cpr = new CompetitionPackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $cpqlr = new CompetitionPackageQuestionLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $cpackages = $cpr->fetchAll();

    $randomPackage = $cpackages[array_rand($cpackages)];

    $cpqls = $cpqlr->fetchQuestionsByPackageID($randomPackage->getID());

    $questions = [];
    foreach ($cpqls as $cpql) {
        $questions[] = $cpql->toJSON();
    }
    echo json_encode([
        'package' => $randomPackage->toJSON(),
        'questions' => $questions
    ]);

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

$router->addRoute('GET', '/achievements', function () use ($conn, $json) {
    $thr = new TrainingHistoryRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $chr = new CompetitionHistoryRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $uplr = new UserPackageLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $userID = $_GET['userID'];
    $trainingAccuracy = $thr->fetchUserTrainingAccuracyByUserID($userID);
    $competitionAccuracy = $chr->fetchUserCompetititonAccuracyByUserID($userID);
    $trainingLastDate = $thr->fetchLastTrainingDate($userID);
    $createdPackagesNumber = $uplr->fetchUserPackagesNumber($userID);

    echo json_encode([
        'trainingAccuracy' => $trainingAccuracy,
        'competitionAccuracy' => $competitionAccuracy,
        'trainingLastDate' => $trainingLastDate,
        'createdPackagesNumber' => $createdPackagesNumber
    ]);
});


$router->addRoute('POST', '/training_results', function () use ($conn, $json) {
    $thr = new TrainingHistoryRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $trainingHistory = TrainingHistory::fromJSON($json);
    if (!$thr->create($trainingHistory)) {
        echo 'Something went wrong while saving training history';
    }
    echo 'Training history saved successfully';
});

$router->addRoute('GET', '/package_questions', function () use ($conn, $json) {
    $qr = new PackageQuestionLinkRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );

    $packageID = $_GET['packageID'];
    $questions = $qr->fetchQuestionsByPackageID($packageID);

    $questionsJSON = [];
    foreach ($questions as $receivedQuestion) {
        $question = Question::fromJSON($receivedQuestion);
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
$router->addRoute('PUT', '/update_package', function () use ($conn, $json) {
    $pr = new PackageRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $qr = new QuestionRepository(
        new QueryExecutor($conn),
        new IDGenerator()
    );
    $decodedJSON = json_decode($json);
    // Retrieve package name and questions from JSON
    $packageID = $decodedJSON->packageID;
    $receivedQuestions = $decodedJSON->questions;

    // Create package and questions instances from received data
    $package = $pr->fetchByID($packageID);

    // Update package
    $pr->update($package);

    foreach ($receivedQuestions as $receivedQuestion) {
        $receivedQuestionInstance = Question::fromJSON(json_encode($receivedQuestion));
        $qr->update($receivedQuestionInstance);
    }

    echo "Package updated successfully";
});

$router->route($method, $path);