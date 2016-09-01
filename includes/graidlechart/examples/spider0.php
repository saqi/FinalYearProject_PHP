<?php

include("../graidle.php");
$y1=array(100,100,100,100,100);
$y2=array(70,80,90,85,100);
$y3=array(50,55,60,65,70);
$vlx=array("A","B","C","D","E");

$graidle=new graidle("Spider",120);
$graidle -> setValue($y1,'s',"Target");
$graidle -> setValue($y2,'s',"Actual");
$graidle -> setValue($y3,'s',"Start");
$graidle -> setBgCl("EFEEFF");
$graidle -> setAA(4);
$graidle -> setXValue($vlx);
$graidle -> setDivision(20);
$graidle -> setWidth(400);
$graidle -> setHeight(350);
#$graidle -> setFilled(1);
$graidle -> setFontSmall(8);
#$graidle -> setFontBig(22);
$graidle -> create();
$graidle -> carry();

?>