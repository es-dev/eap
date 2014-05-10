<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo gruppo                                                        */
/* Amministrazione                                                      */
/************************************************************************/
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}


$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$currentlang=$_SESSION['lang'];
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=intval($param['id_cons_gen']);	
$perms=ChiSei($id_cons_gen);
if ($perms<32 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$id_comune=$_SESSION['id_comune'];
//$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune' " , $dbi);
//list($tipo_cons,$id_cons) = mysql_fetch_row($res);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");

if (isset($param['fase'])) $fase=intval($param['fase']); else $fase=0;
if (isset($param['id_cons_gen2'])) $id_cons_gen2=intval($param['id_cons_gen2']); else $id_cons_gen2='';
if (isset($param['indirizzoweb'])) get_magic_quotes_gpc() ? $indirizzoweb=$param['indirizzoweb']:$indirizzoweb=addslashes($param['indirizzoweb']); else $indirizzoweb='http://www.eleonline.it/moduli/eleonline2/client/';
if (isset($param['id_comune2'])) $id_comune2=intval($param['id_comune2']); else $id_comune2='';

/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/
function all() {
   	global $prefix, $dbi,$id_cons_gen,$id_comune,$indirizzoweb,$id_cons_gen2,$id_comune2,$fase;

$bgcolor1=$_SESSION['bgcolor1'];
$bgcolor2=$_SESSION['bgcolor2'];

if ($fase=='0'){

	echo "<form name=\"import\" action=\"admin.php\">";
	echo "<table border=\"0\" width=\"100%\"><tr bgcolor=\"$bgcolor2\">";
	echo "<td><b>"._INDIRIZZOWEB1."</b></td>";
	echo "<td><input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\"><input type=\"hidden\" name=\"op\" value=\"scarica\"><input type=\"hidden\" name=\"fase\" value=\"1\"><input type=\"text\" name=\"indirizzoweb\" size=\"50\" value=\"".$indirizzoweb."\"></td></tr>";
	echo "<td><input type=\"submit\" name=\"add\" value=\""._OK."\"></td>";
echo "</tr></table><br>";
	echo "</form>";
}elseif ($fase=='1'){
$rem_cons="<script type=\"text/javascript\" src=\"$indirizzoweb/file.php?fase=1\"></script>";

	echo "<form name=\"import\" action=\"admin.php\">";
	echo "<table border=\"0\" width=\"100%\"><tr bgcolor=\"$bgcolor2\">";
	echo "<td><b>"._INDIRIZZOWEB1."</b></td>";
	echo "<td><input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\"><input type=\"hidden\" name=\"op\" value=\"scarica\"><input type=\"hidden\" name=\"fase\" value=\"2\"><input type=\"hidden\" name=\"indirizzoweb\" value=\"$indirizzoweb\">$indirizzoweb</td></tr>";
	echo "<tr><td><b>"._SCARICACONS."</b></td>";

	echo "<td>$rem_cons</td></tr>";

		echo "<tr><td><input type=\"submit\" name=\"add\" value=\""._OK."\"></td>";

echo "</tr></table><br>";
	echo "</form>";
	}elseif($fase=='2'){

$res = mysql_query("SELECT descrizione from ".$prefix."_ele_consultazione WHERE id_cons_gen=$id_cons_gen2",$dbi);
list($descrcons) = mysql_fetch_row($res);
$rem_cons="<script type=\"text/javascript\" src=\"$indirizzoweb/file.php?fase=2&id_cons_gen2=$id_cons_gen2\"></script>";

	echo "<form name=\"import\" action=\"admin.php\">";
	echo "<table border=\"0\" width=\"100%\"><tr bgcolor=\"$bgcolor2\">";
	echo "<td><b>"._INDIRIZZOWEB1."</b></td>";
	echo "<td><input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\"><input type=\"hidden\" name=\"op\" value=\"scarica\"><input type=\"hidden\" name=\"fase\" value=\"3\"><input type=\"hidden\" name=\"indirizzoweb\" value=\"$indirizzoweb\">$indirizzoweb</td></td></tr>";
$cons_rem=$_GET[($id_cons_gen2)];
echo "<tr><td><b>"._CONSULTA.":</b></td><td>$cons_rem</td></tr>";
	echo "<tr><td><b>"._SCELTACOMUNE."</b></td><td>$rem_cons</td></tr>";

		echo "<tr><td><input type=\"submit\" name=\"add\" value=\""._OK."\"></td>";

echo "</tr></table><br>";
	echo "</form>";

	}elseif ($fase=='3'){

$id_cons_gen2=$_GET['id_cons_gen2'];
$id_comune2=$_GET['id_comune2'];
Header("Location: $indirizzoweb/modules.php?op=backup&id_cons_gen=$id_cons_gen2&id_comune=$id_comune2");

	} 
}

if ($fase!='3') ele();
all();
echo"</td></tr></table>";
include("footer.php");




?>
