<?php

try {
	$db = new PDO( 'sqlite:'.__DIR__.'/../database.db' );
} catch ( \Exception $e ) {
    print 'Error connecting to the Database: ' . $e->getMessage();
    exit;
}