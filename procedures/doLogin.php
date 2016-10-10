<?php

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../bootstrap.php';

// Find user with email
$user = findUserByEmail(request()->get('email'));

if(empty($user)) {
    $session->getFlashBag()->add('error', 'Username or Password is incorrect!');
    redirect('/login.php');
    exit;
}

if(!password_verify(request()->get('password'), $user['password'])) {
    $session->getFlashBag()->add('error', 'Username or Password is incorrect!');
    redirect('/login.php');
    exit;
}

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
$accessToken = new Cookie("access_token", $jwt, $expTime, '/', getenv('COOKIE_DOMAIN'));
$response->headers->setCookie($accessToken);

// Send to index page
$response->send();