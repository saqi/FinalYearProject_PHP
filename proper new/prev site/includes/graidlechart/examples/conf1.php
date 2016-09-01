<?php
include("../graidle.php");
$y0=array(18,15,18,13,18,6,18,18,18,16,16,10,18,14,18,10,10,8);
$y1=array(3,6,10,8,5,8,6,6,6,4,5,9,7,0,11,11,11,3);
$y2=array(8,6,8,9,11,10,9,0,5,13,0,6,6,0,0,5,4,5);

$graidle = new graidle("Tutorial 9",25);
$graidle -> setValue($y0,'l');
$graidle -> setValue($y1,'b');
$graidle -> setValue($y2,'l');
$graidle -> setBgCl("#000000");
$graidle -> setFontCl("#FFFFFF");
$graidle -> setAxisCl("#FFFFFF");
$graidle -> create();
$graidle -> carry();