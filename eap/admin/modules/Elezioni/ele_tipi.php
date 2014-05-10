<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo cambio password amministrazione                               */
/* Amministrazione                                                      */
/************************************************************************/


if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}
$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$currentlang=$_SESSION['lang'];
$id_comune=$_SESSION['id_comune'];
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=intval($param['id_cons_gen']);
$perms=ChiSei(0);

if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['descr_tipo'])) get_magic_quotes_gpc() ? $descr_tipo=$param['descr_tipo']:$descr_tipo=addslashes($param['descr_tipo']); else $descr_tipo='';
if (isset($param['lang_tipo'])) get_magic_quotes_gpc() ? $lang_tipo=$param['lang_tipo']:$lang_tipo=addslashes($param['lang_tipo']); else $lang_tipo='';
if (isset($param['op'])) get_magic_quotes_gpc() ? $op=$param['op']:$op=addslashes($param['op']); else $op='cambiopwd';
if (isset($param['tipocons'])) $tipocons=intval($param['tipocons']); else $tipocons='';
$lang_tipo=strtolower($lang_tipo);

/*********************************************************/
/* gestione tipologie Functions                                    */
/*********************************************************/

include("modules/Elezioni/ele.php");


function tipi() {
    global $admin, $bgcolor1, $bgcolor2, $prefix, $dbi, $id_cons_gen, $op, $do, $descr_tipo, $tipocons, $lang_tipo, $language;
        echo "<center><font class=\"title\"><b>"._GESTIPO."</b></font></center><br>";
    echo "<br><br><table border=\"0\" width=\"100%\" ><tr>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._NUM."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._DESCR."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._LINGUA."</b></td><td>&nbsp;</td></tr>";
//-----------------------visualizza riga superiore per inserimento -
	echo "<form name=\"tipi2\" enctype=\"multipart/form-data\" action=\"admin.php\" method=\"post\">"
	."<input type=\"hidden\" name=\"op\" value=\"tipo\">";
	$res=mysql_query("SELECT * FROM ".$prefix."_ele_tipo where lingua='$language' order by tipo_cons", $dbi);
	$max = mysql_num_rows($res);
	$nuovo_tipo=$max+1;
	if ($do=='modify') {
		$resl = mysql_query("SELECT * FROM ".$prefix."_ele_tipo where tipo_cons='$tipocons'", $dbi);
		$tipo=mysql_fetch_array($resl);
		$nuovo_tipo=$tipo['tipo_cons'];
		echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
		echo "<input type=\"hidden\" name=\"lang_tipo\" value=\"".$tipo['lingua']."\">";
		echo "<input type=\"hidden\" name=\"tipocons\" value=\"$tipocons\">";
		echo "<tr><td>".$tipo['tipo_cons']."</td>";
	}else{
		$tipo['tipo_cons']='';
		if ($descr_tipo) $tipo['descrizione']="$descr_tipo";else $tipo['descrizione']='';
		if ($lang_tipo) $tipo['lingua']="$lang_tipo";else $tipo['lingua']=$_SESSION['lang'];
		echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
		echo "<tr><td><input type=\"text\" name=\"tipocons\" value=\"$nuovo_tipo\" size=\"5\"></td>";
	}
	echo "<td><input type=\"text\" name=\"descr_tipo\" size=\"35\" value=\"".$tipo['descrizione']."\"></td>";
	if ($do=='modify') {
		echo "<td>".$tipo['lingua']."</td>";
		echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td>";
	}else{
		echo "<td><input type=\"text\" name=\"lang_tipo\" size=\"35\" value=\"".$tipo['lingua']."\"></td>";
		echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td>";
	}
	echo "</tr></form>";
//-----------------------fine visualizza riga superiore per inserimento -


		while(list($tipov,$descv,$langv)= mysql_fetch_row($res)){
			$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
    			echo "<form name=\"elenco\" action=\"admin.php\" method=\"post\" >";
			echo "<tr bgcolor=\"$bgcolor1\"><td align=\"right\"><b>$tipov</b></td>"
			."<td align=\"left\"><b>$descv</b></td>"
			."<td align=\"left\"><b>$langv</b></td>";
			echo "<td align=\"center\" nowrap>[<a
			href=\"admin.php?op=tipo&amp;do=modify&amp;id_cons_gen=$id_cons_gen&amp;tipocons=$tipov\"><img src=\"modules/Elezioni/images/edit.gif\" border=\"0\" align=\"center\"> "._EDIT."</a>]</td>";
			echo "</tr></form>";
    		}
    echo "</table></center><br>";
}

function savetipo() {
    global $prefix, $dbi,$id_cons_gen,$op,$do,$tipocons,$descr_tipo,$lang_tipo;
	$aid=$_SESSION['aid'];
	$perms=ChiSei($id_cons_gen);
	if ($perms == 256) {
		if ($descr_tipo){
		if ($do == "add") {
			$result = mysql_query("insert into ".$prefix."_ele_tipo (tipo_cons,descrizione,lingua) values ('$tipocons','$descr_tipo','$lang_tipo')", $dbi);
			if (!$result) return;
		}elseif ($do == "update") {
			$result = mysql_query("update  ".$prefix."_ele_tipo set descrizione='$descr_tipo' where tipo_cons='$tipocons' and lingua='$lang_tipo'", $dbi);
			if (!$result) return;
		}
		}else if ($lang_tipo) $_SESSION['lang']=$lang_tipo;
	Header("Location: admin.php?op=$op&id_cons_gen=$id_cons_gen");
	}
}




if ($do and $do!='modify')
	savetipo();
ele();
tipi();
echo"</td></tr></table>";
include("footer.php");

?>
