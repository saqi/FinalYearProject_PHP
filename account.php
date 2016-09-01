<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");

// SESSION VARIABLES

 if (!loggedin()){
$rmessage = "You must be logged in to use this page!";
$_SESSION['rmessage'] = $rmessage;
toindex();
}
?>

<html>
	<head>
		<title>ACCOUNT SETTINGS</title>
		
		<!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster+Two" />
        <link rel="stylesheet" href="assets/jquery.pointpoint/jquery.pointpoint.css" /> 
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		
		<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type='text/javascript' src='menu_jquery.js'></script>
		<script>
  $(function() {
    $( "button" )
      .button()
      .click(function( event ) {
/*         event.preventDefault(); */
      });
	  
	$( ".message" ).click(function() {
  $( ".message" ).fadeOut( "slow" );
});
  });
  </script>
	</head>
	<body>
	
	<div id="body">
	<!-- top banner -->
	<div id="banner">
	<img id="banner1" src="Banner.png" alt="Retail Portal">
	</div>
	
	<div id='cssmenu'>
	<ul>
	   <li class='last'><a href='products.php'><span>PRODUCT SALES <br />&amp; CHARTS</span></a></li>
	   <li><a href='dailys.php'><span>DAILY SALES<br /> &amp; CHARTS</span></a></li>
	   <li><a href='view.php'><span>VIEW, ADD &amp;<br /> EDIT PRODUCTS</span></a></li>
	   <li class='active' ><a href='account.php'><span>ACCOUNT <br />SETTINGS</span></a></li>
	</ul>
	</div><!-- end of nav div -->
	
<?php
rmessage();
amessage();	
?>
	
	<br /><br />
	
	<div id="logdiv"> 
<?php
if (loggedin()){
echo " <a href='logout.php'><button type='button'>Logout</button></a>";
}
?>	
	</div>
	
	<div id='urid' class="form-container1"> 
	<h2>Your ID is 
<?php
echo " ".$_SESSION['userid'];
?>
	</h2>
	</div>

	
	<div id='upwrapper' class="vpdivs1">
	<h2>Update email address or password</h2>
	
	<div id='cemail' class="form-container1">
	<form id='cemailform' action="account.php" method='post'>
	<table><tbody>
	<tr><th colspan="2">Update your email address</th></tr>
	<tr>
	<td>Current email</td>
	<td><input type='text'  value="
<?php // get email from database
$equery = "SELECT * FROM `user` WHERE `User_ID` = ". $_SESSION['userid'];
$emailq = $connection->query($equery);
while ($email = $emailq->fetch_assoc()){
	echo $email['email'] . '"';
}
?>
	name="prevemail" class="form-field1" readonly /> </td>
	</tr>
	<tr>
	<td>New email</td>
	<td><input type="text" class="form-field1" name="newemail" autofocus> </td>
	</tr>
	<tr>
	<td>Password</td> 
	<td><input type="password" class="form-field1" name="password"> </td>
	</tr>
	<tr>
	<td>Confirm Password</td>
	<td><input type="password" class="form-field1" name="cpassword"> </td>
	</tr>
	<tr>
	<td colspan="2"><input type="submit" class="submit-button1" name="cesubmit" value="Update email" /></td>
	</tr>
	</tbody></table>
	</form>	
	</div> <!-- cemail div end -->
	
<?php // code for updating email
$erors = array();// set an empty array that will contains the errors
if(isset($_POST['cesubmit']) && isset($_POST['newemail']) && isset($_POST['password'])){ // form fields have values
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$newemail = $connection->real_escape_string($_POST['newemail']);
$password = $connection->real_escape_string($_POST['password']);
$cpassword = $connection->real_escape_string($_POST['cpassword']);

//check for email errors
$eregex = "/[a-zA-Z0-9_]+@[a-zA-Z]+.co(m|.uk)/";
if (!preg_match($eregex, $newemail)){
$erors [] = "Email can only contain letters, numbers, underscore and an '@' sign";
}

//check for password errors
$pregex = "/[a-zA-Z]+/";
if (!preg_match($pregex, $password)){
$erors [] = "Password can only contain letters and numbers";
}

if ($password != $cpassword){ // if password matches current password
$erors [] = "Password and Current password do not match";
}

// check for corect password
$pquery = "SELECT * 
FROM  `user` 
WHERE  `User_ID` =  '".$_SESSION['userid'];
if ($pqueryo = $connection->query($pquery)){
if ($pqueryo->num_rows < 1){ $erors[] = "No such user has been registered, pls register or try a different username";
}
while ($user = $pqueryo->fetch_assoc()){
$password = hash('sha1',$password);
if ($password != $user['hashed_password']){
$erors[] = "The password you typed wasn't correct";
} // if passwords don't match
} // end of while
} // if user(s) found

if (count($erors) <1 ){ // if no errors
$uequery = "UPDATE `user` SET `email`= '{$newemail}' WHERE `User_ID` = ".$_SESSION['userid'];
$uemail = $connection->query($uequery);
$amessage = "User email updated";
$_SESSION['amessage'] = $amessage;
toaccount();
}
else {// there are errors
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toaccount();
}

} // if post is set

