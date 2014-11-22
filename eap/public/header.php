<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/


if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

#include("config.php");
#$dbi = mysql_connect($dbhost, $dbuname, $dbpass);
#mysql_select_db($dbname);
	if (isset($param['language'])) {
		$_SESSION['lang']=substr($param['language'],0,2);
		$lang=$_SESSION['lang'];
	}
	elseif (strlen($_SESSION['lang'])==2) $lang=$_SESSION['lang'];
	else $lang=$language;
if ($_SESSION['tema']=='facebook')
	$tema=$_SESSION['tema'];
else $tema='default';
include("temi/$tema/index.php"); 
include("modules/Elezioni/language/lang-$lang.php");

$bgcolor1="#b0b0b0";
function head() {
	global $csv,$tema;
    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
    echo "<html>\n";
    echo "<head>\n";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
	echo "<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
    echo "<title>Eleonline - Elezioni on line</title>\n";
    echo "<LINK REL=\"StyleSheet\" HREF=\"temi/$tema/style.css\" TYPE=\"text/css\">\n\n\n";
    echo "\n\n\n</head>\n<body style=\"background-image: url(temi/$tema/images/sfondo.jpg);\">";
    if (!$csv)testata($tema);
    

}


head();


?>
