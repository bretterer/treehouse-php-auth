<?php

require __DIR__ . '/bootstrap.php';

$db->beginTransaction();

try {
    $createUsers = $db->exec("CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id int(10) UNSIGNED,
    created_at datetime DEFAULT CURRENT_TIMESTAMP
    )");

    $createBooks = $db->query("CREATE TABLE books (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description LONGTEXT NOT NULL,
    owner_id int(10) UNSIGNED,
    created_at datetime DEFAULT CURRENT_TIMESTAMP
    )");

    $createVotes = $db->query("CREATE TABLE votes (
    book_id INT(10) UNSIGNED,
    user_id INT(10) UNSIGNED,
    value float NOT NULL
    )");

    $db->commit();
    redirect('/register.php');

} catch (\Exception $e) {
    $db->rollBack();

    if($e->getCode() == '42S01') {
        redirect('/');
    }

    dump($e);
}