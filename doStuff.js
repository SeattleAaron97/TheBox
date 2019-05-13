// IMPORTANT 
// to log into mySQL server go to terminal and enter exact path 
// /usr/local/mysql/bin/mysql -uroot -p
// then press enter. password is SQLpassword163724

var currentSelectedSong = -1;
var songPlayCounter = 0;
var songSrcOld = "x";
var masterVol = 0.5;

document.addEventListener("DOMContentLoaded", getJSONData, false );

function getJSONData(){
            var json_url = 'songData.json';
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() { 
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText); // convert the response to a json object
                    append_json(data);// pass the json object to the append_json function
                }
            }
            xmlhttp.open("POST", json_url, true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(); 
        }

function append_json(data){//makes the song table
            var table = document.getElementById('myTable');
			
            data.forEach(function(object) {
                var tr = document.createElement('tr');
                tr.innerHTML = '<td onclick="myFunction(this)">' + object.Name + '</td>' +
                '<td>' + object.Artist + '</td>' +
                '<td>' + object.Album + '</td>' +
                '<td>' + object.Genre + '</td>' +
                '<td>' + object.SongLength + '</td>' +
                '<td>' + object.ReleaseDate + '</td>';
				
                table.appendChild(tr);
            });
}


function myFunction(x) {//makes the song table
	var table = document.getElementById('myTable');
    var cells = table.getElementsByTagName('td');
	
	for(var i = 0; i < cells.length; i++) {
        // Take each cell
        var cell = cells[i];
        // do something on onclick event for cell
        cell.onclick = function () {
            // Get the row id where the cell exists
            var rowId = this.parentNode.rowIndex;

            var rowsNotSelected = table.getElementsByTagName('tr');
            for (var row = 0; row < rowsNotSelected.length; row++) {
                rowsNotSelected[row].style.backgroundColor = "";
                rowsNotSelected[row].classList.remove('selected');
            }
            var rowSelected = table.getElementsByTagName('tr')[rowId];
            rowSelected.style.backgroundColor = "white";
            rowSelected.className += " selected";
			
			console.log("rowId = " + rowId);
			currentSelectedSong = (rowId - 1);

        }
    }

} //end of function


function songActionButton(){//called from the HTML play button
	
	if(currentSelectedSong == -1){
		alert("No song is selected. Please select a song by clicking the song name until it turns yellow, then press the play button.");
	}
	else{
		songPlayCounter++;	
		
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if(xhr.readyState == XMLHttpRequest.DONE) {
				var fileText = xhr.responseText;
				callPHP(fileText);
				playSong(fileText);			
			}		 
		}	
		xhr.open('GET', 'songData.json', true);
		xhr.send(null);	
	}
	
}

function callPHP(theText){ // calls the soungCountsDB.php file
		
		var jsonText = JSON.parse(theText);
		var selectedSongId = jsonText[currentSelectedSong].id;
		console.log("selectedSongId = " + selectedSongId);

		var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("textDisplay").innerHTML = this.responseText;
            }
        };
        //xmlhttp.open("GET", "songCountsDB.php", true);//this line works
		var q = selectedSongId;
		xmlhttp.open("GET", "songCountsDB.php?q=" + q, true);
        xmlhttp.send();
}


function playSong(myText){
	//console.log("myText = " + myText);
	var jsonText = JSON.parse(myText);
	//console.log("jsonText = " + jsonText);
	var source = jsonText[currentSelectedSong].Src;
	//console.log("source = "+ source);
	

	
	if(songSrcOld != source){
		sound = new Howl({
			src: [source],
		});
	}
	console.log("playSong method, masterVol = " + masterVol);
	sound.volume(masterVol);
	songSrcOld = source;
	if(songPlayCounter % 2 == 1){

		document.getElementById("ButtonImage").src="https://image.flaticon.com/icons/svg/61/61039.svg";//pause image
                        
		sound.play();
		playDisplay(jsonText);
        console.log("in audio.play if");

     }
     if(songPlayCounter % 2 == 0){
        document.getElementById("ButtonImage").src="https://image.flaticon.com/icons/svg/26/26025.svg";//play image
        sound.pause();
        console.log("in audio.pause if");

     }
	
}

function playDisplay(parsedText){
	var songName = parsedText[currentSelectedSong].Name;
	var artistName = parsedText[currentSelectedSong].Artist;
	var selectedSongId = parsedText[currentSelectedSong].id;
	//document.getElementById("playDisplay").innerHTML = "You're listening to " + songName + " by " + artistName + ".";
	
		

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("playDisplay").innerHTML = "You're listening to " + songName + " by " + artistName + "." + " This song has been listened to " + this.responseText + " times.";
		}
	};
	//xmlhttp.open("GET", "songCountsDB.php", true);//this line works
	var q = selectedSongId;
	xmlhttp.open("GET", "retrieveListens.php?q=" + q, true);
	xmlhttp.send();

	
	
}

function setVolume(param){
	var value = param.value;
	console.log("in the set volume method val = " + value);
	masterVol = value/10;
	Howler.volume(masterVol);
}

function checkBalance(uid){
	var userId=uid;
	$.ajax({
	url:'retrieveBalance.php',
	method:'get',
	data:{name:userId},
	success:function(data)
	{
		document.getElementById("balanceDisplayID").innerHTML = "balance to be shown here";
		//alert("Success");
	},
	error:function(data)
	{
		alert("error");
	}
	});
}

function increaseBalanceButton(){
	console.log("made it to the increase balance button JS.");
	$.ajax({
		method: "GET", // request type here
		url: 'increaseBalance.php' // url here
	}).done(function(data) { // callback here
		console.log(data); // render what you want here
	});	
}

