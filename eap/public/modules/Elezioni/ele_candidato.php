<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Candidati                                                    */
/* Amministrazione                                                     */
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
$id_cons_gen=$param['id_cons_gen'];
$perms=ChiSei($id_cons_gen);
if ($perms<32 or !$id_cons_gen) die("$id_cons_gen -Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune' " , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);
$res = mysql_query("SELECT genere FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons' " , $dbi);
	list($genere) = mysql_fetch_row($res);
include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");

if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['ok'])) get_magic_quotes_gpc() ? $ok=$param['ok']:$ok=addslashes($param['ok']); else $ok='';
if (isset($param['id_lista'])) $id_lista=intval($param['id_lista']); else $id_lista='';
if (isset($param['id_sez'])) $id_sez=intval($param['id_sez']); else $id_sez='';
if (isset($param['id_circ'])) {$id_circ=intval($param['id_circ']); $_SESSION['id_circ']=$id_circ;} else
	if (isset($_SESSION['id_circ'])) $id_circ=intval($_SESSION['id_circ']); else $id_circ='';
if (isset($param['id_gruppo'])) $id_gruppo=intval($param['id_gruppo']); else $id_gruppo='';
if (isset($param['id_cand'])) $id_cand=intval($param['id_cand']); else $id_cand='';
if (isset($param['id_cand2'])) $id_cand2=intval($param['id_cand2']); else $id_cand2='';
if (isset($param['num_lista'])) $num_lista=intval($param['num_lista']); else $num_lista='';
if (isset($param['cognome'])) get_magic_quotes_gpc() ? $cognome=$param['cognome']:$cognome=addslashes($param['cognome']); else $cognome='';
if (isset($param['simbolo'])) get_magic_quotes_gpc() ? $simbolo=$param['simbolo']:$simbolo=addslashes($param['simbolo']); else $simbolo='';
if (isset($param['nome'])) get_magic_quotes_gpc() ? $nome=$param['nome']:$nome=addslashes($param['nome']); else $nome='';
if (isset($param['note'])) get_magic_quotes_gpc() ? $note=$param['note']:$note=addslashes($param['note']); else $note='';
if (isset($param['num_cand'])) $num_cand=intval($param['num_cand']); else $num_cand=0;

// Offset - visualizza il numero di elementi per pagina
$offset=20;

/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/


