<?php

session_start();

if(isset($_POST['submit'])) {
	
	include 'dbh.inc.php';
	
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	
	//error handlers here
	//checking if inputs are empty
	if(empty($uid) || empty($pwd)){
		header("Location: ../index.php?login=empty");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if($resultCheck < 1){ //checks if UID is taken
			header("Location: ../index.php?login=error");
			exit();
		} else {
			if($row = mysqli_fetch_assoc($result)){//takes data from database and puts it in $row
				//echo $row['user_uid']; //prints out the uid from row variable
				//de-hashing pwd
				$hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
				if($hashedPwdCheck == false){
					header("Location: ../index.php?login=error");
					exit();
				} elseif($hashedPwdCheck == true){
					//log in user here!!
					$_SESSION['u_id'] = $row['user_id'];
					$_SESSION['u_first'] = $row['user_first'];
					$_SESSION['u_last'] = $row['user_last'];
					$_SESSION['u_email'] = $row['user_email'];
					$_SESSION['u_uid'] = $row['user_uid'];
					$_SESSION['u_account_balance'] = $row['account_balance'];
					header("Location: ../frontPage.php?login=success");
					exit();
				}
			}
		}
	}
}
	else{
		header("Location: ../index.php?login=error");
		exit();
}
