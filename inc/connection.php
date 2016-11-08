<?php

try {
    $db = new PDO( 'sqlite::memory:');
} catch ( \Exception $e ) {
    print 'Error connecting to the Database: ' . $e->getMessage();
    exit;
}