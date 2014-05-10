<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

if (!defined('MODULE_FILE')) {
    die ("You can't access this file directly...");
}
if (!isset($filename)) {  Header("Location: index.php"); }
$blocco=0;
include("header.php");
$filename="$filename.html";

// verifica se la pagina e' un html
	if(substr($filename,-4)!=".htm" && substr($filename,-5)!=".html"){
		echo "Autorizzazione negata...";
		echo "<hr>"._GOBACK."";
	
	}else {
		// verifica link pagine esterne e risalita path
	
	if( substr($filename,0,1)!="." && substr($filename,0,4)!="http" ){
  		//echo substr($file,-4);
		include ("pagine/$filename");
		echo "<hr>"._GOBACK."";
  		
	}
	else {
		echo "Autorizzazione negata...";
		echo "<hr>"._GOBACK."";
		
	}
}

CloseTable();
include("footer.php");
?>
