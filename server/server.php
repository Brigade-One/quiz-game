<?php

require_once '../vendor/autoload.php';
require_once 'services/PDOConnection.php';

use Server\Services\PDOConnection;

header('Access-Control-Allow-Origin: http://brigade-one-quiz-game');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$connection = new PDOConnection('localhost', 'quiz_db', 'root', null);

// Listen for incoming client requests
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];
