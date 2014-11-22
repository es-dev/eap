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

$dbhost = "217.59.179.73";
$dbuname = "Sql755035";
$dbpass = "4f8xakg38w";
$dbname = "Sql755035_3";
$prefix = "soraldo";
$dbtype = "MySQL";

ini_set('display_errors',0);
?>
