<?php

include("../graidle.php");

$y2=array(90,60,30,15);
$y1=array(88,54,25,8);
$vlx=array("595/1580 MHz","600/1600 MHz","595/1580 MHz","5600/1600 MHz");

$graph = new Graidle("Tutorial 17 - Horizontal Bar",100);
$graph -> setValue($y2,'hb',"1024x768","red");
$graph -> setValue($y1,'hb',"1280x1024","orange");
$graph -> setSecondaryAxis(1,1);
$graph -> setHeight(250);
$graph -> setWidth(500);
$graph -> setFontSmall(7);
$graph -> setExtLegend(1);
$graph -> setXtitle("POINTS");
$graph -> setXvalue($vlx);
$graph -> create();
$graph -> carry();
?>