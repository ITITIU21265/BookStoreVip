<?php
// Database connection settings.
$host = "localhost";
$user = "root";
$pass = ""; 
$db = "shop_db";
$port = 3306;

// Open a database connection for the app.
$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Compute a base path for links (works from /pages or /admin).
if (!defined('APP_BASE')) {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $baseDir = str_replace('\\', '/', dirname($scriptName));
    $baseDir = rtrim($baseDir, '/');

    while (in_array(basename($baseDir), ['pages', 'admin'], true)) {
        $baseDir = str_replace('\\', '/', dirname($baseDir));
        $baseDir = rtrim($baseDir, '/');
    }

    if ($baseDir === '' || $baseDir === '/') {
        $baseDir = '';
    }

    define('APP_BASE', $baseDir);
}