function all() {
	global $param, $bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min, $tipo_cons, $id_cons,$tipo_cons,$id_lista,$genere,$id_cons_gen,$id_comune,$id_cand,$id_circ,$id_gruppo;
	$circo='';$circo2='';
	$currentlang=$_SESSION['lang'];	
	$res = mysql_query("SELECT circo FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons' and lingua='$currentlang'", $dbi);
	list($cons_circ)= mysql_fetch_row($res);
	if($cons_circ) //elezioni circoscrizionali
	{
		echo "<form name=\"circo\" action=\"admin.php\" method=\"post\">";
		echo "<br><br><table border=\"1\" width=\"50%\" ><tr bgcolor=\"$bgcolor1\"><td>"._SCEGLI_CIRCO.": </td>";
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons'", $dbi);
		echo "<input type=\"hidden\" name=\"pag\" value=\"admin.php?op=candidato&amp;id_cons_gen=$id_cons_gen&amp;id_circ=\">";
		echo "<td><select name=\"id_circ\" onChange=\"top.location.href=this.form.pag.value+this.form.id_circ.options[this.form.id_circ.selectedIndex].value;return false\">";
		echo "<option value=\"\">";
		while($arr=mysql_fetch_array($res,3)){
			if (!$id_circ) $id_circ=$arr['id_circ'];
			$sel= ($arr['id_circ'] == $id_circ) ? "selected":"";
			echo "<option value=\"".$arr['id_circ']."\" $sel>".$arr['descrizione'];
		}
		echo "</select></td></tr></table></form>";
		$circo="and id_circ='$id_circ'";	
		$circo2="and t2.id_circ='$id_circ'";	
	}	
	if($id_cand)
	{
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_candidati where id_cand='$id_cand'", $dbi);
		$pro= mysql_fetch_array($res, 3);
	}else{
	$pro['cognome']='';$pro['num_cand']='';$pro['nome']='';
	}
	if (!isset($id_lista)) {
		$res_lista=mysql_query("SELECT id_lista from ".$prefix."_ele_lista where id_cons=$id_cons $circo and num_lista=1", $dbi);
		list($id_lista)=mysql_fetch_row($res_lista);
	}
	$cond=($id_lista>0) ? "and t1.id_lista=".$id_lista :'';
	echo "<center><font class=\"title\"><br><b>"._CANDIDATO."</b></font><br><br><table border=\"0\" width=\"100%\"><tr>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._NUM."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._COGNOME."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._NOME."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._LISTA."</b></td>";

	if ($genere==3 or $genere==5) { 
		$query= "SELECT
		t1.id_cand,t1.id_lista,t1.num_cand,t1.cognome,t1.nome, t1.simbolo,
		t2.simbolo as sim_lista,t2.descrizione, t3.simbolo as sim_gruppo, t3.descrizione
		FROM ".$prefix."_ele_candidati as t1,
		".$prefix."_ele_lista as t2,
		".$prefix."_ele_gruppo as t3
		WHERE t1.id_lista=t2.id_lista
		and t2.id_gruppo=t3.id_gruppo
		and t1.id_cons=t2.id_cons
		and t1.id_cons=$id_cons $circo2
		$cond
		order by t2.num_lista, t1.num_cand
		limit $min,$offset";
	} else {
		$query= "SELECT
		t1.id_cand,t1.id_lista,t1.num_cand,t1.cognome,t1.nome, t1.simbolo,
		t2.simbolo as sim_lista,t2.descrizione, '', ''
		FROM ".$prefix."_ele_candidati as t1,
		".$prefix."_ele_lista as t2
		WHERE t1.id_cons=$id_cons
		and t1.id_cons=t2.id_cons
		and t1.id_lista=t2.id_lista $circo2
		$cond
		order by t2.num_lista,t1.num_cand 
		limit $min,$offset";
	}
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FUNZIONI."</b></td></tr>";
	$result = mysql_query($query, $dbi);
	if($cons_circ)
		$res = mysql_query("SELECT count(0) FROM ".$prefix."_ele_candidati as t1,".$prefix."_ele_lista as t2 where t1.id_cons='$id_cons' and t1.id_cons=t2.id_cons and t2.id_circ=$id_circ and t1.id_lista=t2.id_lista $cond ", $dbi);
	else
		$res = mysql_query("SELECT count(0) FROM ".$prefix."_ele_candidati as t1 where t1.id_cons='$id_cons' $cond ", $dbi);
	list($max) = mysql_fetch_row($res);
	if($id_lista){
		$numero=$max+1;} else $numero='';
	//-----------------------lo stemma e la circoscrizione devono essere associati alla lista -
	echo "<form name=\"candidato2\" action=\"admin.php\">"
	."<input type=\"hidden\" name=\"op\" value=\"candidato\">";
	if ($pro['cognome']) {
		echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
		echo "<tr><td><input type=\"text\" name=\"num_cand\" value=\"".$pro['num_cand']."\" size=\"5\"></td>";
	}else{
		echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
		echo "<tr><td><input type=\"text\" name=\"num_cand\" value=\"$numero\" size=\"5\"></td>";
	}
	echo "<td><input type=\"text\" name=\"cognome\" maxlength=\"50\" value=\"".$pro['cognome']."\"></td>";
	echo "<td><input type=\"text\" name=\"nome\" maxlength=\"50\" value=\"".$pro['nome']."\"></td>";
	//."<td><input type=\"text\" name=\"foto\" maxlength=\"20\"></td>";
	echo "<input type=\"hidden\" name=\"pag\" value=\"admin.php?op=candidato&amp;id_cons=$id_cons&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_circ=$id_circ&amp;id_lista=\">";
	echo "<td width=\"10%\"><select width=\"10\" name=\"id_lista\" onChange=\"aggiorna()\">";
	$res= mysql_query("SELECT id_lista,num_lista,descrizione FROM ".$prefix."_ele_lista where id_cons='$id_cons' $circo order by num_lista", $dbi);
	echo "<option value=\"\">";
	while(list($id,$numlist,$descr) = mysql_fetch_row($res)) {
		if (!isset($id_lista)){$id_lista=$id;}
		$sel= ($id == $id_lista) ? "selected":"";
		echo "<option width=\"10\" value=\"$id\" $sel>".$numlist.") ".$descr;
#		echo "<option width=\"10\" value=\"$id\" $sel>".$numlist.") ".substr($descr,0,25);
	}
    	echo "</select></td>";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">";
	echo "<input type=\"hidden\" name=\"min\" value=\"$min\">";
	if ($pro['cognome']) {
	echo "<td align=\"center\"><input type=\"submit\" name=\"update\" value=\""._MODIFY."\"></td>";
	echo "<input type=\"hidden\" name=\"id_cand\" value=\"".$pro['id_cand']."\">";
	}else{
	echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td>";
	echo "<input type=\"hidden\" name=\"id_cand\" value=\"$id_cand\">";
	}
	echo "</form>";
 	echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n"
	."document.candidato2.cognome.focus()\n"
	."//-->\n";
	echo "function vai_a() {\n";
	echo "window.document.location.href=document.candidato2.pag.value+document.candidato2.id_lista.value\n";
	echo "}\n";
	echo "function aggiorna(id_ele) {\n";
	echo "if (document.candidato2.cognome.value==\"\") {vai_a()}\n";
	echo "}\n";
	echo "</script>\n";
	if ($result)
	while(list($id_cand,$id_lista2,$num_cand,$cognome, $nome,$simbolo,$simb_lista,
	$descr_lista,$simb_gruppo,$descr_gruppo) = mysql_fetch_row($result)) {
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		echo "<tr bgcolor=\"$bgcolor1\"><td align=\"center\"><b>$num_cand</b>"
		."</td><td align=\"left\"><b>$cognome</b>"
		."</td><td align=\"left\"><b>$nome</b>";
		echo "</td><td align=\"center\"><b>$descr_lista  </b>";
		echo "</td><td align=\"center\" nowrap>[<a
		href=\"admin.php?op=candidato&amp;do=modify&amp;id_cand=$id_cand&amp;id_circ=$id_circ&amp;id_lista=$id_lista2&amp;id_gruppo=$id_gruppo&amp;id_cons_gen=$id_cons_gen&amp;min=$min\"><img src=\"modules/Elezioni/images/edit.gif\"
              border=\"0\" align=\"center\"> "._EDIT."</a>]";
		echo "[<a href=\"admin.php?op=candidato&amp;do=delete&amp;id_cand=$id_cand&amp;id_circ=$id_circ&amp;id_lista=$id_lista2&amp;id_gruppo=$id_gruppo&amp;cognome=$cognome&amp;nome=$nome&amp;id_cons_gen=$id_cons_gen&amp;min=$min\">"._DELETE." <img src=\"modules/Elezioni/images/delete.gif\"
              border=\"0\" align=\"center\"></a>]";
	    	echo "</td></tr>";
	}
	echo "</table></center>";
 
	#'Pagina precedente' e 'Pagina Successiva'
	echo"<table align=\"center\" width=\"100%\" ><tr>";
	$prev=$min-$offset;
	if ($prev>=0) {
			echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=candidato&amp;id_cand=$id_cand&amp;id_gruppo=$id_gruppo&amp;id_cons=$id_cons&amp;id_circ=$id_circ&amp;id_lista=$id_lista&amp;min=$prev&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune\">";
			echo "<b>$offset "._PREV_MATCH."</b></a></td>";
	}

	$next=$min+$offset;
	if ($next>=($offset-1)) {
		if($next>=$max) $next = $max;
	else {

			echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=candidato&amp;id_cand=$id_cand&amp;id_gruppo=$id_gruppo&amp;id_cons=$id_cons&amp;id_lista=$id_lista&amp;min=$next&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune\">";
			echo "<b>$offset "._NEXT_MATCH."</b></a></td>";
		}
	}
	echo "</tr></table><br>";

}

