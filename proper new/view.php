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
?>

<html>
	<head>
		<title>VIEW &amp; EDIT PRODUCTS</title>
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
	
				<div id="products">
		<h3>Products</h3>

		<form id="pform" method='post'>
		Show all Products
		<button type="button" id="button">Get Products</button>
		</form>
		<div id="txtHint"></div>
		</div>

		<br />
		
		<div id="vtproducts">
		<form id="vtpform" method='post'>
		View top 3 Products <br />
		Year: 
		<select name="years1">
<?php
$yearsh1 = $connection->query("SELECT DISTINCT `year` FROM `product_sales`");
while ($year = $yearsh1->fetch_assoc()){
	echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
		</select> <br />
		<button type="button" id="vtpsubmit">View top Products</button>
		</form>
		<div id="chart1"> </div>
		</div> <!-- view top products div -->
		