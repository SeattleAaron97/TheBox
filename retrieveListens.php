<?php
session_start(); 

include_once("includes/dbh.inc.php");

$UID = $_SESSION['u_uid'];
$SongID = $_GET['q'];

//$totalListens = "SELECT songID, SUM(listens) as totalListens FROM songcounts GROUP BY 1";
$totalListens = "SELECT songID, SUM(listens) as totalListens FROM songcounts WHERE songID = \"$SongID\" GROUP BY 1 ";


$result = mysqli_query($conn, $totalListens);
$finalResult = mysqli_fetch_array($result, MYSQLI_NUM);


//var_dump($finalResult);


//SELECT 1, SUM(listens) as totalListens
//FROM songcounts
//GROUP BY 1

//echo(" Total Listens to this song are ");

echo($finalResult['1']);


//echo($finalResult["\"$UID\""]);
