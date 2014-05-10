<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo definiione consultazione                                      */
/* Amministrazione                                                      */
/************************************************************************/
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
if($param)
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$vari= implode(',',$param);
$id_cons_gen=$_GET['id_cons_gen'];
$id_comune=$_SESSION['id_comune'];
$perms=ChiSei(0);
if ($perms<64 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$res = mysql_query("SELECT tipo_cons,descrizione FROM ".$prefix."_ele_consultazione where id_cons_gen='$id_cons_gen' " , $dbi);
list($tipo_cons,$descr_cons) = mysql_fetch_row($res);
include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['ok'])) get_magic_quotes_gpc() ? $ok=$param['ok']:$ok=addslashes($param['ok']); else $ok='';
if (isset($param['id_cons2'])) $id_cons2=intval($param['id_cons2']); else $id_cons2='';
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['duplica'])) $duplica=intval($param['duplica']); else $duplica='';
if (isset($param['elettori'])) get_magic_quotes_gpc() ? $elettori=$param['elettori']:$elettori=addslashes($param['elettori']); else $elettori='';
if (isset($param['predefinita'])) $predefinita=intval($param['predefinita']); else $predefinita='';
if (isset($param['help'])) $help=intval($param['help']);

$offset=10;
$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";


/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/

function all() {
global $bgcolor1, $bgcolor2,  $bgcolor6, $prefix, $dbi, $offset, $min, $id_cons,$id_cons2, $id_comune,$descr_cons,$id_cons_gen,$perms,$language,$help;

	if (isset($help)) include("language/$language/ele_cons_comuni.html");

	$res = mysql_query("SELECT id_cons FROM ".$prefix."_ele_comuni where id_comune=$id_comune", $dbi);
	if (isset($res)) list($idpred) = mysql_fetch_row($res); else $idpred='';
	$res = mysql_query("SELECT t1.id_cons, t2.descrizione FROM ".$prefix."_ele_cons_comune as t1 left join ".$prefix."_ele_consultazione as t2 on t1.id_cons_gen=t2.id_cons_gen where t1.id_comune='$id_comune' " , $dbi);
	$max = mysql_num_rows($res);
	echo "<table border=\"0\" width=\"100%\" align=\"left\"><tr><td>";
	echo "<form name=\"imppred\" action=\"admin.php\">";
	echo "<table style=\"color: #000000;\"><tr><td bgcolor=\"$bgcolor1\">"
   	."&nbsp;<b>"._CONSPRED."</b>&nbsp;</td><td><select name=\"predefinita\">";
	echo "<option value=\"\">";
	while($arr=mysql_fetch_array($res,3)){
		$sel='';
		if (($idpred))
			$sel= ($arr['id_cons'] == $idpred) ? "selected":"";
		echo "<option value=\"".$arr['id_cons']."\" $sel>".$arr['descrizione'];
		}
	echo "</select></td><td>";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<input type=\"hidden\" name=\"op\" value=\"cons_comuni\">";
	echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
	echo "<input type=\"submit\" name=\"add\" value=\""._OK."\"></td>";
	echo "</tr></table></form></td></tr></table><hr>";

	echo "<center><font class=\"title\"><b><BR>"._COPIA." "._LA." "._STRUTTURA." "._DA." $descr_cons</b></font><br><br><table border=\"0\" width=\"100%\">"
   	."<tr><td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<b>"._DESCR."</b>&nbsp;</td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<b>"._DATAIN."</b>&nbsp;</td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._DATAFINE."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._COPIA." "._NUM." "._ELETTORI."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FUNZIONI."</b></td></tr>";
	$result = mysql_query("select t2.chiusa,t2.id_cons,t1.* from ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2, ".$prefix."_ele_tipo as t3 where t1.tipo_cons=t3.tipo_cons and t2.id_comune='$id_comune' and t1.id_cons_gen=t2.id_cons_gen and t2.id_cons!=$id_cons ORDER BY data_fine desc LIMIT $min,$offset", $dbi);
	$i=0;
	while(list($chiusa,$id_cons2,$idconsgen2, $descr_cons, $data_inizio, $data_fine,$tipo) = mysql_fetch_row($result)) {
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		$ressez = mysql_query("select count(id_cons) from ".$prefix."_ele_sezioni where id_cons='$id_cons2'", $dbi);
		list($somma)=mysql_fetch_row($ressez);
		$data_inizio=form_data($data_inizio);$data_fine=form_data($data_fine);
		echo "<tr bgcolor=\"$bgcolor1\" align=\"center\" ><td align=\"left\" ><a href=\"admin.php?op=cons_comuni&amp;id_cons_gen=$idconsgen2\"><b>$descr_cons</b></a></td>"
		."<td>$data_inizio</td>"
		."<td>$data_fine</td>";
		if ($somma==0){
			$i++;
			echo "<form name=\"scelta$i\" action=\"admin.php\">";
			echo "<td align=\"center\"><select name=\"elettori\">";
			echo "<option value=\"false\">"._NO."</option>";
			echo "<option value=\"true\">"._SI."</option>";
			echo "</select></td>";
			echo "<input type=\"hidden\" name=\"op\" value=\"cons_comuni\">";
			echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
			echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
			echo "<input type=\"hidden\" name=\"id_cons2\" value=\"$id_cons2\">";
			echo "<td align=\"center\"><input type=\"submit\" value=\""._POPOLA."\"></td>";
			echo "</form>";
		}elseif($perms==256){
			$i++;
			echo "<form name=\"scelta$i\" action=\"admin.php\">";
			echo "<td align=\"center\">Aggiorna il numero elettori</td>";
			echo "<input type=\"hidden\" name=\"op\" value=\"cons_comuni\">";
			echo "<input type=\"hidden\" name=\"do\" value=\"elettori\">";
			echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
			echo "<input type=\"hidden\" name=\"id_cons2\" value=\"$id_cons2\">";
			echo "<td align=\"center\"><input type=\"submit\" value=\""._UPDATE."\"></td>";
			echo "</form>";
		
		}
		echo "</tr>";
	}
	echo "</table></center>";
	#'Pagina precedente' e 'Pagina Successiva'
	echo "<table align=\"center\" width=\"100%\" bgcolor=\"$bgcolor1\"><tr>";
	$prev=$min-$offset;
	if ($prev>=0) {
		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor2\"><a href=\"admin.php?op=cons_comuni&amp;id_cons_gen=$id_cons_gen&amp;min=$prev\">";
		echo "<b>$offset "._PREV_MATCH."</b></a></td>";
	}
	
	$next=$min+$offset;
	if ($next>=($offset-1)) {
		if($next>=$max) $next = $max;
		else {
			echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor2\"><a href=\"admin.php?op=cons_comuni&amp;id_cons_gen=$id_cons_gen&amp;min=$next\">";
			echo "<b>$offset "._NEXT_MATCH."</b></a></td>";
		}
	}
	echo "</tr></table><br>";
}



