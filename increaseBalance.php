<?php

//page dedicated to increasing account balance

session_start();
require_once("includes/dbh.inc.php");

$UID = $_SESSION['u_uid'];
 
$sql = "UPDATE users SET account_balance=account_balance+1 WHERE user_uid=\"$UID\"";
 
echo $sql;

mysqli_query($conn, $sql);

header("Location: frontPage.php");


exit;


