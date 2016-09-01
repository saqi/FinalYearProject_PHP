<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");
include('includes/graidlechart/graidle.php');
include_once("includes/phpMyGraph5.0.php");

// SESSION VARIABLES

 if (!loggedin()){
$rmessage = "You must be logged in to use this page!";
$_SESSION['rmessage'] = $rmessage;
toindex();
}
$userid = $_SESSION['userid'];
?>

<html>
	<head>
		<title>DAILY SALES &amp; CHARTS</title>
		<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="dist/jquery.jqplot.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>

<script>
$(document).ready(function() {

// Bind click events on buttons to trigger specified functions

$('#button').bind('click',postToPage);

$('#vtpsubmit').bind('click',gettop);

function postToPage() {
$('#txtHint').load("getuser.php");
}

function gettop() {
$('#chart1').load("fileb.php");
}

});
</script>

<link rel="stylesheet" type="text/css" href="dist/jquery.jqplot.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
	
		<h1 id='fileh1'>Add sales figure for today</h1>
		
		<!-- Add daily sales figure -->
		<div id="afdiv">
		<form id="asform" action='dailys.php' method='post'>
		Sales for Today: £
		<input type='text' name='wtf'><br />
		<input type='submit' name='submit' value='Submit' />
		</form>
		</div> <!-- Add daily sales figure div ends here -->
		
<?php // code for adding daily sales figure for form above
rmessage();
$erors = array();// set an empty array that will contains the errors
// for adding new sales data
if(isset($_POST['submit']) && loggedin()){
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$wtf = $connection->real_escape_string($_POST['wtf']);
settype($wtf, "double");

if ( $wtf == 0 || gettype($wtf) != "double") {
$erors[] = "Enter Numbers only PLS!!";
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
toindex();
} else { // only float entered

$time = time();
$cyear = strftime("%Y",$time);
$cmonth = strftime("%m",$time);
$cday = strftime("%d",$time);
$date = settype($cday, 'string')."//".settype($cmonth, 'string')."//".settype($cyear, 'string');
$today = date("d/m/y");

// check if date already exists & update
$query = "Select * FROM `daily_sales` WHERE `day` = {$cday} AND `month` = {$cmonth} AND `year` = {$cyear};";
$rexists = $connection->query($query);
if ($rexists->num_rows > 0){
$update = $connection->query("UPDATE `daily_sales` SET `amount` = {$wtf} WHERE `day` = {$cday} AND `month` = {$cmonth} AND `year` = {$cyear};");
}
else { // new amount entry
$iquery = "INSERT INTO `daily_sales`(`amount`, `day`, `month`, `year`, `date`, `User_ID`) VALUES ({$wtf},  {$cday}, {$cmonth}, {$cyear}, concat(`day`, '/', `month`, '/', `year`), {$userid});";
$insert = $connection->query($iquery);

} // else new entry
} // only float entered
} // post is set
	
?>	

		<br /><br />
		<div id="totals">
		<h3>View Yearly or Monthly Sales Figure</h3>
		<form action='dailys.php' method='post'>
		View total sales in Year:
		<select name="years">
<?php
$yearsh = $connection->query("SELECT DISTINCT `year` FROM `daily_sales`");
while ($year = $yearsh->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
		</select> <br />
		View total sales by Month:
		<select name="months">
		<option value="">All Months</option>
<?php
$monthsh = $connection->query("SELECT DISTINCT `month` FROM `daily_sales`");
while ($month = $monthsh->fetch_assoc()){
		echo '<option value="'.$month['month'].'">'.$month['month']."</option>";
	}
?>
		</select> <br />
		<input type="submit" name="tsubmit" value="View" />
		</form>
		
		<div id="vsfigure"> <!-- div for storing sales figure from php cpde -->

<?php // code for viewing yearly or monthly sales
if(isset($_POST['tsubmit']) && loggedin()){
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$years = $connection->real_escape_string($_POST['years']);
$months= '';
// if month is set
if ($_POST['months'] != ''){
$months = "AND `month` = '".$_POST['months']."';";
}

$tquery = "SELECT SUM(`amount`) AS am FROM `daily_sales` WHERE `year` = '". $_POST['years']."' ".$months;

$tview = $connection->query($tquery);

while ($tview1 = $tview->fetch_assoc()){
echo "<h1>".$tview1['am']."</h1></div>"; // end of div is in php code
}

} // post is set

// Array of Graph name and values
$graphs = array("Simple vertical column graph" => "parseVerticalSimpleColumnGraph", "Vertical line graph" => "parseVerticalLineGraph", "Vertical shadow column graph" => "parseVerticalColumnGraph", "Vertical polygon graph" => "parseVerticalPolygonGraph", "Simple horizontal column graph" => "parseHorizontalSimpleColumnGraph", "Horizontal line graph" => "parseHorizontalLineGraph", "Horizontal shadow column graph" => "parseHorizontalColumnGraph", "Horizontal polygon graph" => "parseHorizontalPolygonGraph");

?>
		
		<form id="afform" action='filegraph.php' method='post'>
		View sales by months graph <br />
		Year: <select name="years">
<?php
$yearsh = $connection->query("SELECT DISTINCT `year` FROM `daily_sales`");
while ($year = $yearsh->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
		</select> <br />
		Type of Graph: <select name="graphs">
<?php
foreach($graphs as $key => $value){
	echo '<option value="'.$value.'">'.$key."</option>";
}
?>
		</select> <br />
		<input type="submit" name="vsubmit" value="View" />
		</form>
		<br />
		