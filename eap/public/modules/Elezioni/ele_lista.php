<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo lista                                                       */
/* Amministrazione                                                     */
/************************************************************************/
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

ob_start();
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=intval($param['id_cons_gen']);
$perms=ChiSei($id_cons_gen);
if ($perms<32 or !$id_cons_gen) die("$id_cons_gen -Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
if (isset($param['mex'])) get_magic_quotes_gpc() ? $mex=$param['mex']:$mex=addslashes($param['mex']); else $mex='';
if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['ok'])) get_magic_quotes_gpc() ? $ok=$param['ok']:$ok=addslashes($param['ok']); else $ok='';
if (isset($param['id_lista'])) $id_lista=intval($param['id_lista']); else $id_lista='';
if (isset($param['id_circ'])) {$id_circ=intval($param['id_circ']); $_SESSION['id_circ']=$id_circ;} else
	if (isset($_SESSION['id_circ'])) $id_circ=intval($_SESSION['id_circ']); else $id_circ='';
if (isset($param['id_gruppo'])) $id_gruppo=intval($param['id_gruppo']); else $id_gruppo='';
if (isset($param['id_gruppo2'])) $id_gruppo2=intval($param['id_gruppo2']); else $id_gruppo2='';
if (isset($param['num_lista'])) $num_lista=intval($param['num_lista']); else $num_lista='';
if (isset($param['descr_lista'])) get_magic_quotes_gpc() ? $descr_lista=$param['descr_lista']:$descr_lista=addslashes($param['descr_lista']); else $descr_lista='';
if (isset($param['simbolo'])) get_magic_quotes_gpc() ? $simbolo=$param['simbolo']:$simbolo=addslashes($param['simbolo']); else $simbolo='';
if (isset($param['stemma'])) get_magic_quotes_gpc() ? $stemma=$param['stemma']:$stemma=addslashes($param['stemma']); else $stemma='';

// Offset - visualizza il numero di elementi per pagina

$offset=15;
$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";


/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/

