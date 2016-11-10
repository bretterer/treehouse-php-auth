<?php

try {
	$newBook = updateBook($bookId, $bookTitle, $bookDescription);
	redirect('/books.php');
} catch ( \Error $e ) {
	redirect('/add.php');
}