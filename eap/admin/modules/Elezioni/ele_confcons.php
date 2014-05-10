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

// Offset - visualizza il numero di elementi per pagina
$offset=5;

$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$currentlang=$_SESSION['lang'];
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=$param['id_cons_gen'];	
$perms=ChiSei($id_cons_gen);
if ($perms<32 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");

$id_comune=$_SESSION['id_comune'];
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune' " , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");

if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['ok'])) get_magic_quotes_gpc() ? $ok=$param['ok']:$ok=addslashes($param['ok']); else $ok='';
if (isset($param['descrizione'])) get_magic_quotes_gpc() ? 
$descrizione=$param['descrizione']:$descrizione=addslashes($param['descrizione']); else $descrizione='';
if (isset($param['id_conf'])) $id_conf=intval($param['id_conf']); else $id_conf='';
if (isset($param['limite'])) get_magic_quotes_gpc() ? $limite=$param['limite']:$limite=addslashes($param['limite']); else $limite='';
if (isset($param['consin'])) get_magic_quotes_gpc() ? $consin=$param['consin']:$consin=addslashes($param['consin']); else $consin='';
if (isset($param['infpremio'])) get_magic_quotes_gpc() ? $infpremio=$param['infpremio']:$infpremio=addslashes($param['infpremio']); else $infpremio='';
if (isset($param['listinfsbar'])) get_magic_quotes_gpc() ? $listinfsbar=$param['listinfsbar']:$listinfsbar=addslashes($param['listinfsbar']); else $listinfsbar='';
if (isset($param['infminpremio'])) get_magic_quotes_gpc() ? $infminpremio=$param['infminpremio']:$infminpremio=addslashes($param['infminpremio']); else $infminpremio='';
if (isset($param['listinfconta'])) get_magic_quotes_gpc() ? $listinfconta=$param['listinfconta']:$listinfconta=addslashes($param['listinfconta']); else $listinfconta='';
if (isset($param['suppremio'])) get_magic_quotes_gpc() ? $suppremio=$param['suppremio']:$suppremio=addslashes($param['suppremio']); else $suppremio='';
if (isset($param['supsbarramento'])) get_magic_quotes_gpc() ? $supsbarramento=$param['supsbarramento']:$supsbarramento=addslashes($param['supsbarramento']); else $supsbarramento='';
if (isset($param['supminpremio'])) get_magic_quotes_gpc() ? $supminpremio=$param['supminpremio']:$supminpremio=addslashes($param['supminpremio']); else $supminpremio='';
if (isset($param['listsupconta'])) get_magic_quotes_gpc() ? $listsupconta=$param['listsupconta']:$listsupconta=addslashes($param['listsupconta']); else $listsupconta='';
if (isset($param['help'])) $help=intval($param['help']);

