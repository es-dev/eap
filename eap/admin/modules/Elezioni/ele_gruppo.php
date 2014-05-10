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
$id_cons_gen=intval($param['id_cons_gen']);	
$perms=ChiSei($id_cons_gen);
if ($perms<32 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$id_comune=$_SESSION['id_comune'];
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune' " , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");

if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['id_sede'])) $id_sede=intval($param['id_sede']); else $id_sede='';
if (isset($param['ok'])) get_magic_quotes_gpc() ? $ok=$param['ok']:$ok=addslashes($param['ok']); else $ok='';
if (isset($param['id_circ'])) {$id_circ=intval($param['id_circ']); $_SESSION['id_circ']=$id_circ;} else
if (isset($_SESSION['id_circ'])) $id_circ=intval($_SESSION['id_circ']); else $id_circ='';
if (isset($param['id_gruppo'])) $id_gruppo=intval($param['id_gruppo']); else $id_gruppo='';
if (isset($param['num_gruppo'])) $num_gruppo=intval($param['num_gruppo']); else $num_gruppo='';
if (isset($param['descr_gruppo'])) get_magic_quotes_gpc() ? $descr_gruppo=$param['descr_gruppo']:$descr_gruppo=addslashes($param['descr_gruppo']); else $descr_gruppo='';
if (isset($param['simbolo'])) get_magic_quotes_gpc() ? $simbolo=$param['simbolo']:$simbolo=addslashes($param['simbolo']); else $simbolo='';
/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/
	function all() {
   		global $tipo_cons,$param,$currentlang, $bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min, $id_cons,$id_cons_gen,$id_comune,$id_circ,$do,$id_gruppo;
	$res = mysql_query("SELECT circo FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons' and lingua='$currentlang'", $dbi);
	list($cons_circ)= mysql_fetch_row($res);
	if($cons_circ)
	{
		echo "<form name=\"circo\" action=\"admin.php\" method=\"post\">";
		echo "<br><table border=\"1\" width=\"50%\" ><tr bgcolor=\"$bgcolor1\"><td>"._SCEGLI_CIRCO.": </td>";
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons'", $dbi);
		echo "<input type=\"hidden\" name=\"pag\" value=\"admin.php?op=gruppo&amp;id_cons_gen=$id_cons_gen&amp;id_circ=\">";
		echo "<td><select name=\"id_circ\" onChange=\"top.location.href=this.form.pag.value+this.form.id_circ.options[this.form.id_circ.selectedIndex].value;return false\">";
		echo "<option value=\"\">";
		while($arr=mysql_fetch_array($res,3)){
			if (!$id_circ) $id_circ=$arr['id_circ'];
			$sel= ($arr['id_circ'] == $id_circ) ? "selected":"";
			echo "<option value=\"".$arr['id_circ']."\" $sel>".$arr['descrizione'];
		}
		echo "</select></td></tr></table></form>";
	}
	echo "<center><font class=\"title\"><b>"._GRUPPO."</b></font><br><table border=\"0\" width=\"100%\"><tr bgcolor=\"$bgcolor1\">"
	."<td align=\"center\"width=\"5%\"><b>"._NUM."</b></td>"
	."<td align=\"center\"><b>"._DESCR."</b></td>"
	."<td align=\"center\"width=\"5%\"><b>"._SIMBOLO."</b></td>"
	."<td align=\"center\"><b>"._FUNZIONI."</b></td></tr>";
	//-----------------------visualizza riga superiore per inserimento -
	$circo= $cons_circ==1 ? "and id_circ='$id_circ'":"";	
	$res = mysql_query("SELECT * FROM ".$prefix."_ele_gruppo where id_cons='$id_cons' $circo ", $dbi);
	$max = mysql_num_rows($res);
	$nuovo_gruppo=$max+1;
	echo "<form name=\"gruppo2\" enctype=\"multipart/form-data\" action=\"admin.php\" method=\"post\">"
	."<input type=\"hidden\" name=\"op\" value=\"gruppo\">";
	if ($do=='modify') {
	$resl = mysql_query("SELECT * FROM ".$prefix."_ele_gruppo where id_gruppo='$id_gruppo'", $dbi);
	$gru=mysql_fetch_array($resl);
	$nuovo_gruppo=$gru['num_gruppo'];
	echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
	}else{
	$gru['id_gruppo']='';$gru['descrizione']='';
	echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
	}	

	//-----------------------fine visualizza riga superiore per inserimento -
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
	."<input type=\"hidden\" name=\"id_gruppo\" value=\"".$gru['id_gruppo']."\">"
	."<tr><td><input type=\"text\" name=\"num_gruppo\" value=\"$nuovo_gruppo\" size=\"5\"></td>"
	."<td><input type=\"text\" name=\"descr_gruppo\" size=\"50\" value=\"".$gru['descrizione']."\"></td>";
	echo "<td><input type=\"file\" name=\"stemma\" size=\"10\"></td>"; //file=$gru[simbolo]
	echo "<input type=\"hidden\" name=\"min\" value=\"$min\">";
	echo "<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\">";
	echo "<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">";
	echo "<input type=\"hidden\" name=\"id_cons\" value=\"$id_cons\">"
	."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
	."<input type=\"hidden\" name=\"min\" value=\"$min\">";
	if ($do=='modify') 
		echo "<td><input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td>";
	else
		echo "<td><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td>";
	echo "</form>";
		
		
		
	$res = mysql_query("SELECT * FROM ".$prefix."_ele_gruppo where id_cons='$id_cons' $circo ", $dbi);
	$max = mysql_num_rows($res);
	$result = mysql_query("select * from ".$prefix."_ele_gruppo where id_cons='$id_cons' $circo ORDER BY num_gruppo  LIMIT $min,$offset", $dbi);
	while(list($id_cons2,$id_gruppo,$num_gruppo, $descr_gruppo, $simbolo) = mysql_fetch_row($result)) {
		$restemp = mysql_query("select count(0) from ".$prefix."_ele_lista where id_gruppo='$id_gruppo'", $dbi);
		list($numtemp)=mysql_fetch_row($restemp);
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		if (!$simbolo) $simbolo="nulla.jpg";
		echo "<tr bgcolor=\"$bgcolor1\"><td align=\"center\"><b>$num_gruppo</b></td>"
		."<td align=\"left\"><b>$descr_gruppo</b></td>";
		echo "<td align=\"center\"><b>
		<img  src=\"admin.php?op=foto&amp;id_gruppo=$id_gruppo\" width=\"50\" heigth=\"50\"></b></td>";
		echo "<td align=\"center\" nowrap>[<a
		href=\"admin.php?op=gruppo&amp;do=modify&amp;id_gruppo=$id_gruppo&amp;id_cons_gen=$id_cons_gen&amp;id_circ=$id_circ&amp;min=$min\"><img src=\"modules/Elezioni/images/edit.gif\"
	 	border=\"0\" align=\"center\"> "._EDIT."</a>]";
		if (!$numtemp)
			echo "[<a href=\"admin.php?op=gruppo&amp;do=delete&amp;id_gruppo=$id_gruppo&amp;id_cons_gen=$id_cons_gen&amp;id_circ=$id_circ&amp;descr_gruppo=$descr_gruppo&amp;min=$min\">"._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\"></a>]";
		else
			echo "["._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\"></a>]";
		echo "</td></tr>";
    	}
    	echo "</table></center>";

//      #'Pagina precedente' e 'Pagina Successiva'

      		echo"<table align=\"center\" width=\"100%\" ><tr>";
      		$prev=$min-$offset;
      		if ($prev>=0) {
              		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=gruppo&amp;id_gruppo=$id_gruppo&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;min=$prev\">";
              		echo "<b>$offset "._PREV_MATCH."</b></a></td>";
      		}

      		$next=$min+$offset;
      		if ($next>=($offset-1)) {
        		if($next>=$max) $next = $max;
	  		else {
 	             		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=gruppo&amp;id_gruppo=$id_gruppo&amp;id_cons_gen=$id_cons_gen&amp;min=$next\">";
              			echo "<b>$offset "._NEXT_MATCH."</b></a></td>";
        		}
      		}
     		echo "</tr></table><br>";

	}

