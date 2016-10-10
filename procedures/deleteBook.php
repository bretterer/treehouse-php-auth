<?php

require_once __DIR__ . '/../bootstrap.php';

requireAuth();

$book = getBook(request()->get('bookId'));
if(accessToken('sub') == $book['owner_id'] || isAdmin()) {
    deleteBook($book['id']);
    redirect('/');
}

redirect('/unauthorized.php');