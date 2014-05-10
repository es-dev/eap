<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Circoscrizioni                                                */
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
$id_cons_gen=$_GET['id_cons_gen'];
$perms=ChiSei($id_cons_gen);
if ($perms<16 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");

$res = mysql_query("SELECT t1.tipo_cons,t1.descrizione,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$descr_cons,$id_cons) = mysql_fetch_row($res);
include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
// Offset - visualizza il numero di elementi per pagina
if (isset($_GET['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($_GET['min'])) $min=intval($_GET['min']); else $min=0;
if (isset($_GET['id_circ'])) $id_circ=intval($_GET['id_circ']); else $id_circ='';
if (isset($_GET['ok'])) $ok=intval($_GET['ok']); else $ok='';
if (isset($_GET['num_circ'])) $num_circ=intval($_GET['num_circ']); else $num_circ='';
if (isset($_GET['descr_circ'])) get_magic_quotes_gpc() ? $descr_circ=$param['descr_circ']:$descr_circ=addslashes($param['descr_circ']); else $descr_circ='';
$offset=10;
$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";


/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/

function all() {
   global $admin, $bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min, $id_cons,$id_cons_gen,$do,$id_circ;
	echo "<center><font class=\"title\"><br><b>"._CIRCO."</b></font><br><br>";
	echo "<table border=\"0\" width=\"100%\"><tr>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\" width=\"5%\"><b>"._NUM."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<b>"._DESCR."</b>&nbsp;</td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FUNZIONI."</b></td></tr>";

	echo "<form name=\"circo\" action=\"admin.php\">"
	."<input type=\"hidden\" name=\"op\" value=\"circo\">"
	."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	if ($do == "modify"){
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_circoscrizione where id_circ='$id_circ'", $dbi);
		$pro= mysql_fetch_array($res, 3);
		echo "<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">"
		."<input type=\"hidden\" name=\"do\" value=\"update\">";
		echo "<tr><td align=\"right\"><input  name=\"num_circ\" value=\"$pro[num_circ]\" size=\"3\"></td>";
		echo "<td><input type=\"text\" name=\"descr_circ\" value=\"$pro[descrizione]\"maxlength=\"100\" size=\"40\"></td>"
		."<td align=\"center\"><input type=\"submit\" name=\"update\" value=\""._MODIFY."\"></td></tr>";
	} else {
		$result = mysql_query("select * from ".$prefix."_ele_circoscrizione where id_cons='$id_cons'",$dbi);
		$numc=mysql_num_rows($result);
		$numc++;
		echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
		echo "<tr><td align=\"right\"><input type=\"text\" name=\"num_circ\"  maxlength=\"3\" size=\"3\" value=\"$numc\"></td>"
		."<td><input type=\"text\" name=\"descr_circ\" maxlength=\"100\" size=\"40\"></td>";
		echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td></tr>";
	}	
	echo "</form><tr></tr>";
	$res = mysql_query("SELECT * FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons'  ", $dbi);
	$max = mysql_num_rows($res);
	$result = mysql_query("select * from ".$prefix."_ele_circoscrizione where id_cons='$id_cons'  ORDER BY num_circ  LIMIT $min,$offset", $dbi);
	while(list($id_cons2, $id_circ, $num_sez, $descr_circ) = mysql_fetch_row($result)) {
		$restemp = mysql_query("select count(0) from ".$prefix."_ele_sede where id_circ='$id_circ'", $dbi);
		list($numtemp)=mysql_fetch_row($restemp);
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		echo "<tr bgcolor=\"$bgcolor1\"><td align=\"right\"width=\"5%\"><b>$num_sez</b>"
		."</td><td align=\"left\"><b>$descr_circ</b>"
		."</td><td align=\"center\" nowrap>[<a
			href=\"admin.php?op=circo&amp;do=modify&amp;id_circ=$id_circ&amp;id_cons=$id_cons&amp;id_cons_gen=$id_cons_gen\"><img src=\"modules/Elezioni/images/edit.gif\"
			border=\"0\" align=\"center\"> "._EDIT."</a>]";
			if (!$numtemp)
				echo "[<a href=\"admin.php?op=circo&amp;do=delete&amp;id_circ=$id_circ&amp;descr_circ=$descr_circ&amp;id_cons=$id_cons&amp;id_cons_gen=$id_cons_gen\">"._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\"></a>]";
			else
				echo "["._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\">]";
		echo "</td></tr>";
	}
	echo "</table></center>";
	#'Pagina precedente' e 'Pagina Successiva'
	echo"<table align=\"center\" width=\"100%\" ><tr>";
	$prev=$min-$offset;
	if ($prev>=0) {
		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=circo&amp;id_cons=$id_cons&amp;min=$prev&amp;id_cons_gen=$id_cons_gen\">";
		echo "<b>$offset "._PREV_MATCH."</b></a></td>";
	}
	
	$next=$min+$offset;
	if ($next>=($offset-1)) {
		if($next>=$max) $next = $max;
		else {
			echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=circo&amp;id_cons=$id_cons&amp;min=$next&amp;id_cons_gen=$id_cons_gen\">";
			echo "<b>$offset "._NEXT_MATCH."</b></a></td>";
		}
	}
	echo "</tr></table><br>";
	
}



//***********************************
// Consultazione
// ricordarsi di aggiungere l'eliminazione di tutti
// i dati della consultazione nelle altre tabelle
//  hai capito?
//***********************************

function circo($ok, $do, $id_cons ,$num_circ,$descr_cons, $id_circ, $descr_circ) {
global $aid, $prefix, $dbi, $id_cons_gen;
$perms=	ChiSei($id_cons_gen);
if ($perms>16) {
	if ($do == "delete") {
		if ($ok !="1") {
			ele();
			echo "<center><br><br>"._DOMCANCELLA." $descr_circ ?<br>";
			echo "[ <a href=\"admin.php?op=circo&amp;id_cons_gen=$id_cons_gen\">"._NO."</a> ] - [<a href=\"admin.php?op=circo&amp;do=delete&amp;id_circ=$id_circ&amp;ok=1&amp;id_cons_gen=$id_cons_gen\">"._YES."</a> ]";
			include("footer.php");
			die();
		}else{
			$rescirc= mysql_query("select num_circ from ".$prefix."_ele_circoscrizione where id_circ=$id_circ",$dbi);
			if (mysql_num_rows($rescirc)!=1) die("(1001) Grave errore nel database! contattare l'amministratore");
			list($num_circ)=mysql_fetch_row($rescirc);
#			$rif_numcirc=($num_circ>1)?($num_circ-1):($num_circ+1);
#			$rescirc= mysql_query("select id_circ from ".$prefix."_ele_circoscrizione where num_circ=$rif_numcirc and id_cons=$id_cons",$dbi);
#			if (mysql_num_rows($rescirc)!=1) die("(1002) Grave errore nel database! contattare l'amministratore -- select id_circ from ".$prefix."_ele_circoscrizione where num_circ=$rif_numcirc  -- $num_circ and id_cons=$id_cons");
#			list($rif_idcirc)=mysql_fetch_row($rescirc);
#			mysql_query("update ".$prefix."_ele_sede set id_circ=$rif_idcirc where id_circ=$id_circ",$dbi);
			$result = mysql_query("delete from ".$prefix."_ele_circoscrizione where id_circ='$id_circ'", $dbi)|| die("(1003) Grave errore nel database! contattare l'amministratore".mysql_error());
			$rescirc= mysql_query("select id_circ,num_circ from ".$prefix."_ele_circoscrizione where num_circ>$num_circ and id_cons=$id_cons",$dbi);
			while (list($tmp_id,$tmp_num)=mysql_fetch_row($rescirc))
				mysql_query("update ".$prefix."_ele_circoscrizione set num_circ=".($tmp_num-1)." where id_circ=$tmp_id",$dbi);
			Header("Location: admin.php?op=circo&id_cons_gen=$id_cons_gen");
		}
	}elseif ($do == "add") {
		if ($descr_circ) {
			$result = mysql_query("insert into ".$prefix."_ele_circoscrizione (id_cons,num_circ,descrizione) values ('$id_cons','$num_circ','$descr_circ')", $dbi)|| die("(1004) Non e' stato possibile inserire i dati nel database! contattare l'amministratore".mysql_error());
			Header("Location: admin.php?op=circo&id_cons_gen=$id_cons_gen");
		}
	}elseif ($do == "update") {
		
		$result = mysql_query("update  ".$prefix."_ele_circoscrizione set num_circ='$num_circ' , descrizione='$descr_circ' WHERE id_circ='$id_circ'", $dbi)|| die("(1005) Non e' stato possibile aggiornare i dati! contattare l'amministratore".mysql_error());
		Header("Location: admin.php?op=circo&id_cons_gen=$id_cons_gen");
	}
	

}

}


if ($do!= "")
    circo($ok,$do, $id_cons,$num_circ,$descr_cons,$id_circ,$descr_circ);
ele();
all();
echo"</td></tr></table>";
include("footer.php");
?>

