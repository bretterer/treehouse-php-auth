<?php

require_once __DIR__ . '/../inc/bootstrap.php';

requireAuth();

$book = getBook(request()->get('bookId'));
if(accessToken('sub') == $book['owner_id'] || isAdmin()) {
    deleteBook($book['id']);
    $session->getFlashBag()->add('success', 'Book "' . $book['name'] . '" deleted!');
    redirect('/books.php');
}

redirect('/unauthorized.php');