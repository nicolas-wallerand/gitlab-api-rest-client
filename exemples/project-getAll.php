<?php

use ApiClientGitlab\ApiClient;
use ApiClientGitlab\Services\Projects;
use Dotenv\Dotenv;

define('APP_PATH', realpath('..'));

// Require composer autoload
require APP_PATH . '/vendor/autoload.php';

// Load Environment variables
$dotenv = new Dotenv(APP_PATH);
$dotenv->load();

if (getenv('ENVIRONMENT') && getenv('ENVIRONMENT') === 'development') {
    // Display screen
    ini_set('display_errors', 1);
    // Display error and warning
    error_reporting(E_ALL);
}

$token = getenv('GITLAB_TOKEN');
$type = getenv('GITLAB_TYPE_ACCESS_TOKEN');
$endpoint = getenv('GITLAB_ENDPOINT');

$client = new ApiClient($endpoint, $token, $type);
$serviceProjects = new Projects($client);

$result = $serviceProjects->getAll();
if ($result->success()) {
    dump($result->current());
    dump([
        'The total number of items'                     => $result->countTotalOfItem(),
        'The total number of pages'                     => $result->countTotalOfPages(),
        'Total of item'                                 => $result->countTotalOfItem(),
        'The number of items per page'                  => $result->countItemPerPage(),
        'The index of the current page (starting at 1)' => $result->getIndexCurrentPage(),
        'The index of the next page'                    => $result->getIndexOfNextPage(),
        'The index of the previous page'                => $result->getIndexOfPrevPage(),
    ]);
}