<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");

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
	   <li><a href='products.php'><span>PRODUCT SALES <br />&amp; CHARTS</span></a></li>
	   <li class='active'><a href='dailys.php'><span>DAILY SALES<br /> &amp; CHARTS</span></a></li>
	   <li><a href='view.php'><span>VIEW, ADD &amp;<br /> EDIT PRODUCTS</span></a></li>
	   <li class='last'><a href='account.php'><span>ACCOUNT <br />SETTINGS</span></a></li>
	</ul>
	</div><!-- end of nav div -->
	
<?php
amessage();
rmessage();
?>

	<br /><br />
	<div id="logdiv"> 
<?php
if (loggedin()){
echo "<a href='logout.php'><button type='button'> Logout</button></a>";
}
?>	
	</div>
	
	
		<!-- Add daily sales figure -->
		<div class="form-container1" id="afdiv">
		<form id="asform" action='dailys.php' method='post'>
		<table><tbody>
		<tr><th colspan="2">Add sales figure for today</th></tr>
		<tr>
		<td>Sales value: £</td>
		<td><input type='text' name='wtf' class="form-field1" autofocus></td>
		</tr>
		<tr><td colspan="2"><input type='submit' name='submit' value='Submit' class="submit-button1" /></td></tr>
		</tbody></table>
		</form>
		</div> <!-- Add daily sales figure div ends here -->
		
<?php // code for adding daily sales figure for form above
$erors = array();// set an empty array that will contains the errors
if(isset($_POST['submit']) && loggedin()){
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$wtf = $connection->real_escape_string($_POST['wtf']);

$pregex = "/[0-9]{0,4}\.?([0-9]{1,2})?/";
if (!preg_match($pregex, $wtf)){
$erors [] = "The field can only contain numbers";}
if ( $wtf == 0 ) {
$erors[] = "Value cannot be 0";
$rmessage = implode('<br />', $erors);
$_SESSION['rmessage'] = $rmessage;
todailys();
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

$amessage = "Sales for today has been stored or updated!";
$_SESSION['amessage'] = $amessage;
todailys();
} // else new entry
} // only float entered
} // post is set	
?>	

		<br />
		<div class="vpdivs1">
		<h2>View Sales Figures </h2>
		<div id="totals" class="form-container1">
		<form action='dailys.php' method='post'>
		<table><tbody>
		<tr><th colspan="2">View Yearly or Monthly Sales Figure</th></tr>
		<tr>
		<td>View total sales in Year:</td>
		<td><select name="years">
<?php
$yearsh = $connection->query("SELECT DISTINCT `year` FROM `daily_sales`");
while ($year = $yearsh->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
		</select> </td>
		</tr>
		<tr>
		<td>View total sales by Month:</td>
		<td><select name="months">
		<option value="">All Months</option>
<?php
$monthsh = $connection->query("SELECT DISTINCT `month` FROM `daily_sales`");
while ($month = $monthsh->fetch_assoc()){
		echo '<option value="'.$month['month'].'">'.$month['month']."</option>";
	}
?>
		</select> </td>
		</tr>
		
		<tr><td colspan="2"><input type="submit" name="tsubmit" value="View" class="submit-button1" /></td></tr>
	</tbody></table>
		
		
		<div id="vsfigure" > <!-- div for storing sales figure from php cpde -->

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
echo "<h1>".$tview1['am']."</h1>"; 
}

} // post is set

// Array of Graph name and values
$graphs = array("Simple vertical column graph" => "parseVerticalSimpleColumnGraph", "Vertical line graph" => "parseVerticalLineGraph", "Vertical shadow column graph" => "parseVerticalColumnGraph", "Vertical polygon graph" => "parseVerticalPolygonGraph", "Simple horizontal column graph" => "parseHorizontalSimpleColumnGraph", "Horizontal line graph" => "parseHorizontalLineGraph", "Horizontal shadow column graph" => "parseHorizontalColumnGraph", "Horizontal polygon graph" => "parseHorizontalPolygonGraph");

?>
		</div>
		</form>
		</div>
		
		<div class="form-container1" id="affdiv">
		<form id="afform" action='filegraph.php' method='post'>
		<table><tbody>
		<tr><th colspan="2">View sales by months graph </th></tr>
		<tr>
		<td>Year:</td>
		<td><select name="years">
<?php
$yearsh = $connection->query("SELECT DISTINCT `year` FROM `daily_sales`");
while ($year = $yearsh->fetch_assoc()){
		echo '<option value="'.$year['year'].'">'.$year['year']."</option>";
	}
?>
		</select> </td>
		</tr>
		<tr>
		<td>Type of Graph:</td>
		<td><select name="graphs">
<?php
foreach($graphs as $key => $value){
	echo '<option value="'.$value.'">'.$key."</option>";
}
?>
		</select> </td>
		</tr>
		<tr><td colspan="2">
		<input type="submit" name="vsubmit" value="View" class="submit-button1"/></td></tr>
		</tbody></table>
		</form>
		</div>
		</div> <!-- div class="vpdivs"> -->
		
		
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