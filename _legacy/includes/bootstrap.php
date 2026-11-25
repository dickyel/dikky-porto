<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('ROOT_PATH', dirname(__DIR__));
define('DATA_PATH', ROOT_PATH . '/data');

require_once ROOT_PATH . '/includes/helpers.php';
require_once ROOT_PATH . '/includes/projects.php';
require_once ROOT_PATH . '/includes/auth.php';
