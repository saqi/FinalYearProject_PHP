<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");  

if (!loggedin()){
$rmessage = "You must be logged in to come to this page!";
$_SESSION['rmessage'] = $rmessage;
toindex();
}

//code for adding new products
$erors = array();// set an empty array that will contains the errors

$query = "SELECT  `ISBN` , `year`, SUM(`quantity_sold` ) AS  `Total Quantity` FROM  `product_sales` GROUP BY  `ISBN` 
ORDER BY  `Total Quantity` DESC LIMIT 3";
$queryh = $connection->query($query);

echo "<table border='1'>
<tr>
<th>ISBN</th>
<th>Total Quantity sold</th>
</tr>";

while ($p1 = $queryh->fetch_assoc()){
	echo "<tr>";
  echo "<td>" . $p1['ISBN'] . "</td>";
  echo "<td>" . $p1['Total Quantity'] . "</td>
  </tr>";
  } //while code
echo "</table>
<form id='toppform' action='filegraph2.php' method='post'>
  <input type='submit' class='submit-button1' name='viewtop' value='View units sold for 1st product in Graph form' />
</form>";

?>