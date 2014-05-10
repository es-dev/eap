<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* ultima modfifica: aggiunta rotazione 18 marzo 2009 */

if (stristr($PHP_SELF,"header.php")) {
    Header("Location: index.php");
    die();
}

include("temi/$tema/index.php"); 
include("modules/Elezioni/language/lang-$lang.php");


function head() {
	global $csv,$tema,$tour;
	echo '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
	echo "<head>\n";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />";
	echo "<title>Eleonline - Elezioni on line</title>\n";
	echo "<link rel=\"stylesheet\" href=\"temi/$tema/style.css\" type=\"text/css\" />\n\n\n";
	include("inc/javascript.php"); # rotazione (18 marzo 2009) tema tour

	echo "\n\n\n</head>\n";
	# rotazione per tema tour
	if (isset($_SESSION['ruota'])){$csv=1; echo "<body onload=\"loadpage()\"";}
	else echo "<body";
	if (!$csv) echo " style=\"background-image: url(temi/$tema/images/sfondo.jpg); background-repeat:repeat-x;\"";
	echo " >\n";
	include("inc/authors.php");

	include_once("modules/Elezioni/funzioni.php");
	if (!$csv)testata();

  }

head();

?>
