<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");  
include('includes/graidlechart/graidle.php');
include_once("includes/phpMyGraph5.0.php");

// SESSION VARIABLES

if (!loggedin() || $_SESSION['username'] != 'saqalain'){
$rmessage = "You must be logged in or be Saqalain to come to this page!";
$_SESSION['rmessage'] = $rmessage;
toindex();
}

$query = "Select * FROM `products`;";
$queryh = $connection->query($query);

echo "<table border='1'>
<tr>
<th>ISBN</th>
<th>Product Name</th>
<th>Dimensions</th>
<th>Selling Price</th>
<th>Weight</th>
<th>Code</th>
</tr>";

while ($p = $queryh->fetch_assoc()){
	echo "<tr>";
  echo "<td>" . $p['ISBN'] . "</td>";
  echo "<td>" . $p['product name'] . "</td>";
  echo "<td>" . $p['dimensions'] . "</td>";
  echo "<td>" . $p['selling price'] . "</td>";
  echo "<td>" . $p['weight'] . "</td>";
  echo "<td>" . $p['code'] . "</td>";
  echo "</tr>";
}

echo "</table>";
?>
