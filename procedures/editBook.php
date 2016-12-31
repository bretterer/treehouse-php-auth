<?php

use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../inc/bootstrap.php';

requireAuth();

$bookId = request()->get('bookId');
$bookTitle = request()->get('title');
$bookDescription = request()->get('description');

try {
    $newBook = updateBook($bookId, $bookTitle, $bookDescription);
    $session->getFlashBag()->add('success', 'Book "' . $bookTitle . '" updated!');
    redirect('/books.php');
} catch ( \Error $e ) {
    $session->getFlashBag()->add('error', $e->getMessage());
    redirect('/add.php');
}