/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/
	function all() {
   		global $tipo_cons,$param,$currentlang, $bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min, $id_cons,$id_cons_gen,$id_comune,$do,$id_conf, $language,$help;
	
//		$restemp = mysql_query("select count(0) from ".$prefix."_ele_conf where id_conf='$id_conf'", $dbi);
//		list($numtemp)=mysql_fetch_row($restemp);

	if (isset($help)) include("language/$language/ele_confcons.html");

	echo "<center><br><table border=\"0\" width=\"100%\">";

	//-----------------------visualizza blocco inserimento -
	$res = mysql_query("SELECT * FROM ".$prefix."_ele_conf", $dbi); //da modificare
	$max = mysql_num_rows($res);
	$nuovo_gruppo=$max+1;
	echo "<form name=\"gruppo2\" enctype=\"multipart/form-data\" action=\"admin.php\" method=\"post\">"
	."<input type=\"hidden\" name=\"op\" value=\"confconsiglio\">";
	if ($do=='modify') {
	$resl = mysql_query("SELECT * FROM ".$prefix."_ele_conf where id_conf='$id_conf'", $dbi);
	$gru=mysql_fetch_array($resl);
	$nuovo_gruppo=$gru['id_conf'];
	echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
	}else{
	$gru['id_conf']=$nuovo_gruppo;$gru['descrizione']='';$gru['limite']='';$gru['consin']='';$gru['infpremio']='';$gru['listinfsbar']='';$gru['listinfconta']='';$gru['supminpremio']='';$gru['infminpremio']='';$gru['suppremio']='';$gru['supsbarramento']='';$gru['listsupconta']='';
	echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
	}
	echo "<tr bgcolor=\"$bgcolor2\"><td align=\"center\"><input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
//	echo "<b>"._NUM."</b></td><td><input type=\"hidden\" name=\"id_conf\" value=\"".$gru['id_conf']."\">".$gru['id_conf']."</td><td align=\"center\">"
	echo "<input type=\"hidden\" name=\"id_conf\" value=\"".$gru['id_conf']."\"><b>"._DESCR."</b></td><td colspan=\"3\"><input type=\"text\" name=\"descrizione\" value=\"".$gru['descrizione']."\"></td></tr>"
	."<tr><td align=\"center\"><b>"._LIMITE."</b></td><td><select name=\"limite\"><option value=\"0\">"._NOFASCIA;
		
		$result1 = mysql_query("select id_fascia, abitanti from ".$prefix."_ele_fasce ", $dbi);
		while(list($id,$descr)=mysql_fetch_row($result1)){
			$sel= ($id == $gru['limite']) ? "selected":"";
			echo "<option value=\"$id\" $sel>$descr";
		}
		echo "</select></td>";
	$sel= ($gru['consin']==1) ? "selected":"";
	echo "<td align=\"center\"><b>"._CONSIN."</b></td><td><select name=\"consin\"><option value=\"0\">No<option value=\"1\" $sel>Si</select></td></tr>"
	."<tr><td align=\"center\" colspan=\"4\" bgcolor=\"$bgcolor2\"><b>"._SISTEMA_MAGGIORITARIO."</b></td></tr>"
	."<tr><td align=\"center\"><b>"._INFPREMIO."</b></td><td><input type=\"text\" name=\"infpremio\" value=\"".$gru['infpremio']."\"></td>"
	."<td align=\"center\"><b>"._LISTINFSBAR."</b></td><td><input type=\"text\" name=\"listinfsbar\" value=\"".$gru['listinfsbar']."\"></td></tr>"
	."<tr><td align=\"center\"><b>"._INFMINPREMIO."</b></td><td><input type=\"text\" name=\"infminpremio\" value=\"".$gru['infminpremio']."\"></td>";
	$sel= ($gru['listinfconta']==1) ? "selected":"";
	echo"<td align=\"center\"><b>"._LISTINFCONTA."</b></td><td><select name=\"listinfconta\"><option value=\"0\">No<option value=\"1\" $sel>Si</select></td></tr>"
	."<tr><td align=\"center\" colspan=\"4\" bgcolor=\"$bgcolor2\"><b>"._SISTEMA_PROPORZIONALE."</b></td></tr>"
	."<tr><td align=\"center\"><b>"._SUPPREMIO."</b></td><td><input type=\"text\" name=\"suppremio\" value=\"".$gru['suppremio']."\"></td>"
	."<td align=\"center\"><b>"._SUPSBAR."</b></td><td><input type=\"text\" name=\"supsbarramento\" value=\"".$gru['supsbarramento']."\"></td></tr>"
	."<tr><td align=\"center\"><b>"._SUPMINPREMIO."</b></td><td><input type=\"text\" name=\"supminpremio\" value=\"".$gru['supminpremio']."\"></td>";
	$sel= ($gru['listsupconta']==1) ? "selected":"";
	echo "<td align=\"center\"><b>"._LISTSUPCONTA."</b></td><td><select name=\"listsupconta\"><option value=\"0\">No<option value=\"1\" $sel>Si</select>";
	echo "<input type=\"hidden\" name=\"id_cons\" value=\"$id_cons\">"
	."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
	."<input type=\"hidden\" name=\"min\" value=\"$min\"></td></tr><tr><td></td><td></td><td></td>";
	if ($do=='modify') 
		echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td>";
	else
		echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td>";
	echo "</tr></form>";
		
		
		
	$res = mysql_query("SELECT * FROM ".$prefix."_ele_conf", $dbi);
	$max = mysql_num_rows($res);
	$result = mysql_query("select * from ".$prefix."_ele_conf ORDER BY id_conf  LIMIT $min,$offset", $dbi);
	while(list($id_conf,$descrizione,$limite, $consin,$infpremio, $supsbarramento, $suppremio, $listinfsbar, $listinfconta, $listsupconta) = mysql_fetch_row($result)) {
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		echo "<tr bgcolor=\"$bgcolor1\"><td align=\"center\"><b>$id_conf</b></td>"
		."<td align=\"left\"><b>$descrizione</b></td>"; /*
		."<td align=\"center\"><b>$limite</b></td>"
		."<td align=\"center\"><b>$consin</b></td>"
		."<td align=\"center\"><b>$infpremio</b></td>"
		."<td align=\"center\"><b>$supsbarramento</b></td>"
		."<td align=\"center\"><b>$suppremio</b></td>"
		."<td align=\"center\"><b>$listinfsbar</b></td>"
		."<td align=\"center\"><b>$listinfconta</b></td>"
		."<td align=\"center\"><b>$listsupconta</b></td>" */
		echo "<td align=\"center\" nowrap>[<a
		href=\"admin.php?op=confconsiglio&amp;do=modify&amp;id_conf=$id_conf&amp;id_cons_gen=$id_cons_gen&amp;min=$min\"><img src=\"modules/Elezioni/images/edit.gif\"
	 	border=\"0\" align=\"center\"> "._EDIT."</a>]";
		
		if (!isset($numtemp))
			echo "[<a href=\"admin.php?op=confconsiglio&amp;do=delete&amp;id_conf=$id_conf&amp;id_cons_gen=$id_cons_gen&amp;min=$min\">"._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\"></a>]";
		else
			echo "["._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\"></a>]";
		echo "</td></tr>";
    	}
    	echo "</table></center>";

//      #'Pagina precedente' e 'Pagina Successiva'

      		echo"<table align=\"center\" width=\"100%\" ><tr>";
      		$prev=$min-$offset;
      		if ($prev>=0) {
              		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=confconsiglio&amp;id_conf=$id_conf&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;min=$prev\">";
              		echo "<b>$offset "._PREV_MATCH."</b></a></td>";
      		}

      		$next=$min+$offset;
      		if ($next>=($offset-1)) {
        		if($next>=$max) $next = $max;
	  		else {
 	             		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=confconsiglio&amp;id_conf=$id_conf&amp;id_cons_gen=$id_cons_gen&amp;min=$next\">";
              			echo "<b>$offset "._NEXT_MATCH."</b></a></td>";
        		}
      		}
     		echo "</tr></table><br>";

	}

