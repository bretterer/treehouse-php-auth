<?php

use Symfony\Component\HttpFoundation\Cookie;

require_once __DIR__ . '/../inc/bootstrap.php';;

$accessToken = new Cookie("access_token", null, time()-3600, '/', getenv('COOKIE_DOMAIN'));

// Send to index page
redirect('/', ['cookies' => [$accessToken]]);