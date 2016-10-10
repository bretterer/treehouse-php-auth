<?php

require __DIR__ . '/../bootstrap.php';

requireAdmin();

$user = findUserById(request()->get('userId'));
$role = request()->get('role');

switch (strtolower($role)) {
    case 'promote' :
        promote($user);
        break;
    case 'demote' :
        demote($user);
        break;
}


redirect('/admin.php');


