#!/usr/bin/env php
<?php

define('APP_PATH', realpath('.'));

require APP_PATH . '/vendor/autoload.php';

use ApiClientGitlab\Commands\JobsCommand;
use Dotenv\Dotenv;
use Symfony\Component\Console\Application;

// Load Environment variables
$dotenv = new Dotenv(APP_PATH);
$dotenv->load();

if (getenv('ENVIRONMENT') && getenv('ENVIRONMENT') === 'development') {
    // Display screen
    ini_set('display_errors', 1);
    // Display error and warning
    error_reporting(E_ALL);
}

$application = new Application();

$config = [
    'GITLAB_TOKEN'             => getenv('GITLAB_TOKEN'),
    'GITLAB_TYPE_ACCESS_TOKEN' => getenv('GITLAB_TYPE_ACCESS_TOKEN'),
    'GITLAB_ENDPOINT'          => getenv('GITLAB_ENDPOINT'),
];
// ... register commands
$application->add(new JobsCommand($config));

$application->run();