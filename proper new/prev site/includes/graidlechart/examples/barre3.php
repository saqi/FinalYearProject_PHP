<?php

include("../graidle.php");

$y1=array(20,25,20,20,16);
$y2=array(-8,-13,16,13,20);
$vlx=array(2000,2001,2002,2003,2004);
$lg=array("A","B","C","D");

$graph = new Graidle("Tutorial 4");
$graph -> setValue($y2,'b');
$graph -> setValue($y1,'b');
$graph -> setValue($y2,'b');
$graph -> setValue($y1,'b');
$graph -> setBgCl("#000000");
$graph -> setFontCl("#FFFFFF");
$graph -> setAxisCl("#FFFFFF");
$graph -> setXtitle("YEARS");
$graph -> setYtitle("PROFIT");
$graph -> setXValue($vlx);
$graph -> setLegend($lg,"left");
$graph -> setSecondaryAxis(1,0);
$graph -> create();
$graph -> carry();
?>