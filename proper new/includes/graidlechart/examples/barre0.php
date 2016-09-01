<?php
include("../graidle.php");
$y0=array(14,8,-4,3,2,1,0.5,-2);

$graidle=new graidle("Tutorial 1",20,-10);
$graidle -> setValue($y0,'b',"Serie Uno");
$graidle -> setSecondaryAxis(1,0);
$graidle -> setWidth(640);
$graidle -> create();
$graidle -> carry();

?>