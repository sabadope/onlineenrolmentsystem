<?php 
require_once("../include/initialize.php"); // This already starts the session — DO NOT call session_start() again

// First, check if the user is logged in
if (!isset($_SESSION['ACCOUNT_ID']) || $_SESSION['ACCOUNT_TYPE'] !== 'Administrator') {
    redirect(web_root . "admin/login.php");
    exit();
}

// Add HTTP Basic Authentication
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Restricted Admin Access"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Access denied. Only admins can access this page.";
    exit;
}

// Set your valid admin credentials (hardcoded)
$valid_username = 'admin';
$valid_password = 'administrator';

if ($_SERVER['PHP_AUTH_USER'] !== $valid_username || $_SERVER['PHP_AUTH_PW'] !== $valid_password) {
    header('WWW-Authenticate: Basic realm="Restricted Admin Access"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Access denied. Only admins can access this page.";
    exit;
}

// Continue with normal admin page routing
$content = 'home.php';
$view = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';

switch ($view) {
    case '1':
        $title = "Home";	
        $content = 'home.php';		
        break;
    default:
        $title = "Home";	
        $content = 'home.php';		
}

require_once("theme/templates.php");
?>