function all() {
    global $param,$bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min, $id_cons,$tipo_cons,$id_gruppo,$id_gruppo2,$genere,$id_cons_gen,$do,$id_circ, $mex,$descr_lista,$id_lista;
	$currentlang=$_SESSION['lang'];	
	$cur_circ=$id_circ;
	
	$circo='';
	$res = mysql_query("SELECT circo FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons'", $dbi);
#	$res = mysql_query("SELECT circo FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons' and lingua='$currentlang'", $dbi);
	list($cons_circ)= mysql_fetch_row($res);
	if($cons_circ)
	{
		echo "<form name=\"circo\" action=\"admin.php\" method=\"post\">";
		echo "<br><br><table border=\"1\" width=\"50%\" ><tr bgcolor=\"$bgcolor1\"><td>"._SCEGLI_CIRCO.": </td>";
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons'", $dbi);
		echo "<input type=\"hidden\" name=\"pag\" value=\"admin.php?op=lista&amp;id_cons_gen=$id_cons_gen&amp;id_circ=\">";
		echo "<td><select name=\"id_circ\" onChange=\"top.location.href=this.form.pag.value+this.form.id_circ.options[this.form.id_circ.selectedIndex].value;return false\">";
		echo "<option value=\"\">";
		while($arr=mysql_fetch_array($res,3)){
			if (!$id_circ) $id_circ=$arr['id_circ'];
			$sel= ($arr['id_circ'] == $id_circ) ? "selected":"";
			echo "<option value=\"".$arr['id_circ']."\" $sel>".$arr['descrizione'];
		}
		echo "</select></td></tr></table></form>";
		$circo="and id_circ='$id_circ'";	
	}
	echo "<center><font class=\"title\">";
	if ($mex) echo "<br>$mex";
	echo "<br><b>"._LISTA."</b></font><br><br><table border=\"0\" width=\"100%\"><tr>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\" width=\"5%\"><b>"._NUM."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._DESCR."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\" width=\"5%\"><b>"._SIMBOLO."</b></td>";
	if ($genere==1 or $genere==3 or $genere==5) { ###prova  
		echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._GRUPPO."</b></td>";
	}
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FUNZIONI."</b></td></tr>";
	$res = mysql_query("SELECT * FROM ".$prefix."_ele_lista where id_cons='$id_cons' $circo ", $dbi);
	$max = mysql_num_rows($res);
	$nuova_lista=$max+1;
	//-----------------------visualizza riga superiore per inserimento -
	echo "<form name=\"lista2\" enctype=\"multipart/form-data\" action=\"admin.php\" method=\"post\">"
	."<input type=\"hidden\" name=\"op\" value=\"lista\">";
	if ($do=='modify') {
	$resl = mysql_query("SELECT * FROM ".$prefix."_ele_lista where id_lista='$id_lista'", $dbi);
	$lis=mysql_fetch_array($resl);
	$nuova_lista=$lis['num_lista'];
	echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
	}else{
	$lis['id_lista']='';
	if ($descr_lista) $lis['descrizione']="$descr_lista";else $lis['descrizione']='';
	echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
	}
	//-----------------------fine visualizza riga superiore per inserimento -
	echo "
	<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">
	<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">
	<input type=\"hidden\" name=\"id_lista\" value=\"".$lis['id_lista']."\">
	<tr>
		<td><input type=\"text\" name=\"num_lista\" value=\"$nuova_lista\" size=\"5\"></td>
		<td><input type=\"text\" name=\"descr_lista\" size=\"35\" value=\"".$lis['descrizione']."\"></td>
		<td><input name=\"stemma\" type=\"file\" size=\"10\"></td>";
	
	if ($genere==1 or $genere==3 or $genere==5) ###prova
	{
		echo "
		<input type=\"hidden\" name=\"pag\" value=\"admin.php?op=lista&amp;id_circ=$id_circ&amp;id_cons_gen=$id_cons_gen&amp;id_gruppo=\">
		<td><select name=\"id_gruppo\" onChange=\"aggiorna(6)\">
		<option value=\"\">";
		
		$result1 = mysql_query("select id_gruppo, descrizione from ".$prefix."_ele_gruppo where id_cons=$id_cons $circo", $dbi);
		$id_gruppo2= ($id_gruppo2)?$id_gruppo2:$id_gruppo;
		if ($result1)
		while(list($id,$descr)=mysql_fetch_row($result1)){
			$sel= ($id == $id_gruppo2) ? "selected":"";
			echo "<option value=\"$id\" $sel>$descr";
		}
		echo "</select></td>";
	}

	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
	."<input type=\"hidden\" name=\"min\" value=\"$min\">";
	if ($do=='modify') 
		echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td>";
	else
		echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td>";
	echo "</form>";
	echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n"
		."document.lista2.descr_lista.focus()\n"
		."//-->\n";
	echo "function vai_a() {\n";
		echo "window.document.location.href=document.lista2.pag.value+document.lista2.id_gruppo.value\n";
		echo "}\n";
	echo "function aggiorna(id_ele) {\n";
		echo "if (document.lista2.elements[id_ele].value==\"\") {vai_a()}\n";
    		echo "}\n";
	echo "</script>\n";
	$grup= $id_gruppo ? "and id_gruppo='$id_gruppo'":"";
	$result = mysql_query("select count(id_lista) from ".$prefix."_ele_lista where id_cons='$id_cons' $circo", $dbi);
	list($numero) = mysql_fetch_row($result);
	$result = mysql_query("select * from ".$prefix."_ele_lista where id_cons='$id_cons' $grup $circo ORDER BY num_lista  LIMIT $min,$offset", $dbi);
	while(list($id_cons2,$id_lista,$num_lista, $id_gruppo,$id_circ, $descr_lista, $simbolo) = mysql_fetch_row($result)) {
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
        	// dati gruppo
		if ($genere==1 or $genere==3 or $genere==5){ ###prova	
		$result1 = mysql_query("select descrizione,simbolo from ".$prefix."_ele_gruppo where id_cons='$id_cons' and id_gruppo='$id_gruppo'", $dbi);
        		list($descr_gruppo,$simb_gruppo)=mysql_fetch_row($result1);
		}
		$restemp = mysql_query("select count(0) from ".$prefix."_ele_candidati where id_lista='$id_lista'", $dbi);
		list($numtemp)=mysql_fetch_row($restemp);

		echo "<tr bgcolor=\"$bgcolor1\"><td align=\"right\"><b>$num_lista</b>"
		."</td><td align=\"left\"><b>$descr_lista</b>"
		."</td><td align=\"center\"><img class=\"stemma\" src=\"admin.php?op=foto&amp;id_lista=$id_lista&amp;prefix=$prefix\"  width=\"50\">";
		if ($genere==1 or $genere==3 or $genere==5) { ###prova
			echo "</td><td align=\"left\"><b>$descr_gruppo</b></td>";
		}
		echo "<td align=\"center\" nowrap>[<a
			href=\"admin.php?op=lista&amp;do=modify&amp;id_lista=$id_lista&amp;id_gruppo2=$id_gruppo&amp;id_cons_gen=$id_cons_gen&amp;min=$min&amp;id_circ=$id_circ\"><img src=\"modules/Elezioni/images/edit.gif\"
			border=\"0\" align=\"center\"> "._EDIT."</a>]";
		if (!$numtemp)
			echo "[<a href=\"admin.php?op=lista&amp;do=delete&amp;id_lista=$id_lista&amp;id_gruppo=$id_gruppo&amp;descr_lista=$descr_lista&amp;min=$min&amp;id_cons_gen=$id_cons_gen&amp;id_circ=$id_circ\">"._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\"></a>]";
		else
			echo "["._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\">]";
                
		echo "</td></tr>";
	}
	echo "</table></center>";


      #'Pagina precedente' e 'Pagina Successiva'
      echo"<table align=\"center\" width=\"100%\" ><tr>";
      $prev=$min-$offset;
      if ($prev>=0) {
              echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=lista&amp;id_lista=$id_lista&amp;id_gruppo=$id_gruppo&amp;id_circ=$cur_circ&amp;min=$prev&amp;id_cons_gen=$id_cons_gen\">";
              echo "<b>$offset "._PREV_MATCH."</b></a></td>";
      }

	$next=$min+$offset;
	if ($next>=($offset-1)) {
		if($next>=$max) $next = $max;
		else {
	              echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=lista&amp;id_lista=$id_lista&amp;id_gruppo=$id_gruppo&amp;id_circ=$cur_circ&amp;min=$next&amp;id_cons_gen=$id_cons_gen\">";
              	echo "<b>$offset "._NEXT_MATCH."</b></a></td>";
        	}
	}
	echo "</tr></table><br>";

}

