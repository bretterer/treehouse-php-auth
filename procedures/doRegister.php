<?php

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../bootstrap.php';


// Confirm passwords are the same
$passwordEqual = request()->get('password') === request()->get('confirm_password');
if(!$passwordEqual) {
    $session->getFlashBag()->add('error', 'Passwords do not match');
    redirect('/register.php');
    exit;
}

// Check to see if user exists already with that email
$user = findUserByEmail(request()->get('email'));
if(!empty($user)) {
    $session->getFlashBag()->add('error', 'Account with email already exists!');
    redirect('/register.php');
    exit;
}

// Generate a new bcrypt password
$hash = password_hash(request()->get('password'), PASSWORD_DEFAULT);

$userId = createUser(request()->get('email'), $hash);

$user = findUserByEmail(request()->get('email'));


// Generate an access_token JWT
$expTime = time() + 3600;
$jwt = \Firebase\JWT\JWT::encode([
    'iss' => request()->getBaseUrl(),
    'sub' => "{$user['id']}",
    'exp' => $expTime,
    'iat' => time(),
    'nbf' => time(),
    'is_admin' => $user['role_id'] == 1

], getenv("SECRET_KEY"), 'HS256');


// Store JWT in cookie
$response = Response::create('', Response::HTTP_FOUND, ['Location' => '/']);
$accessToken = new Cookie("access_token", $jwt, $expTime, '/', 'php-auth.dev');
$response->headers->setCookie($accessToken);

// Send to index page
$response->send();