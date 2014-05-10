<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

if (!defined('MODULE_FILE')) {
    die ("You can't access this file dirrectly...");
}


$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;

if (isset($param['id_lista'])) $id_lista=intval($param['id_lista']); else $id_lista='';
if (isset($param['id_gruppo'])) $id_gruppo=intval($param['id_gruppo']); else $id_gruppo='';
if (isset($param['id_sede'])) $id_sede=intval($param['id_sede']); else $id_sede='';
if (isset($param['id_comune'])) $id_comune=intval($param['id_comune']); else $id_comune='';
if (isset($param['prefix'])) $prefix=$param['prefix'];


if ($id_lista){
	$sql = "select * from ".$prefix."_ele_lista where id_lista=".$id_lista;
	$res = mysql_query($sql,$dbi);
	$dati = mysql_fetch_array($res);
	$stemma = $dati['stemma'];
}elseif ($id_gruppo){
	$sql = "select * from ".$prefix."_ele_gruppo where id_gruppo=".$id_gruppo;
	$res = mysql_query($sql,$dbi);
	$dati = mysql_fetch_array($res);
	$stemma = $dati['stemma'];
}elseif ($id_sede){
	$sql = "select * from ".$prefix."_ele_sede where id_sede=".$id_sede;
	$res = mysql_query($sql,$dbi);
	$dati = mysql_fetch_array($res);
	$stemma = $dati['mappa'];
}elseif ($id_comune){
	$sql = "select * from ".$prefix."_ele_comuni where id_comune=".$id_comune;
	$res = mysql_query($sql,$dbi);
	$dati = mysql_fetch_array($res);
	$stemma = $dati['stemma']; #die("qui:  $sql  $stemma");
}else{
die();
}


// nessuno stemma immagine vuota
if ($stemma=="" && is_readable('modules/Elezioni/images/vuoto.jpg')){
	$stemma =  fread( fopen( 'modules/Elezioni/images/vuoto.jpg', 'r' ), filesize( 'modules/Elezioni/images/vuoto.jpg' ) );}
echo $stemma;
?>
