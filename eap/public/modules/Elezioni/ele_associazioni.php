<?php 

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Autorizzazione Comuni                                         */
/* Amministrazione                                                      */
/************************************************************************/
# e' l'unico file in cui è presente un controllo su tipo_cons, per ora va bene così. Per toglierlo va inserito un campo-flag in ele_tipo per indicare se per il tipo di consultazione si dovra' procedere al calcolo dell'assegnazione dei seggi
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$id_comune=$_SESSION['id_comune'];
$id_cons_gen=intval($_GET['id_cons_gen']);
$perms=ChiSei(0);
if ($perms<128 or !$id_cons_gen) die("$perms Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$res = mysql_query("SELECT t1.tipo_cons,t1.descrizione,t2.id_cons,t2.id_conf FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_comune='$id_comune' " , $dbi);
list($tipo_cons,$descr_cons,$id_cons,$id_conf) = mysql_fetch_row($res);

$res = mysql_query("SELECT genere FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons' " , $dbi);
	list($genere) = mysql_fetch_row($res);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
if (isset($_GET['descr_comu'])) get_magic_quotes_gpc() ? $descr_comu=$param['descr_comu']:$descr_comu=addslashes($param['descr_comu']); else $descr_comu='';
if (isset($_GET['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($_GET['ok'])) $ok=intval($_GET['ok']); else $ok='';
if (isset($_GET['id_cons_comu'])) $id_cons_comu=intval($_GET['id_cons_comu']); else $id_cons_comu='';
if (isset($_GET['id_collegio'])) $id_collegio=intval($_GET['id_collegio']); else $id_collegio='';
if (isset($_GET['idcomune'])) $idcomune=intval($_GET['idcomune']); else $idcomune='';
if (isset($_GET['idcomunenew'])) $idcomunenew=intval($_GET['idcomunenew']); else $idcomunenew='';
if (isset($_GET['chiusa'])) $chiusa=intval($_GET['chiusa']); else $chiusa='';
if (isset($_GET['id_conf'])) $id_conf=intval($_GET['id_conf']);  else $id_conf=0;
if (isset($_GET['min'])) $min=intval($_GET['min']); else $min=0;
if (isset($_GET['help'])) $help=intval($_GET['help']);

$offset=15;
$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";


	/******************************************************/
	/*Funzione di visualizzazione globale                 */
	/*****************************************************/
	//
	function all() {
	global $user, $admin, $bgcolor1, $bgcolor2, $prefix,$descr_cons, $dbi,$id_cons,$desc,$indirizzo,$centralino,$fax,$id_cons_gen,$id_collegio,$idcomune,$chiusa,$id_conf,$tipo_cons,$language,$help;
$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
############# Controllo flag per cancellazione consultazione
	echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n"
	."//-->\n";
	echo "function del_cons() {\n";
	echo "if (document.model.pwd3.checked==false) {\n";
	echo "document.model.chiusa.options[3].selected=false \n";
	echo "} \n";
	echo "if (document.model.chiusa.options[3].selected==false) {
	 \n";
	echo "document.model.add.value=\""._MODIFY."\" \n";
	echo "document.model.do.value=\"update\" \n";
	echo "}else{\n";
	echo "document.model.add.value=\""._DELETE." "._CONSULTA."\" \n";
	echo "document.model.do.value=\"delete\" \n";
	echo "} \n";	
	echo "} \n";
	echo "</script>\n";
#########################
	if (isset($help)) include("language/$language/ele_associazioni.html");
	OpenTable();
	echo "<tr><td><hr><br>";	
	$res = mysql_query("SELECT descrizione FROM ".$prefix."_ele_consultazione where id_cons_gen='$id_cons_gen'" , $dbi);
	list ($descr_cons) = mysql_fetch_row($res);
//inserire avviso su mancanza dei permessi
	echo "<form name=\"model\" action=\"admin.php\">";
	echo "<table width=\"100%\" border=\"3\">";
	echo "<tr align=\"center\"><td bgcolor=\"$bgcolor1\"><b>"._CONSULTA."</b></td>";
#	echo "<td bgcolor=\"$bgcolor1\"><b>"._COLLEGI."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._DEFCOMUNE."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._STATO."</b></td><td bgcolor=\"$bgcolor1\">";
	if($tipo_cons==3)
		echo "<b>"._CONF."</b>";
	echo "<input type=\"hidden\" name=\"op\" value=\"associazioni\">";
#	echo "<input type=\"hidden\" name=\"pag_cons\" value=\"admin.php?op=associazioni&amp;id_cons_gen=\">";
	echo "</td></tr>";
	echo "<tr align=\"center\"><td>";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">$descr_cons</td>";
#	$ressede = mysql_query("SELECT id_collegio, descrizione from ".$prefix."_ele_collegi where id_cons_gen='$id_cons_gen' order by descrizione desc", $dbi);
#	if ($num_coll=mysql_num_rows($ressede)){
#		echo "<td><select name=\"id_collegio\">";
#		while(list($id,$descr_coll)=mysql_fetch_row($ressede)){
#			$sel= ($id == $id_collegio) ? "selected":"";
#			echo "<option value=\"$id\" $sel>$descr_coll";
#		}
#		echo "</select></td>";
#	} else echo "<td></td>";
	$rescomu = mysql_query("SELECT id_comune, descrizione from ".$prefix."_ele_comuni order by descrizione asc", $dbi);
	echo "<td>";
	if($idcomune) {
		while ($listele=mysql_fetch_array($rescomu))
			if($listele['id_comune']==$idcomune) {
				echo $listele['descrizione'];
				echo "<input type=\"hidden\" name=\"idcomunenew\" value=\"$idcomune\">";
			}
		
	}else{
	echo "<select name=\"idcomunenew\">";
	echo "<option value=\"0\"> ";
	while(list($id,$descr_comu)=mysql_fetch_row($rescomu)){
		$sel= ($id == $idcomune) ? "selected":"";
		echo "<option value=\"$id\" $sel>$descr_comu";
	}
	echo "</select>";
	}
	echo "</td>";
	$selez['0']='';
	$selez['1']='';
	$selez['2']='';
	$selez['3']='';
	$selez[$chiusa]="selected";
	echo "<td><select name=\"chiusa\" onChange=\"del_cons()\">";
		echo "<option value=\"0\" ".$selez[0].">"._ATTIVA;
		echo "<option value=\"1\" ".$selez[1].">"._CHIUSA;
		echo "<option value=\"2\" ".$selez[2].">"._NULLA;

		if($idcomune) echo "<option value=\"3\" ".$selez[3].">"._ELIMINA;
	echo "</select></td>";
	if($tipo_cons==3){
		$rescomu = mysql_query("SELECT id_conf, descrizione from ".$prefix."_ele_conf order by descrizione asc", $dbi);
		echo "<td><select name=\"id_conf\">";
		echo "<option value=\"0\"> ";
		while(list($id,$descr_conf)=mysql_fetch_row($rescomu)){
			$sel='';
			if ($idcomune and $id == $id_conf) $sel="selected"; elseif ($id==1) $sel="selected";
			echo "<option value=\"$id\" $sel>$descr_conf";
		}
		echo "</select></td>";
	}
	unset($sel);
	echo "<td><input type=\"hidden\" name=\"ok\" value=0>";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	if ($idcomune) {
		echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
		echo "<input type=\"hidden\" name=\"idcomune\" value=\"$idcomune\">";
		echo "<input type=\"submit\" name=\"add\" value=\""._MODIFY."\" ></td></tr>";
		echo "<tr><td colspan=\"4\"><fieldset><legend>Abilita la cancellazione</legend><label id=\"prov\">"._SPUNTAELIMINA." <input type=\"checkbox\" name=\"pwd3\" value=\"\" onchange=\"del_cons()\"></label></fieldset>";
	}else{
		echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
		echo "<input type=\"submit\" name=\"add\" value=\""._ADD."\">";
	}
	$i=0;
	echo "</td></tr></table></form>";
############
	echo "<hr><br><table width=\"100%\" border=\"3\">";
	echo "<tr align=\"center\"><td width=\"25%\" bgcolor=\"$bgcolor1\"><b>"._CONSULTA."</b></td>";
#	echo "<td bgcolor=\"$bgcolor1\"><b>"._COLLEGI."</b></td>";
	echo "<td width=\"25%\" bgcolor=\"$bgcolor1\"><b>"._DEFCOMUNE."</b></td>";
	echo "<td width=\"15%\" bgcolor=\"$bgcolor1\"><b>"._STATO."</b></td>";
	if($tipo_cons==3)
		echo "<td bgcolor=\"$bgcolor1\"><b>"._CONF."</b></td>";
	echo "<td></td></tr>";
###############

#	if ($num_coll>0)
#	$resmod = mysql_query("SELECT t1.id_collegio,t1.id_comune,t2.descrizione as descr,t1.id_cons, t3.descrizione, t4.chiusa,t4.id_conf FROM ".$prefix."_ele_comu_collegi as t1, ".$prefix."_ele_collegi as t2, ".$prefix."_ele_comuni as t3, ".$prefix."_ele_cons_comune as t4 where t1.id_cons_gen='$id_cons_gen' and t1.id_collegio=t2.id_collegio and t1.id_comune=t3.id_comune and t1.id_comune=t4.id_comune and t2.id_cons_gen=t4.id_cons_gen order by t2.descrizione, t3.descrizione", $dbi);
#	else
	$resmod = mysql_query("SELECT '',t1.id_comune,'',t1.id_cons, t2.descrizione, t1.chiusa, t1.id_conf FROM ".$prefix."_ele_cons_comune as t1, ".$prefix."_ele_comuni as t2 where t1.id_cons_gen='$id_cons_gen' and t1.id_comune=t2.id_comune order by t2.descrizione", $dbi);
	while (list($id_collegio,$id_comune2,$descr_coll,$id_cons_comu,$descr_comu, $chiusa,$id_conf) = mysql_fetch_row($resmod)){ //elenco dei modelli inseriti
		$resconf = mysql_query("SELECT descrizione FROM ".$prefix."_ele_conf where id_conf='$id_conf'", $dbi);
		list($descr_conf) = mysql_fetch_row($resconf);
		$i++;
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		echo "<tr><td colspan=\"5\">";
		echo "<form name=\"modello$i\" action=\"admin.php\">"
			."<input type=\"hidden\" name=\"op\" value=\"associazioni\">";
//		echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
#		echo "<input type=\"hidden\" name=\"id_collegio\" value=\"$id_collegio\">";
		echo "<input type=\"hidden\" name=\"idcomune\" value=\"$id_comune2\">";
		echo "<input type=\"hidden\" name=\"id_cons_comu\" value=\"$id_cons_comu\">";
		echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
		echo "<input type=\"hidden\" name=\"desc\" value=\"$descr_cons\">";
		echo "<input type=\"hidden\" name=\"chiusa\" value=\"$chiusa\">";
		echo "<table width=\"100%\"><tr align=\"center\" bgcolor=\"$bgcolor1\">";
		echo "<td width=\"25%\"><b>$descr_coll</b></td>";
		echo "<td width=\"25%\"><b>$descr_comu</b></td>";
		$stato['0']=_ATTIVA;
		$stato['1']=_CHIUSA;
		$stato['2']=_NULLA;
		echo "<td  width=\"15%\"><b>".$stato[$chiusa]."</b></td>";
		if($tipo_cons==3)
			echo "<td  width=\"25%\"><input type=\"hidden\" name=\"id_conf\" value=\"$id_conf\"><b>".$descr_conf."</b></td>";
		echo "<td width=\"10\"><input type=\"hidden\" name=\"ok\" value=0><input type=\"submit\" name=\"edit$i\" value=\""._EDIT."\">"
			."</td></tr></table></form></td></tr>\n";
	}
		echo "</table></td></tr>";
		echo "</table></td></tr>";
	CloseTable();
	echo "</div>";
	}

function associazioni($ok, $do,$descr_comu,$id_cons_comu,$id_collegio,$id_comune,$chiusa,$id_conf) {
	global $admin, $bgcolor1, $bgcolor2, $prefix, $dbi, $descr_cons,$genere,$id_cons_gen,$idcomunenew;
	$delcons=0;
	if ($do !="" and $id_cons_gen>0 and $idcomunenew>0) {
		$rescomu = mysql_query("SELECT id_cons from ".$prefix."_ele_cons_comune where id_cons_gen='$id_cons_gen' and id_comune='$idcomunenew'", $dbi); 
		$max = mysql_num_rows($rescomu); //esiste autorizzazione?
			list($delcons)=mysql_fetch_row($rescomu);
			if (!$max){			//se no la inserisce
			$result = mysql_query("insert into ".$prefix."_ele_cons_comune (chiusa,id_comune,id_cons_gen,id_conf) values ('0','$idcomunenew','$id_cons_gen','$id_conf')", $dbi) || die("<br><br>Errore di inserimento: ".mysql_error());
			$rescomu = mysql_query("SELECT id_cons from ".$prefix."_ele_cons_comune where id_cons_gen='$id_cons_gen' and id_comune='$idcomunenew'", $dbi);
		}
		list($id_cons_comu)=mysql_fetch_row($rescomu);
		if ($do == "update") {
			if ($idcomunenew>0) $newid=", id_comune = $idcomunenew ";
			else $newid='';
			$result = mysql_query("update ".$prefix."_ele_comu_collegi set id_collegio= '$id_collegio' $newid where id_comune='$id_comune' and id_cons_gen='$id_cons_gen'", $dbi) || die(mysql_error());
			if (!$result) return;
			$result = mysql_query("update ".$prefix."_ele_cons_comune set id_conf='$id_conf', chiusa= '$chiusa' where id_comune='$id_comune' and id_cons_gen='$id_cons_gen'", $dbi)|| die(mysql_error());
			Header("Location: admin.php?op=associazioni&id_cons_gen=$id_cons_gen");
		}elseif ($do == "add") {
			if ($id_collegio)
				$result = mysql_query("insert into ".$prefix."_ele_comu_collegi (id_collegio,id_cons,id_comune,id_cons_gen) values ('$id_collegio','$id_cons_comu','$idcomunenew','$id_cons_gen')", $dbi) || die("<br><br>Errore di inserimento: ".mysql_error());
			Header("Location: admin.php?op=associazioni&id_cons_gen=$id_cons_gen");
		}elseif ($do == "delete" and $delcons>0) {
			$idcns=$delcons; 
			$res_del = mysql_query("delete from ".$prefix."_ele_voti_ref where id_cons=$idcns" ,$dbi);
			$res_del = mysql_query("delete from ".$prefix."_ele_voti_candidati where id_cons=$idcns" ,$dbi);
			$res_del = mysql_query("delete from ".$prefix."_ele_voti_lista where id_cons=$idcns" ,$dbi);
			$res_del = mysql_query("delete from ".$prefix."_ele_voti_gruppo where id_cons=$idcns" ,$dbi);
			$res_del = mysql_query("delete from ".$prefix."_ele_voti_parziale where id_cons=$idcns" ,$dbi);
			$res_del = mysql_query("delete from ".$prefix."_ele_candidati where id_cons=$idcns" ,$dbi);
			$res_del = mysql_query("delete from ".$prefix."_ele_lista where id_cons=$idcns" ,$dbi);
			$res_del = mysql_query("delete from ".$prefix."_ele_gruppo where id_cons=$idcns" ,$dbi);
			$res_del = mysql_query("delete from ".$prefix."_ele_sezioni where id_cons=$idcns" ,$dbi);
			$res_del = mysql_query("delete from ".$prefix."_ele_cons_comune where id_cons=$idcns" ,$dbi);
			
			Header("Location: admin.php?op=associazioni&id_cons_gen=$id_cons_gen");
		}
	} 
}




#	die ("do:$do - id_cons:$id_cons_comu - idcomune:$id_comune - new: $idcomunenew");
	
//****************************
// switch
//****************************
	if ($op=="associazioni"){
    		associazioni($ok, $do,$descr_comu,$id_cons_comu,$id_collegio,$idcomune,$chiusa,$id_conf);
	}
	ele();
	if (isset($_GET['id_cons_gen'])) $id_cons_gen=intval($_GET['id_cons_gen']); else $id_cons_gen='0';
	all();
	include("footer.php");

?>