?>	

	<div id='cpass' class="form-container1">
	<form id='cpassform' action="account.php" method='post'>
	<table><tbody>
	<tr><th colspan="2">Update your password</th></tr>
	<tr>
	<td>Current Password</td>
	<td><input type="password" class="form-field1" name="cpassword1"> </td>
	</tr>
	<tr>
	<td>New Password</td>
	<td><input type="password" class="form-field1" name="npassword"> </td>
	</tr>
	<tr>
	<td>Confirm new Password</td>
	<td><input type="password" class="form-field1" name="npassword1"> </td>
	</tr>
	<tr>
	<td colspan="2"><input type="submit" class="submit-button1" name="cpsubmit" value="Update password" /></td>
	</tr></tbody></table>
	</form>
	</div>
	
	</div>
	
<?php // code for updating password
$erors = array();// set an empty array that will contains the errors
if(isset($_POST['cpsubmit']) && isset($_POST['cpassword1']) && isset($_POST['npassword1'])){ // form fields have values
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$cpassword1 = $connection->real_escape_string($_POST['cpassword1']);
$npassword = $connection->real_escape_string($_POST['npassword']);
$npassword1 = $connection->real_escape_string($_POST['npassword1']);	
	
//check for password errors on all passwords
$pregex = "/[a-zA-Z]+/";
if (!preg_match($pregex, $cpassword1)){
$erors [] = "Current Password can only contain letters and numbers";
}
if (!preg_match($pregex, $npassword)){
$erors [] = "New Password can only contain letters and numbers";
}
if (!preg_match($pregex, $npassword1)){
$erors [] = "Confirm new Password can only contain letters and numbers";
}

$pregex1 = "/\w{6}/";	
if (!preg_match($pregex1, $npassword)){
$erors [] = "New Password should be at least 6 characters long";
}

if ($npassword != $npassword1){ // if password matches confirm password
$erors [] = "New Password and Confirm new Password do not match";
}

// check for corect password
$pquery1 = "SELECT * 
FROM  `user` 
WHERE  `User_ID` =  '".$_SESSION['userid'];
if ($pqueryo1 = $connection->query($pquery1)){
if ($pqueryo1->num_rows < 1){ $erors[] = "No such user has been registered, pls register or try a different username";
}
while ($user1 = $pqueryo1->fetch_assoc()){
$cpassword1 = hash('sha1',$cpassword1);
if ($cpassword1 != $user1['hashed_password']){
$erors[] = "The password you typed wasn't correct";
} // if passwords don't match
} // end of while
} // if user(s) found

if (count($erors) <1 ){ // if no errors
$npassword1 = hash('sha1',$npassword1);
$upquery = "UPDATE `user` SET `hashed_password` = '{$npassword1}' WHERE `User_ID` = ".$_SESSION['userid'];
$upass = $connection->query($upquery);
$amessage = "User Password updated!";
$_SESSION['amessage'] = $amessage;
toaccount();
}
else {// there are errors
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toaccount();
}

} //post is set
	
?>
	
	<div id="footer"><a href="about.php">
	<img id="footer1" src="footer11.png" alt="Retail Portal"></a>
	</div>
	</div> <!-- body container div -->
	
	<!-- Including the PointPoint() Plugin -->
		<script src="assets/jquery.pointpoint/transform.js"></script>
		<script src="assets/jquery.pointpoint/jquery.pointpoint.js"></script>
		
		<!-- The main script file -->
        <script src="assets/js/script.js"></script>
	
	</body>
</html>