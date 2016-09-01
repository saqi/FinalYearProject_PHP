<?php session_start();
require_once("includes/connection.php"); require_once("includes/functions.php");  
if (loggedin()){
$rusername = $_SESSION['username'];
} else {
$amessage = "Pls login before adding a user!";
$_SESSION['amessage'] = $amessage;
toindex();
}

// for adding new users
if(isset($_POST['submit']) && loggedin()){
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$username = $connection->real_escape_string($_POST['username']);
$subbedto = $connection->real_escape_string($_POST['user']);

if (isset($_POST['username']) && $username != ''){
//check if username already exists in table!!!
$query = "SELECT * 
FROM  `other_users` 
WHERE  `username` =  '".$username."' AND `subscribed_to` = '".$subbedto."';";
$numUsers = $connection->query($query);

$iequery = "SELECT * FROM `main` WHERE `id` = {$_POST['user']}";
$subbedto1 = $connection->query($iequery);
$subbedto2 = $subbedto1->fetch_assoc();
$subbedtoo = $subbedto2['username'];
$subbedto1->close();

$rquery = "SELECT * 
FROM `other_users` 
WHERE `added_by` = '".$rusername."';";
$abquery = $connection->query($rquery);

if ($numUsers->num_rows > 0 || $username == $subbedtoo){
	$amessage = "User already exists or can't subscribe to themselves!";
	$_SESSION['amessage'] = $amessage;
$numUsers->close();	
toindex();
} // if num rows > 0 statement

elseif ($abquery->num_rows > 0 && $rusername != 'saqalain'){
// registered user has already added be4
$amessage = "You have already added a user previously!";
	$_SESSION['amessage'] = $amessage;
$abquery->close();
	toindex();
} // elseif user has already added be4

else { // add user to database
echo "Username to add: {$username}"."<br />
Subscribed to: {$subbedto}<br /><br />";

$query = "INSERT INTO `other_users`(`username`, `subscribed_to`, `added_by`) VALUES ('" .$username."', '".$subbedto."', '".$rusername."');";

if ($connection->query($query) == true){ //success
$amessage = "User added!";
$_SESSION['amessage'] = $amessage;
toindex();
} else {
$amessage = $connection->error;
$_SESSION['amessage'] = $amessage;
toindex();
} // if insert query unsuccessful
}
} // for adding new users
}

if(isset($_POST['amsubmit']) && isset($_POST['amusername']) && $_POST['amusername'] != ''){ //adding new main users
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$amusername = htmlspecialchars($_POST['amusername']);
$amusername = $connection->real_escape_string($amusername);

$iequery = "SELECT * FROM `main` WHERE `username` = '".$amusername."';";
$usernameexists = $connection->query($iequery);
if ($usernameexists->num_rows > 0){ // user already exists
$amessage = "This youtube user is already listed, pls try a different one!";
$_SESSION['amessage'] = $amessage;
$usernameexists->close();
toindex();
} 
else { // add main user
$iquery = "INSERT INTO `main` (`username`, `added_by`) VALUES ('".$amusername."', '".$rusername."');";
if ($insertm = $connection->query($iquery)){
$amessage = "User is listed! Thank You :D";
$_SESSION['amessage'] = $amessage;
toindex();
}else {
$rmessage = "There were some errors!".$connection->errors;
$_SESSION['rmessage'] = $rmessage;
toindex();
}
}
} // for registering new users

header("Location: index.php");

// 5. Close connection
	$connection->close();
?>