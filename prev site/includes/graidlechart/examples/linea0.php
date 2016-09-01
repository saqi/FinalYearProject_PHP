<?php
include("../graidle.php");
$y0=array(1,-1,2,-2,3,-3,4,-4);

$graidle = new graidle("Tutorial 5",5,-5);
$graidle -> setValue($y0,'l',"Serie 1");
$graidle -> setXValue($y0);
$graidle -> setAxisCl("#CCCCCC");
$graidle -> setBgCl("#000000");
$graidle -> setFontCl("#FFFFFF");
$graidle -> create();
$graidle -> carry();