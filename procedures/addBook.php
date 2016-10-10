<?php

use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../bootstrap.php';

requireAuth();

$bookTitle = request()->get('title');
$bookDescription = request()->get('description');

try {
    $newBook = addBook($bookTitle, $bookDescription);
    $response = Response::create(null, Response::HTTP_FOUND, ['Location' => '/']);
    $response->send();
} catch ( \Exception $e ) {
    $response = Response::create(null, Response::HTTP_FOUND, ['Location' => '/add.php']);
    $response->send();
}

