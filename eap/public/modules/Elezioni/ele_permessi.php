<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Permessi                                                     */
/* Amministrazione                                                     */
/************************************************************************/

if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=$param['id_cons_gen'];

$perms=ChiSei($id_cons_gen);
if ($perms<64 or !$id_cons_gen) die("Non hai i permessi per inserire dati ($perms)($id_cons_gen), o non hai scelto la consultazione!");
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);
if (isset($param['aid2'])) get_magic_quotes_gpc() ? $aid2=$param['aid2']:$aid2=addslashes($param['aid2']); else $aid2='';
if (isset($param['id_sede'])) $id_sede=intval($param['id_sede']); else $id_sede='';
if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['permessi'])) get_magic_quotes_gpc() ? $permessi=$param['permessi']:$permessi=addslashes($param['permessi']); else $permessi='';
if (isset($param['id_comune2'])) $id_comune2=intval($param['id_comune2']); else $id_comune2='';
if (isset($param['ok'])) $ok=intval($param['ok']); else $ok='';
if (isset($param['mex'])) get_magic_quotes_gpc() ? $mex=$param['mex']:$mex=addslashes($param['mex']); else $mex='';

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");

/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/
//crea la pagina delle affluenze
function all() {
	global $adminop,$adminsuper,$admincomune,$aid, $offset, $prefix, $dbi,$id_cons,$aid2,$permessi,$id_sede,$id_cons_gen,$id_comune,$mex;
	$bgcolor1=$_SESSION['bgcolor1'];
	if (isset($mex)){
		echo "<table align=\"center\"><tr><td style=\"background-color: rgb(255, 0, 0)\">";
		echo $mex;
		echo "</td></tr></table>";
	}	
	OpenTable();
	$resmod = mysql_query("SELECT * FROM ".$prefix."_ele_operatori where id_cons=$id_cons and permessi<64 order by aid", $dbi);

	echo "<br><table><tr align=\"center\" bgcolor=\"$bgcolor1\">";
	echo "<td><b>"._UTENTE."</b></td>"
	."<td bgcolor=\"$bgcolor1\"><b>"._SEDE."</b></td>"
	."<td bgcolor=\"$bgcolor1\"><b>"._PERMESSI."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._FUNZIONI."</b></td></tr>";

	
		
	$restmp = mysql_query("SELECT aid FROM ".$prefix."_ele_operatori where id_cons=$id_cons and permessi<64 order by aid", $dbi);
	if($restmp) {
	$listmp='';$virg='';
	while (list($artmp) = mysql_fetch_row($restmp)){ //elenco degli operatori gia' autorizzati
		$listmp .= $virg."'".$artmp."'";
		$virg=',';
	}
	}
        
	if (!$listmp) $listmp="''";
	$resins = mysql_query("select aid from ".$prefix."_authors where id_comune=$id_comune and (admincomune=1 and aid not in ($listmp)) order by aid",$dbi); // operatori registrati ma non ancora autorizzati
	
         
	echo "<form name=\"autorizza\" action=\"admin.php\">"
	."<input type=\"hidden\" name=\"op\" value=\"permessi\">";
	echo "<tr align=\"center\">";
	echo "<td><select name=\"aid2\">";
	echo "<option value=\"\">";
	if($resins) {
		while(list($utente)=mysql_fetch_row($resins)){
			echo "<option value=\"$utente\">$utente";
		}
	}
	echo "</select></td>";
	$ressede = mysql_query("SELECT id_sede, indirizzo from ".$prefix."_ele_sede where id_cons=$id_cons", $dbi);
	echo "<td><select name=\"id_sede\">";
	echo "<option value=\"0\"> "._TUTTESEDI;
	if($ressede)
	while(list($id,$descr)=mysql_fetch_row($ressede)){
		$sel= ($id == $id_sede) ? "selected":"";
		$arr[$id]=$descr;
		echo "<option value=\"$id\" $sel>$descr";
	}
	echo "</select></td>";
	echo "<td><select name=\"permessi\">";
	if(!isset($permessi)) $permessi=16;
	$sel=($permessi==32) ? "selected":"";
	echo "<option value=\"32\" $sel>"._IMPOSTA_DATI;
	$sel=($permessi==16) ? "selected":"";
	echo "<option value=\"16\" $sel>"._INSERISCE_DATI;
	$sel=($permessi==0) ? "selected":"";
	echo "<option value=\"0\" $sel>"._SOSPESO;
	echo "</select></td>";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<input type=\"hidden\" name=\"ok\" value=0>";
	echo "<input type=\"hidden\" name=\"do\" value=\"autorizza\">";
	echo "<td><input type=\"submit\" name=\"add\" value=\""._AGGIUNGI."\"></td></tr></form></table>";
	echo "<br><hr><br><table>";
	if($resmod){
		$i=1;
		while (list($id_cons2,$id_sede2,$id_comunetemp,$perm,$utente) = mysql_fetch_row($resmod)){ 
			$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
			echo "<form name=\"modello$i\" action=\"admin.php\">"
				."<input type=\"hidden\" name=\"op\" value=\"permessi\">";
			echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
			echo "<input type=\"hidden\" name=\"aid2\" value=\"$utente\">";
			echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
			echo "<input type=\"hidden\" name=\"ok\" value=0>";
			echo "<tr align=\"center\" bgcolor=\"$bgcolor1\">";
			echo "<td  align=\"center\" width=\"32\"><b>$utente</b></td>";
			$ressede = mysql_query("SELECT id_sede, indirizzo from ".$prefix."_ele_sede where id_cons=$id_cons", $dbi);
			echo "<td><select name=\"id_sede\">";
			echo "<option value=\"0\"> "._TUTTESEDI;
			while(list($id,$descr)=mysql_fetch_row($ressede)){
				$sel= ($id == $id_sede2) ? "selected":"";
				$arr[$id]=$descr;
				echo "<option value=\"$id\" $sel>$descr";
			}
			echo "</select></td>";
			echo "<td><select name=\"permessi\">";
			if(!isset($perm)) $perm=16;
			$sel=($perm==32) ? "selected":"";
			echo "<option value=\"32\" $sel>"._IMPOSTA_DATI;
			$sel=($perm==16) ? "selected":"";
			echo "<option value=\"16\" $sel>"._INSERISCE_DATI;
			$sel=($perm==0) ? "selected":"";
			echo "<option value=\"0\" $sel>"._SOSPESO;
			echo "</select></td>";
			echo "<td><input type=\"submit\" name=\"add\" value=\""._OK."\"></td></tr></form>";
			$i++;
		}
	}
	echo "</table>";
	CloseTable();
}

