<?php
$version="";
$server_name="";
$server_port="";

$root= substr($_SERVER["DOCUMENT_ROOT"],0,-4);   // Get path
$file="$root\home\us_config\us_config.ini" ;     // Name and path of configuration file

if (file_exists($file) && is_readable($file)){   // Check file
  $settings=parse_ini_file($file,true);          // parse file into an array
  $version=$settings["APP"]["AppVersion"];       // get parameter
}


$file="$root\home\us_config\us_user.ini" ;       // Name and path of user configuration file

if (file_exists($file) && is_readable($file)){     // Check file
  $settings=parse_ini_file($file,true);            // parse file into an array
  $server_name=$settings["USER"]["US_SERVERNAME"]; // get parameter
  $server_port=$settings["USER"]["AP_PORT"];       // get parameter
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>The Uniform Server </title>
<meta name="Description" content="The Uniform Server Zero 10.0.0." />
<meta name="Keywords" content="The Uniform Server, MPG, Mike Gleaves, Ric, UniServer, Olajide, BobS " />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
</head>

<style type="text/css">
/*****************************************/
.intro{
  margin-top:30px;
  padding:10px;
  font-size:12px;
  font-family:Verdana;
  background-color: #E7E7FD;
}
/*****************************************/
</style>

<body>

<div id="wrap">
  <div id="header">
     <a href="http://www.uniformserver.com"><img src="images/logo.png" align="left" alt="The Uniform Server" /></a>
       <div id="header_txt" >
         <div style="position:absolute;">
             Zero <?php print "- ".$version; ?> </p>
         </div>
       </div>
  </div>


  <div id="content">
    <h1>Welcome to The Uniform Server Zero</h1>
    <p class="intro">This test page is named <b>index.php</b><br />It was served from root folder UniServerZ\<b>www</b>
    <span  style='display:<?php print("none")?>'><br /> No PHP module installed Apache returns php directives un-processed.</span>
    </p>

  <div align="center" style="height:120px; padding-top:20px;">
     <img src="images/padlock2.gif"  alt="Padlock" />
  </div>




<!-- splash page link -->
<!-- <?php print("--" . ">");?>

  <table>
  <tr>
   <td>
     <h2>Server links</h2>
      <p> <a href="http://<?php echo($server_name.':'.$server_port) ?>/us_splash/index.php" target="_blank" >Splash page</a> - Displays server specification and useful links.</p>
      <p> <a href="http://<?php echo($server_name.':'.$server_port) ?>/us_opt1/index.php" target="_blank" >PhpMyAdmin</a>.</p>
      <p> <a href="http://<?php echo($server_name.':'.$server_port) ?>/us_opt2/?username=" target="_blank" >Adminer</a>.</p>
      <p> <a href="http://<?php echo($server_name.':'.$server_port) ?>/us_extra/phpinfo.php" target="_blank" >PHP Info</a>.</p>
   </td>
  </tr>
  </table>
<?php print("<"."!"."--")?> -->

<!-- subdirs  -->
<!-- <?php print("--" . ">");?>

  <table>
  <tr><td><h2>Served Subdirectories</h2></td></tr>
  </table>
  <table width=100%>
  <?php $n = 0; foreach (scandir("./") as $file){
    if (is_dir($file) && !in_array($file, array(".", "..", "css", "images"))){
        $n++;
        echo ($n % 3 ? (($n+1) % 3 ? "<tr><td width=33%>$n - <a href='" . $file . "' target='_blank'>" . $file . "</a></td>" : "<td width=33%>$n - <a href='" . $file . "' target='_blank'>" . $file . "</a></td>") : "<td>$n - <a href='" . $file . "' target='_blank'>" . $file . "</a></td></tr>");
    }
  }
  echo ($n == 0 ? "<tr><td style='color: red;' colspan='3'>None</td></tr>" : ($n % 2 == 0 ? "" : "<td></td></tr>"));?>
  </table>
<?php print("<"."!"."--")?> -->


<!-- php files  -->
<!-- <?php print("--" . ">");?>

  <table>
  <tr><td><h2>Served PHP Files</h2></td></tr>
  </table>
  <table width=100%>

  <?php $n = 0; foreach (scandir("./") as $file){
    if (strtolower(strrchr($file, '.'))==".php" && $file!="index.php"){
        $n++;
        echo ($n % 3 ? (($n+1) % 3 ? "<tr><td width=33%>$n - <a href='" . $file . "' target='_blank'>" . $file . "</a></td>" : "<td width=33%>$n - <a href='" . $file . "' target='_blank'>" . $file . "</a></td>") : "<td>$n - <a href='" . $file . "' target='_blank'>" . $file . "</a></td></tr>");
    }
  }
  echo ($n == 0 ? "<tr><td style='color: red;' colspan='3'>None</td></tr>" : ($n % 2 == 0 ? "" : "<td></td></tr>"));?>
  </table>
 
<?php print("<"."!"."--")?> -->


  <div id="divider">Developed By <a href="http://www.uniformserver.com/">The Uniform Server Development Team</a></div>
</div>
</div>
</body>
</html>
