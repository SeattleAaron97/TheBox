<?php
session_start(); 
//page is dedicated to retrieving a user's account balance
include_once("includes/dbh.inc.php");
 
	//$UID = $_POST['userIdVariable'];
 
	$UID = $_SESSION['u_uid'];
	
	$balance = "SELECT account_balance FROM `users` WHERE user_uid = \"$UID\"";//this line probably works

	$result = mysqli_query($conn, $balance);
	$finalResult = mysqli_fetch_array($result, MYSQLI_NUM);
	
	//printf , var_dump are really informative output functions.
	
	echo("your account balance is ");
	echo($finalResult["0"]);

exit;	

?>