////////////////////////////////////////////////////////
// Aggiunge candidato
////////////////////////////////////////////////////////


function candidato($ok, $do,$id_cand, $id_lista,$id_circ, $id_gruppo,$cognome, $nome, $note, $simbolo,$id_cand2,$num_cand) {
	global $param, $bgcolor1, $bgcolor2, $prefix, $dbi, $descr_cons, $id_cons,$simbolo2,$min,$id_cons_gen,$id_comune,$id_sez;
$aid=$_SESSION['aid'];
$perms=ChiSei($id_cons_gen);
if ($perms >16) {
		if($id_cand) {
			$res = mysql_query("SELECT * FROM ".$prefix."_ele_candidati where id_cand='$id_cand'", $dbi);
		}else{
			$res = mysql_query("SELECT * FROM ".$prefix."_ele_candidati where id_lista='$id_lista'
			and id_cons=$id_cons and cognome=$cognome and nome=$nome", $dbi);
		}
		$username=$aid;
		$data=date("Y/m/d");
		$tempo=date("H:i:s");

    		if ($do == "delete") {
			if ($ok !="1") {
				ele();
				echo "<center><br><br>"._DOMCANCELLA." "._CANDIDATO." $cognome $nome ?<br>";
				echo "[ <a href=\"admin.php?op=candidato&amp;id_cons_gen=$id_cons_gen\">"._NO."</a> ] - [<a href=\"admin.php?op=candidato&amp;do=delete&amp;id_cand=$id_cand&amp;id_gruppo=$id_gruppo&amp;id_cons=$id_cons&amp;id_circ=$id_circ&amp;ok=1&amp;id_cons_gen=$id_cons_gen&amp;id_lista=$id_lista&amp;id_comune=$id_comune\">"._YES."</a> ]";
 	    		}else{
				$pro= mysql_fetch_array($res, MYSQL_ASSOC);
				$result = mysql_query("delete from ".$prefix."_ele_candidati where id_cand='$id_cand'", $dbi);
				mysql_query("insert into ".$prefix."_ele_log values ('$id_cons','$id_sez','$username','$data','$tempo','DELETE:id_lista:$pro[id_lista],cognome:$pro[cognome],nome:$pro[nome]','','".$prefix."_ele_candidati')", $dbi);
				if (!$result)return;
				Header("Location: admin.php?op=candidato&id_cons=$id_cons&id_cons_gen=$id_cons_gen&id_comune=$id_comune&id_circ=$id_circ&id_lista=$id_lista");
			}
		}elseif ($do == "add") {
			if ($cognome) {
		// dati gruppo
				if (!$num_cand){
					$result = mysql_query("select max(num_cand) from ".$prefix."_ele_candidati where id_lista='$id_lista'", $dbi);
					if ($result) list($num_cand)=mysql_fetch_row($result);
					else $num_cand=0;
					$num_cand++;
				}
				$result = mysql_query("select id_gruppo from ".$prefix."_ele_lista where id_lista='$id_lista'", $dbi);
				list($id_gruppo)=mysql_fetch_row($result);
				$result = mysql_query("insert into ".$prefix."_ele_candidati(id_cons,id_lista,cognome,nome,note,simbolo,num_cand) values ('$id_cons','$id_lista','$cognome','$nome','$note','$simbolo','$num_cand')", $dbi);
				mysql_query("insert into ".$prefix."_ele_log values ('$id_cons','$id_sez','$username','$data','$tempo','','ADD:id_lista:$id_lista,cognome:$cognome,nome:$nome','".$prefix."_ele_candidati')", $dbi);
					if (!$result) return;
					Header("Location: admin.php?op=candidato&id_cons=$id_cons&id_lista=$id_lista&id_cons_gen=$id_cons_gen&id_comune=$id_comune&id_circ=$id_circ");
			} else {
				ele();
				OpenTable();
				echo "<center>"._GESTIONE." "._CANDIDATO." ";
				echo "<br><br><a href=\"admin.php?op=candidato&amp;id_cons=$id_cons&amp;id_lista=$id_lista&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_circ=$id_circ\">"._IMM." "._CANDIDATO."</a></center>";
				CloseTable();exit;
			}
		}elseif ($do == "update") {
		
		$pro= mysql_fetch_array($res, MYSQL_ASSOC);
		$result = mysql_query("select id_gruppo from ".$prefix."_ele_lista where id_lista='$id_lista'", $dbi);
		list($id_gruppo)=mysql_fetch_row($result);
		$cond='';
		if (isset($note)) {$cond=", note='$note'";}
		if (isset($simbolo)) {$cond.=", simbolo='$simbolo'";}
		$result = mysql_query("update  ".$prefix."_ele_candidati set id_lista='$id_lista', cognome='$cognome', nome='$nome', num_cand='$num_cand' $cond where id_cand='$id_cand' ", $dbi);
		mysql_query("insert into ".$prefix."_ele_log values ('$id_cons','$id_sez','$username','$data','$tempo','UPDATE:id_lista:$pro[id_lista],cognome:$pro[cognome],nome:$pro[nome],num_cand:$pro[num_cand]','id_lista:$id_lista,cognome:$cognome,nome:$nome,num_cand:$num_cand','".$prefix."_ele_candidati')", $dbi);
		if (!$result) return;
		Header("Location: admin.php?op=candidato&id_cons=$id_cons&id_lista=$id_lista&id_cons_gen=$id_cons_gen&id_comune=$id_comune&id_circ=$id_circ");
	}

}
}



if ($do and $do!='modify')
    candidato($ok, $do,$id_cand, $id_lista,$id_circ, $id_gruppo,$cognome, $nome, $note, $simbolo,$id_cand2,$num_cand);
    else ele();
//if (!$do)ele();
all();
echo"</td></tr></table>";
include("footer.php");

?>
