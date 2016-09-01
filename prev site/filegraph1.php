<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");

header("Content-type: image/png");
header("Content-Disposition: attachment; filename=tast.png");

include("includes/graidlechart/graidle.php");
include_once("includes/phpMyGraph5.0.php");
//include("includes/pChart/class/pData.class.php");
//include("includes/pChart/class/pDraw.class.php");
//include("includes/pChart/class/pImage.class.php");

// SESSION VARIABLES


if (!loggedin() || $_SESSION['username'] != 'saqalain'){
$rmessage = "You must be logged in or be Saqalain to come to this page!";
$_SESSION['rmessage'] = $rmessage;
toindex();
}


if(isset($_POST['vsubmit1']) && loggedin()){
$_POST = array_map("strip_tags",$_POST);
$_POST = array_map("trim",$_POST);
$year = $_POST['years'];
$graphs = $_POST['graphs'];

$marray = array();
//$salesdata = array();
$msales = array();
$months = array('blank','Jan','Feb','Mar','Apr','May','June','July','Aug','Sept','Oct','Nov','Dec');
$msarray = array();

// Select all months for sales year & put in array
$monthsnh = $connection->query("SELECT DISTINCT `month` FROM `tsales` WHERE `year` = {$year}");
while ($month = $monthsnh->fetch_assoc()){
	 $marray[] = $month['month'];
}

foreach($marray as $number){
$msarray[] = $months[$number];
}

// start logic of gathering monthly sales
foreach($marray as $month){
$mshandle = $connection->query("SELECT SUM(`amount`) AS 'amount' FROM `tsales` WHERE `year` = '{$year}' AND `month` = '{$month}'");

while($ms = $mshandle->fetch_assoc()){

$msales[] = $ms['amount'];
}

} // foreach($marray as $month){

$salesdata = array_combine($msarray, $msales);

// Code for generating graph


//Set config directives
    $cfg['title'] = "Graph for year {$year}";
    $cfg['width'] = 800;
    $cfg['height'] = 600;
	
	$data = $salesdata;
	
	
$graph = new phpMyGraph();

    //Parse
   $graph->$graphs($data, $cfg);

} //post is set

?>
