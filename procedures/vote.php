<?php

require __DIR__ . '/../inc/bootstrap.php';

requireAuth();

$vote = request()->get('vote');
$book = getBook(request()->get('bookId'));

$currentVote = getUserVote($book);
clearVote($book);

if($currentVote === false) {
    switch (strtolower($vote)) {
        case 'up' :
            voteUp($book);
            break;
        case 'down' :
            voteDown($book);
            break;
    }
}

redirect('/books.php');


