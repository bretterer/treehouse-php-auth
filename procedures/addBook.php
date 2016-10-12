<?php

use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../bootstrap.php';

requireAuth();

$bookTitle = request()->get('title');
$bookDescription = request()->get('description');

try {
    $newBook = addBook($bookTitle, $bookDescription);
    $session->getFlashBag()->add('success', 'Book "' . $bookTitle . '" added!');
    redirect('/books.php');
} catch ( \Exception $e ) {
    redirect('/add.php');
}

