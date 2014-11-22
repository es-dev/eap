<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo visualizzazione immagini blob                                 */
/* Amministrazione                                                      */
/************************************************************************/

if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}
//session_start();
$aid=$_SESSION['aid'];
if (!$aid) return;

$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;

if (isset($param['id_lista'])) $id_lista=intval($param['id_lista']); else $id_lista='';
if (isset($param['id_gruppo'])) $id_gruppo=intval($param['id_gruppo']); else $id_gruppo='';
if (isset($param['id_sede'])) $id_sede=intval($param['id_sede']); else $id_sede='';
if (isset($param['id_comune'])) $id_comune2=intval($param['id_comune']); else $id_comune2='';
if (isset($param['prefix'])) $prefix=$param['prefix'];



if ($id_lista){
	$sql = "select stemma from ".$prefix."_ele_lista where id_lista=".$id_lista;
	$res = mysql_query($sql,$dbi);
	list($stemma) = mysql_fetch_row($res);
}elseif ($id_gruppo){
	$sql = "select stemma from ".$prefix."_ele_gruppo where id_gruppo=".$id_gruppo;
	$res = mysql_query($sql,$dbi);
	list($stemma) = mysql_fetch_row($res);
}elseif ($id_sede){
	$sql = "select mappa from ".$prefix."_ele_sede where id_sede=".$id_sede;
	$res = mysql_query($sql,$dbi);
	list($stemma) = mysql_fetch_row($res);
}elseif ($id_comune2){
	$sql = "select stemma from ".$prefix."_ele_comuni where id_comune=".$id_comune2;
	$res = mysql_query($sql,$dbi);
	list($stemma) = mysql_fetch_row($res);
}else{
return;
}


// nessuno stemma immagine vuota
if ($stemma==""){ 

$sql = "select stemma from ".$prefix."_ele_conf where id_com='0'";
$res = mysql_query($sql,$dbi);
$dati = mysql_fetch_array($res);
$stemma = $dati['stemma'];
}
echo $stemma;
?>
