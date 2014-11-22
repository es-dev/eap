<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
include("config.php");
		$dbi=mysql_connect($dbhost, $dbuname, $dbpass) or die("Connessione non riuscita: " . mysql_error());
		mysql_select_db($dbname)or die("Connessione non riuscita:" . mysql_error());
	mysql_query("SET NAMES 'utf8'", $dbi);
//---10/05/2009  gestione consultazione predefinita
//if (!isset($_SESSION['id_comune'])){
		$res_config = mysql_query("select * from ".$prefix."_config ",$dbi);
		list ($sitename,$siteurl,$site_logo,$slogan,$startdate,$adminmail,$tema,$foot,$language,$blocco,$testata,$logo,$fileout,$copyright,$versione,$patch,$id_comune) = mysql_fetch_row($res_config);
		$siteistat=$id_comune;
//}
    Header("Location: admin.php?id_comune=$siteistat");
die();
?>