function cons_comuni($ok, $id_cons2,$do, $duplica,$elettori) 
{
 global $prefix, $dbi,$id_comune,$id_cons_gen,$perms,$predefinita;
if ($perms>32) {
	$sql="select id_cons from ".$prefix."_ele_cons_comune where id_cons_gen='$id_cons_gen' and id_comune=$id_comune";
	$res=mysql_query("$sql",$dbi);
	list($id_consulta)=mysql_fetch_row($res);
	$sql="select t1.descrizione from ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t2.id_cons='$id_cons2' and t1.id_cons_gen=t2.id_cons_gen";
	$res=mysql_query("$sql",$dbi);
	list($descr_cons2)=mysql_fetch_row($res);
	if ($do == "add") {
		if ($id_cons2) {
			// copia circoscrizione
			$res=mysql_query("select * from ".$prefix."_ele_circoscrizione where id_cons='$id_consulta'", $dbi);
			while (list($id,$idcirc,$num,$des)=mysql_fetch_row($res)){
 $resconnew=mysql_query("select count(0) from ".$prefix."_ele_circoscrizione where id_cons='$id_cons2' and num_circ='$num'", $dbi);
list($contr_circ)=mysql_fetch_row($resconnew);
if (! $contr_circ){
				mysql_query("insert into ".$prefix."_ele_circoscrizione (id_cons,num_circ,descrizione) values ('$id_cons2',$num,'$des')", $dbi) || die("Impossibile inserire i dati delle circoscrizioni! ".mysql_error());
}
				$res0=mysql_query("select id_circ from ".$prefix."_ele_circoscrizione where id_cons=$id_cons2 and num_circ=$num", $dbi);
				list($id_circ)=mysql_fetch_row($res0);
				// copia sede
				$res1=mysql_query("select * from ".$prefix."_ele_sede where id_cons='$id_consulta' and id_circ='$idcirc'", $dbi);
				while(list($id1,$idsede1,$idcirc1,$ind,$tel,$tel2,$fax,$resp,$mappa2,$filemappa)=mysql_fetch_row($res1)){
					$mappa=addslashes($mappa2);
 $ressednew=mysql_query("select count(0) from ".$prefix."_ele_sede where id_cons='$id_cons2' and indirizzo='$ind'", $dbi);
list($contr_sed)=mysql_fetch_row($ressednew);
if (! $contr_sed){
					mysql_query("insert into ".$prefix."_ele_sede (id_cons,id_circ,indirizzo,telefono1,telefono2,fax,responsabile,mappa,filemappa) values ('$id_cons2','$id_circ','$ind','$tel','$tel2','$fax','$resp','$mappa','$filemappa')", $dbi) || die("Impossibile inserire i dati delle sedi! ".mysql_error());
}
					$res2=mysql_query("select id_sede from ".$prefix."_ele_sede where id_cons=$id_cons2 and id_circ=$id_circ and indirizzo='$ind'", $dbi);
					list($id_sede)=mysql_fetch_row($res2);
					//copia sezione
					$res3=mysql_query("select * from ".$prefix."_ele_sezioni where id_cons=$id_consulta and id_sede=$idsede1", $dbi);
					while (list($id3,$idsez3,$idsede3,$numero,$maschi3,$femmine3,$validi3,$nulli3,
						$bianchi3,$contest3,$sg3,$aut_m,$aut_f)=mysql_fetch_row($res3)){
						if ($elettori=='true') $sql="insert into ".$prefix."_ele_sezioni (id_cons,id_sede,num_sez,maschi,femmine) values ('$id_cons2','$id_sede','$numero','$maschi3','$femmine3')";
						else $sql="insert into ".$prefix."_ele_sezioni (id_cons,id_sede,num_sez) values ('$id_cons2','$id_sede','$numero')";
						mysql_query("$sql", $dbi) || die("Impossibile inserire i dati delle sezioni! ".mysql_error());
					}
				}
			}
	#		Header("Location: admin.php?op=cons_comuni&id_cons_gen=$id_cons_gen");
		}
	}
	if ($do == "elettori") {
		if ($ok !="1") {
			ele();
			echo "<center><br><br>"._DOMAGGIORNA." Consultazione $descr_cons2 ?<br>";
			echo "[ <a href=\"admin.php?op=cons_comuni&amp;id_cons_gen=$id_cons_gen\">"._NO."</a> ] - [<a href=\"admin.php?op=cons_comuni&amp;do=elettori&amp;id_cons_gen=$id_cons_gen&amp;id_cons2=$id_cons2&amp;ok=1\">"._YES."</a> ]";exit;
		}else{
		$result = mysql_query("update ".$prefix."_ele_sezioni as t1, ".$prefix."_ele_sezioni as t2 set t1.maschi=t2.maschi, t1.femmine=t2.femmine WHERE t1.id_cons=$id_cons2 and t2.id_cons=$id_consulta and t1.num_sez=t2.num_sez", $dbi);
		if (!$result) return;
		Header("Location: admin.php?op=cons_comuni&id_cons_gen=$id_cons_gen");
		}
   	} 
	if ($do == "update") {
		if ($predefinita) 
			$result = mysql_query("update  ".$prefix."_ele_comuni set  id_cons='$predefinita' WHERE id_comune='$id_comune'", $dbi);
		else
			$result = mysql_query("update  ".$prefix."_ele_cons_comune set  chiusa='$chiusa' WHERE id_cons2='$id_cons2'", $dbi);
		if (!$result) return;
		Header("Location: admin.php?op=cons_comuni&id_cons_gen=$id_cons_gen");
   	} 
}
}

function help_cons()
{
//da mettere
}

if ($do) {
	cons_comuni($ok, $id_cons2,$do, $duplica, $elettori);
}
ele();
//OpenTable();
all();
CloseTable();
include("footer.php");
?>

