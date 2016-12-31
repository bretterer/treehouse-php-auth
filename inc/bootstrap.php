<?php

use Symfony\Component\HttpFoundation\Session\Session;

require_once __DIR__ . '/../vendor/autoload.php';

$session = new \Symfony\Component\HttpFoundation\Session\Session();
$session->start();

// Load our Env file
$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();

require_once __DIR__ . '/connection.php';