function lista($ok, $do,$id_lista, $num_lista, $id_gruppo,$id_circ, $descr_lista, $simbolo,$stemma) {
global $param,$bgcolor1, $bgcolor2, $prefix, $dbi, $descr_cons, $id_cons,$simbolo2,$tipo_cons,$min,$genere,$id_cons_gen;
$aid=$_SESSION['aid'];
$perms=ChiSei($id_cons_gen);
if ($perms >16) {
        if ($do == "delete") {
		if ($ok !="1") {
			ele();
			echo "<center><br><br>"._DOMCANCELLA." "._LISTA." $descr_lista ?<br>";
			echo "[ <a href=\"admin.php?op=lista&amp;id_cons_gen=$id_cons_gen&amp;min=$min&amp;id_circ=$id_circ\">"._NO."</a> ] - [<a href=\"admin.php?op=lista&amp;do=delete&amp;id_lista=$id_lista&amp;id_gruppo=$id_gruppo&amp;id_circ=$id_circ&amp;ok=1&amp;min=$min&amp;id_cons_gen=$id_cons_gen\">"._YES."</a> ]";exit;
		}else{
			$result = mysql_query("delete from ".$prefix."_ele_lista where id_lista='$id_lista'", $dbi);
			if (!$result)return;
			Header("Location: admin.php?op=lista&id_circ=$id_circ&id_cons_gen=$id_cons_gen");
		}
	}elseif ($do == "add") {
		if ($descr_lista and ($id_gruppo or ($genere!=3 and $genere!=5))) {
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
			$result = mysql_query("insert into ".$prefix."_ele_lista (id_cons,num_lista,id_gruppo,id_circ,descrizione,simbolo,stemma) values ('$id_cons','$num_lista','$id_gruppo','$id_circ','$descr_lista','$stemmanome','$stemmablob')", $dbi);
			if (!$result) return;
			Header("Location: admin.php?op=lista&id_circ=$id_circ&min=$min&id_cons_gen=$id_cons_gen");
		} else {
			$mex="";
			if (!$id_gruppo) $mex.="- Devi collegare la lista ad un gruppo! -";
			if (!$descr_lista) $mex.="- Devi inserire il nome della lista! -";
			Header("Location: admin.php?op=lista&id_circ=$id_circ&min=$min&id_cons_gen=$id_cons_gen&descr_lista=$descr_lista&id_gruppo=$id_gruppo&mex=$mex");
		}
	}elseif ($do == "update") {
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
		$result = mysql_query("update  ".$prefix."_ele_lista set  num_lista='$num_lista' , id_gruppo='$id_gruppo',descrizione='$descr_lista' $cond  where id_lista='$id_lista'", $dbi);
		if (!$result) return;
		Header("Location: admin.php?op=lista&id_circ=$id_circ&min=$min&id_cons_gen=$id_cons_gen");
	}


}
}







if ($do and $do!='modify')
    lista($ok, $do,$id_lista, $num_lista, $id_gruppo,$id_circ,$descr_lista, $simbolo,$stemma);
ele();
all();
echo"</td></tr></table>";
include("footer.php");

ob_end_flush();

?>
