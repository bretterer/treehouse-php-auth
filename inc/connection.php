<?php
$host = getenv( 'DB_HOST' );
$db   = getenv( 'DB_NAME' );
$user = getenv( 'DB_USER' );
$pass = getenv( 'DB_PASS' );
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $db = new PDO( $dsn, $user, $pass, $opt);
} catch ( \Exception $e ) {
    print 'Error connecting to the Database: ' . $e->getMessage();
    exit;
}