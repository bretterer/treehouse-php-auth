<?php

require __DIR__ . '/../bootstrap.php';

requireAdmin();

$user = findUserById(request()->get('userId'));
$role = request()->get('role');

switch (strtolower($role)) {
    case 'promote' :
        promote($user);
        $session->getFlashBag()->add('success', "{$user['email']} Promoted to Admin!");
        break;
    case 'demote' :
        demote($user);
        $session->getFlashBag()->add('success', "{$user['email']} Demoted from Admin!");
        break;
}


redirect('/admin.php');


