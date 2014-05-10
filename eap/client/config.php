<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/


if (eregi("config.php",$_SERVER['PHP_SELF'])) {
        Header("Location: index.php");
	die();
}


/* Variabili di configurazione accesso db */
$dbhost = "127.0.0.1";
$dbuname = "root";
$dbpass = "vIard1na19";
$dbname = "eleonline";
$prefix = "soraldo";
$dbtype = "MySQL";

ini_set('display_errors',0);
?>
