<?php
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
if (isset($param['id_cons_gen']))
	 $id_cons_gen2=intval($param['id_cons_gen']);
if (isset($param['id_comune']))
	 $id_comune2=intval($param['id_comune']);
$result = mysql_query("select descrizione from ".$prefix."_ele_consultazione  where id_cons_gen='$id_cons_gen2'", $dbi);
list($nomeFile) = mysql_fetch_row($result);
#$nomeFile="backup";
header( 'Content-Type: application/octet-stream' );
header( 'Content-Disposition: attachment; filename="'.$nomeFile.'"' );
#header( 'Content-Length:'.strlen( $content ) );
header( 'Content-Transfer-Encoding: binary' );
include("backup2.php");
exit(0);

?>
