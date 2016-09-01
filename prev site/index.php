<?php  session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");  
// SESSION VARIABLES

?>

<html>
	<head>
		<title>Youtube</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<br />
		<?php 
			// single-line comments can be like this
			# or even like this
			/* multi-line comments can 
				be like this */ ?>
		<h1 id="mtitle">Main Youtube Users</h1>
		<?php 
		// 3. Performing database query
		$MainUsers = $connection->query('SELECT * FROM main;');
		if (!$MainUsers){
		exit("Database query failed:".$connection->error());}
		?>
		<div id="ytusers">
		<ol>	
		<?php
		
		// 4. Use returned data
		while($MainUser = $MainUsers->fetch_assoc()){
		echo "<li>{$MainUser['username']}</li>";
		
		// 3. Again
		$OtherUsers = $connection->query("SELECT * FROM other_users WHERE subscribed_to = {$MainUser['id']};");
		if (!$OtherUsers){
		exit("Database query failed:".$connection->error());
		}		
		 echo "<ul>";
		 
	while($OtherUser = $OtherUsers->fetch_assoc()){
		echo "<li>{$OtherUser["username"]}</li>";
		
		}echo "</ul>";
		
		}echo "</ol></div>";
$MainUsers->close(); 
$OtherUsers->close();
		?>
		<br />
		<?php
		if (loggedin()){echo "<div id='links'>";
		echo "<button><a href='logout.php' id='logout'> Logout</a></button></div>"; 
		} else {echo "<div id='links'>		
		<button id='register'><a href='register.php'>Register</a></button>
		&nbsp;
		<button id='login'><a href='login.php'>Login</a></button>
		</div>"; }
		
		rmessage();
		
		if (!loggedin()){echo "<div id='addouser' class='hidden'>";
		} else { echo "<div id='addouser'>";}
		?>
		<h1 id="addouserh1">Add other users</h1>
		<form action="process.php" method="post">
		Username: &nbsp;&nbsp;&nbsp;<input type="text" name="username"><br />
		Subscribed to? 
		<select name="user">
		<?php
		$MainUsers = $connection->query('SELECT * FROM main;');
		if (!$MainUsers){
		exit("Database query failed:".$database->connection->error());}
		
		while($MainUser = $MainUsers->fetch_assoc()){
		echo '<option value="' . $MainUser['id'] .'">' . $MainUser['username'] . "</option>";
		}
		?>
		</select> <br />
		<input type="submit" name="submit" value="Submit" />
		</form>
		</div>
		
		<?php
		
		if (loggedin() && $_SESSION['username'] == 'saqalain'){
		echo "<div id='addmuser'>
		<h1>Add main user</h1>
		<form action='process.php' method='post'>
		Username: &nbsp;&nbsp;&nbsp;<input type='text' name='amusername'><br />
		<input type='submit' name='amsubmit' value='Submit' />
		</form><br />
		<a href='file.php'>File Website</a>
		</div>";
		}

		amessage(); ?>
		
	</body>
</html>
<?php
	// 5. Close connection
	$connection->close();
?>	