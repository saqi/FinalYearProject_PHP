<?php  session_start();
require_once("includes/connection.php"); 
require_once("includes/functions.php");  
if (loggedin()){
$rmessage = "You have already logged in, no need to try to login again ;-D";
$_SESSION['rmessage'] = $rmessage;
toindex();
} else {
$_SESSION['loggedin'] = '';
$_SESSION['username'] = '';
}
?>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
	<div id="login">
	<h1>Login to your account</h1>

	<form action="login.php" method="post">
	
	Username:   <input type="text" name="lusername"> <br />
	Password:   <input type="password" name="password"> <br />
<input type="submit" name="lsubmit" value="Submit" />
	</form>
	
	<div id='links'>		
		<button id='register'><a href='index.php'>Homepage</a></button>
		</div>
	</body>
</html>
<?php
$erors = array();// set an empty array that will contains the errors
if(isset($_POST['lsubmit']) && isset($_POST['lusername']) && isset($_POST['password'])){ //logging in users
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$lusername = $connection->real_escape_string($_POST['lusername']);
$password = $connection->real_escape_string($_POST['password']);
if (strlen($_POST['lusername'])<3) {$erors[] = 'Name must contain minimum 3 characters';}
if (strlen($_POST['password'])<6) {$erors[] = 'Password must contain minimum 6 characters';}

$query = "SELECT * 
FROM  `rusers` 
WHERE  `username` =  '".$lusername."'";
if ($numUsers = $connection->query($query)){
if ($numUsers->num_rows < 1){ $erors[] = "No such user has been registered, pls register or try a different username";
}
while ($user = $numUsers->fetch_assoc()){
$password = hash('sha1',$password);
if ($password != $user['hashed_password']){
$erors[] = "The password you typed wasn't correct";
} // if passwords don't match
} // end of while
} // if user(s) found
if (count($erors)<1){ // if no errors
$_SESSION['loggedin'] = true;
$_SESSION['username'] = $lusername;
$rmessage = "User Logged in!";
$_SESSION['rmessage'] = $rmessage;
toindex();
} // if no errors
else { // there r errors
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toindex();
}
} // loggin in users end if form is submitted
?>