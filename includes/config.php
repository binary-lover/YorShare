<?php
define('APP_ROOT', dirname(__DIR__));
define('SHARED_ROOT', APP_ROOT . '/Shared/');
define('ALLOW_UPLOADS', true);
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024 * 1024); // 5GB

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