//***********************************************************
//Funzione di inserimento e gestione dei gruppi
//************************************************************

function gruppo($ok, $do,$id_gruppo,$num_gruppo,$descr_gruppo, $simbolo,$id_circ) {
	global $prefix, $dbi, $id_cons,$simbolo2,$genere,$id_cons_gen,$id_comune,$min;
	$aid=$_SESSION['aid'];
	$perms=ChiSei($id_cons_gen);
	if ($perms >16) {
       	if ($do == "delete") {  
     			if ($ok !="1") {
				ele();
				echo "<center><br><br>"._DOMCANCELLA." "._GRUPPO." $descr_gruppo ?<br>";
				echo "[ <a href=\"admin.php?op=gruppo&amp;id_cons_gen=$id_cons_gen&amp;id_circ=$id_circ\">"._NO."</a> ] - [<a href=\"admin.php?op=gruppo&amp;do=delete&amp;id_gruppo=$id_gruppo&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;ok=1\">"._YES."</a> ]";exit;
     			}else{
				$result = mysql_query("delete from ".$prefix."_ele_gruppo where id_gruppo='$id_gruppo'", $dbi);
          			if (!$result) return;
				Header("Location: admin.php?op=gruppo&id_cons_gen=$id_cons_gen&id_circ=$id_circ&min=$min");
			}
      		} elseif ($do == "add") {
      			if ($descr_gruppo) {
				$stemmablob='';
				$stemmanome='';
				$STEMM=$_FILES['stemma'];
				$filestemma=$STEMM['tmp_name'];
				$nomestemma=$STEMM['name'];
				$sqlset='';
				if ($filestemma){
					$fdstemma = fopen ("$filestemma", "rb");
					$stemmacontents = fread ($fdstemma, filesize ("$filestemma"));
					fclose ($fdstemma);
					$stemmablob=addslashes($stemmacontents);
					$stemmanome=addslashes($nomestemma);
				}
      				$result = mysql_query("insert into ".$prefix."_ele_gruppo (id_cons,id_gruppo,num_gruppo,descrizione,simbolo,stemma,id_circ) values ('$id_cons','$id_gruppo','$num_gruppo','$descr_gruppo','$stemmanome','$stemmablob','$id_circ')", $dbi);
           			if (!$result) return;
           			Header("Location: admin.php?op=gruppo&id_cons_gen=$id_cons_gen&id_circ=$id_circ&min=$min");
     			} else {
        			ele();
        			OpenTable();
				echo "<center>"._GESTIONE." "._GRUPPO." ";
        			echo "<br><br><a href=\"admin.php?op=gruppo&amp;id_cons_gen=$id_cons_gen\">"._IMM." "._GRUPPO."</a></center>";
				CloseTable();
     			}
   		} elseif ($do == "update") {
			$stemmablob='';
			$stemmanome='';
			$STEMM=$_FILES['stemma'];
			$filestemma=$STEMM['tmp_name'];
			$nomestemma=$STEMM['name'];
			$sqlset='';
			if ($filestemma){
				$fdstemma = fopen ("$filestemma", "rb");
				$stemmacontents = fread ($fdstemma, filesize ("$filestemma"));
				fclose ($fdstemma);
				$stemmablob=addslashes($stemmacontents);
				$stemmanome=addslashes($nomestemma);
				$cond=", simbolo='$stemmanome', stemma='$stemmablob'";
			} else {$cond='';}
         		$result = mysql_query("update  ".$prefix."_ele_gruppo set num_gruppo='$num_gruppo' , descrizione='$descr_gruppo' $cond where id_gruppo='$id_gruppo' ", $dbi) || die("Errore di aggiornamento dei dati!".mysql_error());
			Header("Location: admin.php?op=gruppo&id_cons_gen=$id_cons_gen&id_circ=$id_circ&min=$min");
   		}

	}
}

if ($do and $do!="modify")
	gruppo($ok, $do,$id_gruppo,$num_gruppo,$descr_gruppo,$simbolo, $id_circ);
ele();
all();
echo"</td></tr></table>";
include("footer.php");




?>
