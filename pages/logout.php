<?php
require_once __DIR__ . '/../includes/config.php';

// Clear session and redirect to login.
session_start();
session_unset();
session_destroy();

header('location:' . APP_BASE . '/pages/login.php');

exit;