function permessi($ok, $do,$aid2,$id_sede,$permessi,$id_comune) {
	global $prefix, $dbi, $id_cons,$id_cons_gen,$currentlang;
	$perms=ChiSei($id_cons_gen);
	if ($perms!=256) $id_comune=$_SESSION['id_comune'];
	if ($perms>32 and $permessi<$perms and $aid2) {
		if ($do == "autorizza") {
			$result = mysql_query("insert into ".$prefix."_ele_operatori (id_cons,id_sede,id_comune,permessi,aid) values ('$id_cons','$id_sede','$id_comune','$permessi','$aid2')", $dbi)||die("Errore 1301: Non e' stato possibile inserire l'utente!".mysql_error());
			Header("Location: admin.php?op=permessi&id_cons_gen=$id_cons_gen");
		} elseif ($do == "update") {
			$result = mysql_query("update  ".$prefix."_ele_operatori set id_sede='$id_sede' , permessi='$permessi' where id_cons='$id_cons' and aid='$aid2' ", $dbi);
			if (!$result) return;
			Header("Location: admin.php?op=permessi&id_cons_gen=$id_cons_gen");
		}
	} 
}

	
//****************************
// switch
//****************************
	if ($do) permessi($ok, $do,$aid2,$id_sede,$permessi,$id_comune);
	ele();
	all();
	include("footer.php");
?>

