<!DOCTYPE html>
<meta charset="utf-8"/>
<script type="text/javascript" src="doStuff.js"></script>
<script type="text/javascript" src="songData.json"></script>
<!--<script src="jQuery3.3.1dev.js"></script> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="./howler.js-master/src/howler.core.js"></script>
<div id="logoutButton">

<form action="includes/logout.inc.php" method="POST">
	<button type="submit" name="submit">Logout</button>
</form>

</div>




<?php
session_start();
	
echo 'Hello User ';
echo $_SESSION['u_first'];
echo ' ';
echo $_SESSION['u_last'];

$id_var = $_SESSION['u_id'];

?>

<!--
<html>
<head>
-->
<link rel="stylesheet" type="text/css" href="theme.css">

<script>
	var uidVar = 2;
	$(document).ready(function(){
		$("button").click(function(){
			$("#balanceDisplay").load("retrieveBalance.php",{
				userIdVariable: uidVar
			});
		});
	});
</script>
</head>

<body>
<h1>
<heading>
THE BOX
</heading>
</h1>






<div class="container" style="width:900px;">
	<h3 align="center">Search Bar</h3>
	<div align="center">
		<input type="text" name="search" id="search" placeholder="Search Here" class="form-control" />
	</div>
	<ul class="list-group" id="result"></ul>
	
	
</div>

<script><!-- code for the search bar -->
	
	
$(document).ready(function(){
 $.ajaxSetup({ cache: false });
 $('#search').keyup(function(){
  $('#result').html('');
  $('#state').val('');
  var searchField = $('#search').val();
  var expression = new RegExp(searchField, "i");
  $.getJSON('songData.json', function(data) {
   $.each(data, function(key, value){
	console.log("searchField = " + searchField);
    if ((value.Name.search(expression) != -1 || value.Artist.search(expression) != -1 || value.Album.search(expression) != -1) && searchField.length > 0)
    {
     $('#result').append('<li class="list-group-item link-class">'+value.Name+' | <span class="text-muted">'+value.Artist+' | '+ value.Album+' | '+ value.Genre+ '</span></li>');
    }
   });   
  });
 });
 
 $('#result').on('click', 'li', function() {
  var click_text = $(this).text().split('|');
  $('#search').val($.trim(click_text[0]));
  $("#result").html('');
 });
});

</script>


<div style="height: 200px; overflow: auto">

<table style="width:100%" id="myTable">
	<tr>
		<th> Song Name</th>
		<th> Artist </th>
		<th> Album</th>
		<th> Genre</th>
		<th> Song Length</th>
		<th> Release Date</th>
	</tr>
	
</table>

</div>





<div id="soundControl">

<button onclick="songActionButton();"> <img id="ButtonImage" src="https://image.flaticon.com/icons/svg/26/26025.svg" height="50" width="50" ></button>

</div>

<div id="volumeControl">
  <input type="range" id="start" name="volume"
         min="0" max="10" onchange="setVolume(this)" onclick="setVolume(this)">
  <label for="volume">Volume</label>
</div>


<div id="balanceDisplay">

<button>Display Balance</button>

</div>


<div id="increaseBalance">

<button onclick="increaseBalanceButton();">Increase Balance</button>

</div>




<div id="textDisplay">

<!--empty div to display text from songCountsDB.php-->

</div>

<div id="playDisplay">

<!-- div to display info on song currently playing -->

</div>


<div id="bottomText">
<i>
                <proper>
Thanks for logging in! To listen to a song, click the name, and when it turns white click the play button. Cheers!
                </proper>
</i>
</div>

</body>
</html>