//***********************************************************
//Funzione di inserimento e gestione dei gruppi
//************************************************************

function confcons($ok, $do) {
	global $prefix, $dbi, $id_cons,$simbolo2,$genere,$id_cons_gen,$id_comune,$min,$id_conf,$descrizione, $limite,$consin,$infpremio,$listinfsbar,$infminpremio,$listinfconta,$supsbarramento,$suppremio,$supminpremio,$listsupconta;
	$aid=$_SESSION['aid'];
	$perms=ChiSei($id_cons_gen);
	if ($perms >128) {
       	if ($do == "delete") {  
     			if ($ok !="1") {
				ele();
				echo "<center><br><br>"._DOMCANCELLA." "._DESCR." $descrizione ?<br>";
				echo "[ <a href=\"admin.php?op=confconsiglio&amp;id_cons_gen=$id_cons_gen&amp;id_conf=$id_conf\">"._NO."</a> ] - [<a href=\"admin.php?op=confconsiglio&amp;do=delete&amp;id_conf=$id_conf&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;ok=1\">"._YES."</a> ]";exit;
     			}else{
				$result = mysql_query("delete from ".$prefix."_ele_conf where id_conf='$id_conf'", $dbi);
          			if (!$result) return;
				Header("Location: admin.php?op=confconsiglio&id_cons_gen=$id_cons_gen&id_conf=$id_conf&min=$min");
			}
      		} elseif ($do == "add") {
      			if ($descrizione) {
				$sqlset='';
      				$result = mysql_query("insert into ".$prefix."_ele_conf(id_conf,descrizione, limite,consin,infpremio,supsbarramento,suppremio,listinfsbar,listinfconta,listsupconta,infminpremio,supminpremio) values ('$id_conf','$descrizione','$limite','$consin','$infpremio','$supsbarramento','$suppremio','$listinfsbar','$listinfconta','$listsupconta','$infminpremio','$supminpremio')", $dbi) || die("Errore di aggiornamento dei dati!".mysql_error());
           			if (!$result) return;
           			Header("Location: admin.php?op=confconsiglio&id_cons_gen=$id_cons_gen&min=$min");
     			} else {
        			ele();
        			OpenTable();
				echo "<center>"._GESTIONE." "._CONF." ";
        			echo "<br><br><a href=\"admin.php?op=confconsiglio&amp;id_cons_gen=$id_cons_gen\">"._IMM." "._CONF."</a></center>";
				CloseTable();
     			}
   		} elseif ($do == "update") {
			$result = mysql_query("update  ".$prefix."_ele_conf set descrizione='$descrizione', limite='$limite', consin='$consin', infpremio='$infpremio', supsbarramento='$supsbarramento', suppremio='$suppremio', listinfsbar='$listinfsbar', listinfconta='$listinfconta', listsupconta='$listsupconta', infminpremio='$infminpremio', supminpremio='$supminpremio' where id_conf='$id_conf' ", $dbi) || die("Errore di aggiornamento dei dati!".mysql_error());
			Header("Location: admin.php?op=confconsiglio&id_cons_gen=$id_cons_gen&min=$min");
   		}

	}
}

if ($do and $do!="modify")
	confcons($ok, $do);
ele();
all();
echo"</td></tr></table>";
include("footer.php");




?>

