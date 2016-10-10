<?php

require __DIR__ . '/../bootstrap.php';

requireAuth();

$vote = request()->get('vote');
$book = getBook(request()->get('bookId'));
$clearOnly = request()->get('clearOnly');

clearVote($book);

if($clearOnly != "true") {
    switch (strtolower($vote)) {
        case 'up' :
            voteUp($book);
            break;
        case 'down' :
            voteDown($book);
            break;
    }
}

redirect('/');


