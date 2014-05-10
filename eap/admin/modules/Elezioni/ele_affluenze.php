<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Affluenze                                                     */
/* Amministrazione                                                      */
/************************************************************************/


if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$currentlang=$_SESSION['lang'];
$id_cons_gen=$_GET['id_cons_gen'];
$perms=ChiSei(0);
if ($perms<256 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$res = mysql_query("SELECT t1.tipo_cons,t2.genere,t1.descrizione FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_tipo as t2 where t1.tipo_cons=t2.tipo_cons and t1.id_cons_gen='$id_cons_gen' " , $dbi);
list($tipo_cons,$genere,$descr_cons) = mysql_fetch_row($res);
if (isset($_GET['min'])) $min=intval($_GET['min']); else $min=0;
if (isset($_GET['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($_GET['ov'])) $ov=intval($_GET['ov']); else $ov='';
if (isset($_GET['mv'])) $mv=intval($_GET['mv']); else $mv='';
if (isset($_GET['gv'])) $gv=intval($_GET['gv']); else $gv='';
if (isset($_GET['msv'])) $msv=intval($_GET['msv']); else $msv='';
if (isset($_GET['av'])) $av=intval($_GET['av']); else $av='';
if (isset($_GET['tipo'])) get_magic_quotes_gpc() ? $tipo=$param['tipo']:$tipo=addslashes($param['tipo']); else $tipo='';
if (isset($_GET['ok'])) get_magic_quotes_gpc() ? $ok=$param['ok']:$ok=addslashes($param['ok']); else $ok='';
if (isset($_GET['modello'])) get_magic_quotes_gpc() ? $modello=$param['modello']:$modello=addslashes($param['modello']); else $modello='';
if (isset($_GET['help'])) $help=intval($_GET['help']);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
$offset=15;
$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";




	/******************************************************/
	/*Funzione di visualizzazione globale                 */
	/*****************************************************/
	//crea la pagina delle affluenze
	function all() {
		global $bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min,$id_cons_gen,$language,$help;

		if (isset($help)) include("language/$language/ele_affluenze.html");

		echo "<hr><br><br> <table border=\"0\" width=\"60%\"  align=\"center\">"
		."<tr><td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._ORA."</b></td>"
		."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._DATA."</b></td>";
#		echo "<td bgcolor=\"$bgcolor1\">&nbsp;</td>";
		echo "<td bgcolor=\"$bgcolor1\">&nbsp;</td></tr>";
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_rilaff where id_cons_gen=$id_cons_gen order by data,orario", $dbi);
		$max = mysql_num_rows($res);

		echo "<form name=\"rilaff\" action=\"admin.php\">"
			."<input type=\"hidden\" name=\"op\" value=\"rec_add_aff\">"
		."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
		."<input type=\"hidden\" name=\"do\" value=1>";
		echo "<tr align=\"center\"><td>";
		echo "<select name= \"ov\" ><option value=\"11\" selected>11</option>"; ore();
		echo "<select name= \"mv\" ><option value=\"00\" selected>00</option>"; minuti();
		echo "</td><td>";
		$aff = mysql_query("SELECT data_inizio,data_fine FROM ".$prefix."_ele_consultazione where id_cons_gen='$id_cons_gen'", $dbi);
		list($data,$fine) = mysql_fetch_row($aff);
		list ($anno,$mese,$giorno)=explode('-',$data);
		list ($annof,$mesef,$giornof)=explode('-',$fine);
		echo "<select name= \"gv\" ><option value=\"$giorno\" selected>$giorno</option>"; giorno($giorno,$giornof);
		echo "<select name= \"msv\" ><option value=\"$mese\" selected>$mese</option>"; mese();
		echo "<select name= \"av\" ><option value=\"$anno\" selected>$anno</option>"; anno() ;
		echo "</td>";

		echo "<td><input type=\"hidden\" name=\"tipo\" value=\"add\">"
		."<input type=\"submit\" name=\"update\" value=\""._ADD."\"></td></tr>";
	
		echo "</form><tr><td bgcolor=\"$bgcolor1\" colspan=\"3\">&nbsp;</td></tr>";
		if ($max != "0") {
			$i=1;
			while(list($id_cons2,$orario,$data) = mysql_fetch_row($res)){
				// esplode la data
				$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
				list($av1,$msv1,$gv1) = explode("-",$data);
				list($ov1,$mv1,$sv1) = explode(":",$orario);
				$i++;

				echo "<tr align=\"center\" bgcolor=\"$bgcolor1\">";
				echo "<td><b>$ov1,$mv1</b></td>";
				echo "<td><b>$gv1-$msv1-$av1</b></td>";
				echo "<td><form name=\"canc$i\" action=\"admin.php\">"
					."<input type=\"hidden\" name=\"op\" value=\"rec_add_aff\">";
				echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
					."<input type=\"hidden\" name=\"do\" value=2>";
				echo "<input type=\"hidden\" name=\"ov\" value=\"$ov1\">"
					."<input type=\"hidden\" name=\"mv\" value=\"$mv1\">"
					."<input type=\"hidden\" name=\"gv\" value=\"$gv1\">"
					."<input type=\"hidden\" name=\"msv\" value=\"$msv1\">"
					."<input type=\"hidden\" name=\"av\" value=\"$av1\">"
					."<input type=\"hidden\" name=\"tipo\" value=\"delete\">"
					."<input type=\"hidden\" name=\"ok\" value=0>"
					."<input type=\"submit\" name=\"erase$i\" value=\""._DELETE."\"></form></td>"
					."</tr>";
			}
		}
		echo "</table>";
	}

	// memorizza le affluenze
	function rec_add_aff($do,$ov,$mv,$gv,$msv,$av,$tipo,$ok, $modello) {
		global $prefix, $dbi,$id_cons_gen;
		$perms=ChiSei(0);
		if ($perms<256) die("Non hai i permessi per eseguire questa operazione!");
		$data="$av-$msv-$gv";
		$orario="$ov:$mv:00";
		$confr = mysql_query("SELECT data_inizio, data_fine FROM ".$prefix."_ele_consultazione WHERE id_cons_gen ='$id_cons_gen'", $dbi);
list($dadata, $adata) = mysql_fetch_row($confr);
$dadata=strtotime($dadata);
$adata=strtotime($adata);
$cdata=strtotime($data);
		// verifica se data e ora esiste e fa l'upgrade
		$res = mysql_query("select * from ".$prefix."_ele_rilaff where id_cons_gen='$id_cons_gen' and data='$data' and orario='$orario'", $dbi);
		$tipo= mysql_num_rows($res); 
		if(($tipo==0) and ($dadata <= $cdata) and ($adata >= $cdata)){
			if(checkdate(intval($msv),intval($gv),intval($av))){
			$result = mysql_query("insert into ".$prefix."_ele_rilaff values ('$id_cons_gen','$orario','$data')", $dbi)|| die("Impossibile inserire i dati! ".mysql_error());
			}
			Header("Location: admin.php?op=rec_add_aff&id_cons_gen=$id_cons_gen");
		} elseif ($do==2) {
			if ($ok !="1") {
				ele();
				OpenTable();
				echo "<center><br><br>"._DOMCANCELLA."  ?<br>";
				echo "[ <a href=\"admin.php?op=rec_add_aff&amp;id_cons_gen=$id_cons_gen\">"._NO."</a> ] - [<a href=\"admin.php?op=rec_add_aff&amp;id_cons_gen=$id_cons_gen&amp;do=$do&amp;ops=1&amp;ov=$ov&amp;mv=$mv&amp;gv=$gv&amp;msv=$msv&amp;av=$av&amp;tipo=delete&amp;ok=1\">"._YES."</a> ]";
				CloseTable();
				include("footer.php");
				die();
			}else{
				$res = mysql_query("select id_cons from ".$prefix."_ele_cons_comune where id_cons_gen='$id_cons_gen'", $dbi);
				while (list($id_cons2) = mysql_fetch_row($res))
					mysql_query("delete from ".$prefix."_ele_voti_parziale where id_cons='$id_cons2' and data='$data' and orario='$orario'", $dbi)|| die("Impossibile cancellare i dati! ".mysql_error());
				mysql_query("delete from ".$prefix."_ele_rilaff where id_cons_gen='$id_cons_gen' and data='$data' and orario='$orario'", $dbi)|| die("Impossibile cancellare i dati! ".mysql_error());
				Header("Location: admin.php?op=rec_add_aff&id_cons_gen=$id_cons_gen&contr=$data");
			}
		}else{
			Header("Location: admin.php?op=rec_add_aff&id_cons_gen=$id_cons_gen&contr=$data");
		}
	}     


	
	if($do) rec_add_aff($do,$ov,$mv,$gv,$msv,$av,$tipo,$ok, $modello);     
	ele();
	OpenTable();
	all();
	CloseTable();
	include("footer.php");




?>

