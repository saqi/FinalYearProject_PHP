<?php
include("../graidle.php");
$y1=array(1,1,2,3,5,8,13,21,34);
$y2=array(1,2,3,4,5,6,7,8,9);

$graidle = new graidle("Tutorial 14");
$graidle -> setValue($y2,'l');
$graidle -> setValue($y1,'l');
$graidle -> setSecondaryAxis(1,0);
$graidle -> setFilled();
$graidle -> create();
$graidle -> carry();