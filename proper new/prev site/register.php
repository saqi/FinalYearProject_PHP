<?php
session_start();
require_once("includes/connection.php"); 
require_once("includes/functions.php");
// Session variables


if(loggedin()) {
$amessage = "You are already logged in!";
$_SESSION['amessage'] = $amessage;
toindex();
}
?>
<html>
	<head>
		<title>Register</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
	<h1>Register an account</h1>

	<form action="register.php" method="post">
	
	Username:   <input type="text" name="rusername" placeholder="at least 4 letters"> <br />
	Password:   <input type="password" name="password" placeholder="at least 6 letters"> <br />
	Passcode:   <input type="text" name="passcode" placeholder="Any word you want"> <br />
<input type="submit" name="rsubmit" value="Submit" />
	</form>
	
	<div id='links'>		
		<button id='register'><a href='index.php'>Homepage</a></button>
		</div>
	
	</body>
</html>
<?php
$erors = array();// set an empty array that will contains the errors
if(isset($_POST['rsubmit'])){ //registering new users
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$rusername = $connection->real_escape_string($_POST['rusername']);
$password = $connection->real_escape_string($_POST['password']);
$ipaddress = $_SERVER['REMOTE_ADDR'];

if (isset($_POST['rusername']) && isset($_POST['password'])){
if (strlen($_POST['rusername'])<4) $erors[] = 'Name must contain minimum 4 characters';
if (strlen($_POST['password'])<6) $erors[] = 'Password must contain minimum 6 characters';

$query = "SELECT * 
FROM  `rusers` 
WHERE  `ipaddress` =  '".$ipaddress."';";
if ($numUsers = $connection->query($query)){
if ($numUsers->num_rows > 0) {
$erors[] = "User from this household has already registered, pls Login!!";
}}

$aquery = "SELECT * FROM `rusers` WHERE `username` = '".$rusername."'";
if ($alquery = $connection->query($aquery)){
if($alquery->num_rows > 0) {
$erors[] = "The username already exists, pls choose a different username!"; 
}}

if (count($erors) <1){
$password = hash('sha1', $password);
$passcode = hash('sha1',($_POST['passcode']));
$iquery = "INSERT INTO `rusers`(`username`, `hashed_password`, `hashed_passcode`, `ipaddress`) VALUES ('".$rusername."', '".$password."', '".$passcode."', '".$ipaddress."');";
if ($connection->query($iquery) == true){ //success
$rmessage = "User Registered, Pls Login!";
$_SESSION['rmessage'] = $rmessage;
toindex();
} else {
$rmessage = $connection->error;
$_SESSION['rmessage'] = $rmessage;
toindex();
} // if insert unsuccessful
} // If there r 0 errors
else { // there r errors
#code for if there r errors
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toindex();
}
} // if username & pass are set
} // for registering new users

	// 5. Close connection
	$connection->close();
?>