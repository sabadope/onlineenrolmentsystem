<?php 
require_once '../include/initialize.php';

// 1. Start the session
session_start();

// 2. Log the logout event in the database
$sql = "INSERT INTO `tbllogs` (`USERID`, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
        VALUES (" . $_SESSION['ACCOUNT_ID'] . ",'" . date('Y-m-d H:i:s') . "','" . $_SESSION['ACCOUNT_TYPE'] . "','Logged out')";
$mydb->setQuery($sql);
$mydb->executeQuery();

// 3. Unset all session variables
unset($_SESSION['ACCOUNT_ID']);
unset($_SESSION['ACCOUNT_NAME']);   
unset($_SESSION['ACCOUNT_USERNAME']);  
unset($_SESSION['ACCOUNT_PASSWORD']);     
unset($_SESSION['ACCOUNT_TYPE']);         

// 4. Destroy the session
session_destroy();

// 5. Force the browser to forget the HTTP authentication credentials
header('HTTP/1.0 401 Unauthorized'); // Forces the browser to show HTTP Basic Authentication prompt
header('WWW-Authenticate: Basic realm="Restricted Admin Access"'); // Specify the realm to re-authenticate
header('Location: login.php'); // Redirect back to the login page

exit;
?>
