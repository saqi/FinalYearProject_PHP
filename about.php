<?php	session_start();
require_once("includes/connection.php");
require_once("includes/functions.php");

?>

<html>
	<head>
		<title>About Retail Portal</title>
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
	   <li><a href='dailys.php'><span>DAILY SALES<br /> &amp; CHARTS</span></a></li>
	   <li><a href='view.php'><span>VIEW, ADD &amp;<br /> EDIT PRODUCTS</span></a></li>
	   <li class='last'><a href='account.php'><span>ACCOUNT <br />SETTINGS</span></a></li>
	</ul>
	</div><!-- end of nav div -->
	
	<div id="about">
	<h3>Retail Portal is made for small to medium enterprises who operate using traditional gear and don't want to spend huge amounts on new equipment.</h3>
	<h4>The web application allows adding and editting products on a database, recording transactional sales of those products and viewing these sales in chart form over the years.</h4>
	<h4>As well as recording transactional sales, the web application also allows the same for daily sales values which makes calculating monthly and yearly income as easy as it can get.</h4>
	</div>
	
	<div id="footer">
	<img id="footer1" src="footer11.png" alt="Retail Portal"></a>
	</div>
	</div> <!-- body container div -->

	</body>
	</html>
	