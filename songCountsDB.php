<?php

//make this file run from the songplay button. may have to rework song play structure.
//When this button is clicked, this file must take in the parameters of the song selected and the currently logged in user. 
//Then, it must test if that user has already listened to this song. If yes, it adds to the third column of listens.
//If no, it must create a new row, for the song/user pair.

session_start(); 

include_once("includes/dbh.inc.php");

$UID = $_SESSION['u_id']; //this line works
$SongID = $_GET['q']; //this line works, gets the ID number of the song from the JS file via the URL

//use the UID and SongID variable to make the SQL query. 

//echo($UID);  
//echo($SongID);
 

$Value = "SELECT * FROM `songcounts` WHERE songID = \"$SongID\" and userUID = \"$UID\"";

//var_dump($conn);

$result = mysqli_query($conn, $Value);
$numRows = mysqli_num_rows($result);
//echo("numRows = ");
//echo($numRows);


if($numRows){ //result is true, meaning the song/user pair already exists, so we need to update. 
	//echo("in the if, result returned true"); 
	$UpdateQuery = "UPDATE songcounts SET listens=listens+1 WHERE songID = \"$SongID\" and userUID = \"$UID\"";
	mysqli_query($conn, $UpdateQuery);
}

else{ //result is false, meaning the song/user pair does not exist, so we need to insert.
	//echo("in the else, result returned false");
	$InsertQuery = "INSERT INTO songcounts (songID, userUID, listens) VALUES ('$SongID','$UID','1');";
	mysqli_query($conn, $InsertQuery);
}






?>
