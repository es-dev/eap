<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Amministratori                                                */
/* Amministrazione                                                      */
/************************************************************************/
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

// Offset - visualizza il numero di elementi per pagina
$offset=15;
if (!isset($min)) $min=0;

$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
if (isset($_GET['do'])) $do=$_GET['do']; else $do='';

$id_cons_gen=$_GET['id_cons_gen'];
$perms=ChiSei(0);
if ($perms!=256) die("Non hai i permessi per inserire dati!");
if (isset($_GET['aid2'])) get_magic_quotes_gpc() ? $aid2=$param['aid2']:$aid2=addslashes($param['aid2']); else $aid2='';
if (isset($_GET['id_sede'])) $id_sede=intval($_GET['id_sede']); else $id_sede='';
if (isset($_GET['id_comune2'])) $id_comune2=intval($_GET['id_comune2']); else $id_comune2='';
if (isset($_GET['id_cons_gen'])) $id_cons_gen=intval($_GET['id_cons_gen']); else $id_cons_gen='';


$res = mysql_query("SELECT t1.tipo_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t1.id_cons_gen='$id_cons_gen' " , $dbi);
list($tipo_cons) = mysql_fetch_row($res);

$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";


/******************************************************/
/*Funzione di visualizzazione globale                 */
/******************************************************/
//crea la pagina delle affluenze
function all() {
	global $bgcolor1, $bgcolor2, $prefix,$aid2,$perms,$id_sede,$id_comune2,$id_cons_gen;
	$aid=$_SESSION['aid'];
	$dbi=$_SESSION['dbi'];
	$prefix=$_SESSION['prefix'];

	OpenTable();	
	
	$resmod = mysql_query("SELECT id_comune,permessi FROM ".$prefix."_ele_operatori where id_cons='0' and aid='$aid' and id_comune='0'", $dbi);
	list ($id_comu,$permessi) = mysql_fetch_row($resmod);
	if ($perms!=256) 
	{
	Closetable();
	return;
	}
	$resmod = mysql_query("SELECT * FROM ".$prefix."_ele_operatori where id_cons=0 and id_comune>0", $dbi);
	echo "<table><tr></tr><hr><tr align=\"center\">";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._UTENTE."</b></td>"
	."<td bgcolor=\"$bgcolor1\"><b>"._DEFCOMUNE."</b></td>"
	."<td bgcolor=\"$bgcolor1\"><b>"._PERMESSI."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._FUNZIONI."</b></td></tr>";
	echo "<form name=\"modello\" action=\"admin.php\">"
		."<input type=\"hidden\" name=\"op\" value=\"oper_admin\">";
	echo "<tr align=\"center\">";
	if ($aid2) {
		echo "<input type=\"hidden\" name=\"aid2\" value=\"$aid2\"><td  align=\"center\" width=\"32\">$aid2</td>";
	}else{
		echo "<td  align=\"center\" width=\"32\"><input name=\"aid2\"></td>";
	}
	$ressede = mysql_query("SELECT id_comune, descrizione from ".$prefix."_ele_comuni", $dbi);
	echo "<td><select name=\"id_comune2\">";
	echo "<option value=\"\">";
	while(list($id,$descr)=mysql_fetch_row($ressede)){
		$sel= ($id == $id_comune2) ? "selected":"";
		$arr[$id]="$descr";
		echo "<option value=\"$id\" $sel>$descr";
	}
	echo "</select></td>";
	echo "<td  align=\"center\" width=\"32\"><select name=\"permessi\">";
	$sel0='';$sel64='';
	if($permessi=='0') $sel0="selected";elseif($permessi=='64') $sel64="selected";
	echo "<option value=\"\">";
	echo "<option value=\"64\" $sel64>"._ATTIVO;
	echo "<option value=\"0\" $sel0>"._SOSPESO."</td>";
	echo "</select></td>";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	if ($aid2) {
		echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
		echo "<td><input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td></tr></form>";
	}else{
		echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
		echo "<td><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td></tr></form>";
	}
	$i=1;
	while (list($id_cons2,$id_sede2,$id_comune2,$perm,$utente) = mysql_fetch_row($resmod)){ //elenco dei modelli inseriti
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		echo "<form name=\"modello$i\" action=\"admin.php\">"
			."<input type=\"hidden\" name=\"op\" value=\"oper_admin\">";
		echo "<input type=\"hidden\" name=\"id_comune2\" value=\"$id_comune2\">";
		echo "<input type=\"hidden\" name=\"aid2\" value=\"$utente\">";
		echo "<input type=\"hidden\" name=\"permessi\" value=\"$perm\">";
		echo "<tr align=\"center\" bgcolor=\"$bgcolor1\">";
		echo "<td width=\"32\"><b>$utente</b></td>";
		echo "<td width=\"32\"><b>".$arr[$id_comune2]."</b></td>";
		if ($perm==64) {$perm_text=_ATTIVO;}else{$perm_text=_SOSPESO;}
		echo "<td width=\"32\"><b>$perm_text</b></td>";
		echo "</td><td nowrap>[<a
		href=\"admin.php?op=oper_admin&amp;aid2=$utente&amp;id_cons_gen=$id_cons_gen&amp;id_comune2=$id_comune2&amp;permessi=$perm\"><img align=\"center\" src=\"modules/Elezioni/images/edit.gif\"
		border=\"0\"> "._EDIT."</a>]";
		echo "</tr></form>";
		$i++;
	}
	echo "</table>";
	CloseTable();
}

function oper_admin() {
	global $bgcolor1, $bgcolor2, $prefix, $dbi,$id_cons_gen;
	$aid=$_SESSION['aid'];
	$dbi=$_SESSION['dbi'];
	$prefix=$_SESSION['prefix'];
	$pwd=$_SESSION['pwd'];
	$perms=ChiSei(0);
	if ($perms==256) {
		$aid2=$_GET['aid2'];
		$do=$_GET['do'];
		$id_comune2=$_GET['id_comune2'];
		$permessi=$_GET['permessi'];
		if ($do == "add") {
			if ($aid2) {
				$result = mysql_query("select * from ".$prefix."_ele_operatori where aid='$aid2'", $dbi);
				$result = mysql_query("insert into ".$prefix."_ele_operatori (id_cons,id_sede,id_comune,permessi,aid) values ('0','0','$id_comune2','$permessi','$aid2')", $dbi) || die("<br><br>Errore di inserimento: ".mysql_error());
				Header("Location: admin.php?op=oper_admin&id_cons_gen=$id_cons_gen");
			} else {
				OpenTable();
				echo "<center>"._GESTIONE." "._OPERATORI." aid=$aid2; ";
				echo "<br><br><a href=\"admin.php?op=oper_admin&amp;id_cons_gen=$id_cons_gen\">"._IMM." "._OPERATORI."</a></center>";
				CloseTable();
			}
		}else if ($do == "update") {
			$result = mysql_query("update  ".$prefix."_ele_operatori set permessi='$permessi' where id_cons='0' and aid='$aid2' ", $dbi) || die("<br><br>Errore di inserimento: ".mysql_error());
			Header("Location: admin.php?op=oper_admin&id_cons_gen=$id_cons_gen");
		} 
	}else die("Non ci provare...");
}

//****************************
// switch
//****************************
	if ($do!="")
    		oper_admin();
	include("modules/Elezioni/funzionidata.php");
	include("modules/Elezioni/ele.php");
	ele();
	all();
	include("footer.php");

?>

