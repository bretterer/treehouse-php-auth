<?php

use Symfony\Component\HttpFoundation\Cookie;

require_once __DIR__ . '/bootstrap.php';

$accessToken = new Cookie("access_token", 'EXPIRED', time()-3600, '/', 'php-auth.dev');

redirect('/', ['cookies' => [$accessToken]]);