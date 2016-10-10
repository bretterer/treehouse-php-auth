<?php

use Symfony\Component\HttpFoundation\Session\Session;

require_once __DIR__ . '/vendor/autoload.php';

$session = new Session();
$session->start();

// Load our Env file
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

require_once __DIR__ . '/inc/connection.php';