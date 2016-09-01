<?php
include("../graidle.php");
$y0=array(25,16,25,25,25,25,25,16);
$y1=array(20,25,20,20,16,9,20,0);
$y2=array(8,13,16,13,20,20,0,25);

$graidle = new graidle("Tutorial 2");
$graidle -> setValue($y0,'b',"Bar1");
$graidle -> setValue($y1,'b',"Bar2");
$graidle -> setValue($y2,'b',"Bar3");
$graidle -> setSecondaryAxis(1,0);
$graidle -> setBgCl("#FFFFDD");
$graidle -> setAxisCl("#000000");
$graidle -> setFontCl("#000000");
$graidle -> create();
$graidle -> carry();