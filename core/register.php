<?php
include ('../conn/connData.txt');

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

$mysqli = new mysqli($server, $user, $pass, $dbname, $port);

if(mysqli_connect_errno()) {
      echo "Connection Failed: " . mysqli_connect_errno();
      exit();
}

function checkExist(){
	global $mysqli;
	global $email;
	$stmt = $mysqli->prepare("SELECT Email FROM User WHERE Email = ?");
	$stmt->bind_param('s', $email);
    $stmt->execute();
	if($stmt->fetch()){
		$stmt->close();
		return true;
	}
	$stmt->close();
	return false;
}


if(!checkExist()){
	$stmt = $mysqli->prepare("INSERT INTO User(Email,Password,Name) VALUES (?,?,?)");
	if (!($stmt)) {
  	  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	$stmt->bind_param("sss", $email, $password, $username);
	// execute the statement
	$stmt->execute();
	$stmt->close();
	echo $username.', your registration is successful! <br>';
	echo 'Continue to the <a href="../login.html">LOGIN</a> page. ';
}else{
	echo 'Sorry, the email already exist!';
	echo '<a href="../login.html">Try Again</a> ';
}

$mysqli->close();

?>