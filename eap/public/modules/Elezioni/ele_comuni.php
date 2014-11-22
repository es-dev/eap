<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Comuni                                                        */
/* Amministrazione                                                      */
/************************************************************************/
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}
#foreach($_FILES as $key=>$val) echo $key;die();
$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$id_comune=$_SESSION['id_comune'];
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=intval($param['id_cons_gen']);	
$perms=ChiSei(0);
//if ($perms<128 or !$id_cons_gen) die("$perms Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
if ($perms!=256) die("$perms Non hai i permessi per inserire dati!");
if (isset($param['desc'])) get_magic_quotes_gpc() ? $desc=$param['desc']:$desc=addslashes($param['desc']); else $desc='';
if (isset($param['indirizzo'])) get_magic_quotes_gpc() ? $indirizzo=$param['indirizzo']:$indirizzo=addslashes($param['indirizzo']); else $indirizzo='';
if (isset($param['centralino'])) get_magic_quotes_gpc() ? $centralino=$param['centralino']:$centralino=addslashes($param['centralino']); else $centralino='';
if (isset($param['fax'])) get_magic_quotes_gpc() ? $fax=$param['fax']:$fax=addslashes($param['fax']); else $fax='';
if (isset($param['email'])) get_magic_quotes_gpc() ? $email=$param['email']:$email=addslashes($param['email']); else $email='';
if (isset($param['id_comune2'])) $id_comune2=intval($param['id_comune2']); else $id_comune2='';
if (isset($param['min'])) $min=intval($param['min']); else $min='';
if (isset($param['ok'])) $ok=addslashes($param['ok']); else $ok='';
if (isset($param['fascia'])) $fascia=intval($param['fascia']); else $fascia=0;
if (isset($param['prov'])) $prov=intval($param['prov']); else $prov=0;
if (isset($param['simbolo'])) get_magic_quotes_gpc() ? $simbolo=$param['simbolo']:$simbolo=addslashes($param['simbolo']); else $simbolo='';
if (isset($param['cerca'])) get_magic_quotes_gpc() ? $cerca=$param['cerca']:$cerca=addslashes($param['cerca']); else $cerca='';

	$res = mysql_query("SELECT t1.tipo_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_comune='$id_comune' " , $dbi);
	list($tipo_cons) = mysql_fetch_row($res);
	$res = mysql_query("SELECT genere FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons' " , $dbi);
	list($genere) = mysql_fetch_row($res);
	include("modules/Elezioni/funzionidata.php");
	include("modules/Elezioni/ele.php");

	// Offset - visualizza il numero di elementi per pagina

		$offset=15;
		if (!isset($min)) $min=0;

		$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";



	/******************************************************/
	/*Funzione di visualizzazione globale                 */
	/*****************************************************/
	//crea la pagina delle affluenze
function all() {
	global $bgcolor1, $bgcolor2, $prefix, $dbi,$id_cons,$desc,$indirizzo,$centralino,$fax,$email,$fascia,$prov,$id_comune2,$id_cons_gen,$cerca;
 
	echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n";
	echo "function controllo_id() {\n";
	echo "var is_num = /^[0-9]+$/;";
	echo "if (document.modello.id_comune2.value.match(is_num)) \n return true;\n"; 
	echo "else {\n";
	echo "document.modello.id_comune2.bgColor=\"#FF0000\" \n";
	echo "alert ('"._COD_NV."!')\n return false; \n";
	echo "}\n";
	echo "}\n//-->\n";
	echo "</script>\n";

 
	$resmod = mysql_query("SELECT id_comune,descrizione,indirizzo,centralino,fax,email,fascia,capoluogo,simbolo FROM ".$prefix."_ele_comuni where descrizione like '$cerca%' order by descrizione", $dbi);
	echo "<table width=\"100%\"><tr><td bgcolor=\"$bgcolor2\"> <form name=\"cerca\" action=\"admin.php\">"
	."<input type=\"hidden\" name=\"op\" value=\"inscomuni\">";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<table>";
	echo "<tr><td><b>"._FILTRO."</b><input name=\"cerca\"></td>";
	echo "<td><input type=\"submit\" name=\"invia\" value=\""._OK."\"></td></tr></table></form></td></tr></table>";

	echo "<form name=\"modello\" enctype=\"multipart/form-data\" method=\"post\" action=\"admin.php\" onSubmit=\"return controllo_id()\">"
		."<input type=\"hidden\" name=\"op\" value=\"inscomuni\">";
	echo "<table width=\"100%\"><tr>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._STEMMA."</b></td><td><input type=\"file\" name=\"stemma\" size=\"10\"></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._CODICE."</b></td>";
	if ($desc)
		echo "<td><input type=\"hidden\" name=\"id_comune2\" value=\"$id_comune2\">$id_comune2</td>";
	else
		echo "<td><input name=\"id_comune2\" value=\"$id_comune2\" size=\"4\"></td>";
	echo "</tr>";
	$sel[1]='';$sel[2]='';$sel[3]='';$sel[4]='';$sel[5]='';$sel[6]='';$sel[7]='';$sel[8]='';$sel[9]='';
	$sel[$fascia]='selected';
	if($prov==1) $selpv='selected'; else $selpv='';
	echo "<tr><td bgcolor=\"$bgcolor1\"><b>"._PROV."</b></td><td><select name=\"prov\"> <option value=\"0\">No<option value=\"1\" $selpv>Si</select></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._DESCR."</b></td><td><input name=\"desc\" value=\"$desc\"></td></tr>";
	echo "<tr><td bgcolor=\"$bgcolor1\"><b>"._INDIRIZZO."</b></td><td><input name=\"indirizzo\" value=\"$indirizzo\"></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._CENTRALINO."</b></td><td><input name=\"centralino\" value=\"$centralino\" size=\"6\"></td></tr>";
	echo "<tr><td bgcolor=\"$bgcolor1\"><b>"._FASCIA."</b></td><td><select name=\"fascia\">"
		."<option value=\"1\"".$sel[1].">0-3.000"
		."<option value=\"2\"".$sel[2].">3.001-10.000"
		."<option value=\"3\"".$sel[3].">10.001-15.000"
		."<option value=\"4\"".$sel[4].">15.001-30.000"
		."<option value=\"5\"".$sel[5].">30.001-100.000"
		."<option value=\"6\"".$sel[6].">100.001-250.000"
		."<option value=\"7\"".$sel[7].">250.001-500.000"
		."<option value=\"8\"".$sel[8].">500.001-1.000.000"
		."<option value=\"9\"".$sel[9]."> >1.000.000";
	echo "</select></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._FAX."</b></td><td><input name=\"fax\" value=\"$fax\" size=\"6\"></td></tr>";
	echo "<tr><td bgcolor=\"$bgcolor1\"><b>"._EMAIL."</b></td><td><input name=\"email\" value=\"$email\"></td>";
	echo "<td></td><td><input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<input type=\"hidden\" name=\"ok\" value=0>";
	if ($desc) {
		echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
		echo "<input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td></tr></form>";
	}else{
		echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
		echo "<input type=\"submit\" name=\"add\" value=\""._ADD."\"></td></tr></form>";
	}
	$i=1;
####
echo "</table><hr>";
	echo "<table><tr><td bgcolor=\"$bgcolor1\"><b>"._STEMMA."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._CODICE."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._PROV."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._DESCR."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._INDIRIZZO."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._CENTRALINO."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FAX."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._EMAIL."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FASCIA."</b></td></tr>";

####
	while (list($id_comune2,$desc,$indirizzo,$centralino,$fax,$email,$fascia,$prov,$simbolo) = mysql_fetch_row($resmod)){ //elenco dei modelli inseriti
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		if (!$simbolo) $simbolo="nulla.jpg";
		$valprov= $prov==0 ? 'No':'Si';
		echo "<form name=\"modello$i\" action=\"admin.php\">"
			."<input type=\"hidden\" name=\"op\" value=\"inscomuni\">";
		echo "<input type=\"hidden\" name=\"do\" value=\"delete\">";
		echo "<input type=\"hidden\" name=\"desc\" value=\"$desc\">";
		echo "<tr align=\"left\" bgcolor=\"$bgcolor1\">";
		echo "<td align=\"center\">
		<img  src=\"admin.php?op=foto&amp;id_comune=$id_comune2&amp;prefix=$prefix\" width=\"50\" heigth=\"50\"></td>";

		echo "<td width=\"32\"><b>$id_comune2</b></td>";
		echo "<td width=\"32\"><b>$valprov</b></td>";
		echo "<td><b>$desc</b></td>";
		echo "<td><b>$indirizzo</b></td>";
		echo "<td><b>$centralino</b></td>";
		echo "<td><b>$fax</b></td>";
		echo "<td><b>".substr($email,0,15)."...</b></td>";
		switch ($fascia) {
			case '0': $valfascia="-"; break;
			case '1': $valfascia="< 3.000"; break;
			case '2': $valfascia="3.001-10.000"; break;
			case '3':$valfascia="10.001-15.000"; break;
			case '4':$valfascia="15.001-30.000"; break;
			case '5':$valfascia="30.001-100.000"; break;
			case '6':$valfascia="100.001-250.000"; break;
			case '7':$valfascia="250.001-500.000"; break;
			case '8':$valfascia="500.001-1000.000"; break;
			case '9': $valfascia=" >1.000.000"; break;
		}	
		echo "<td><b>$valfascia</b></td>";
		echo "<input type=\"hidden\" name=\"ok\" value=0>";
		echo "</td><td nowrap>[<a
		href=\"admin.php?op=inscomuni&amp;desc=$desc&amp;id_comune2=$id_comune2&amp;indirizzo=$indirizzo&amp;centralino=$centralino&amp;fax=$fax&amp;email=$email&amp;fascia=$fascia&amp;prov=$prov&amp;id_cons_gen=$id_cons_gen\"><img  align=\"center\" src=\"modules/Elezioni/images/edit.gif\"
                border=\"0\"> "._EDIT."</a>]";
		echo "</tr></form>";
		$i++;
	}
	echo "</table>";
	CloseTable();
	}

function comuni($ok, $do,$desc,$indirizzo,$centralino,$fax,$email,$id_comune,$fascia,$prov,$simbolo) {
		global $bgcolor1, $bgcolor2, $prefix, $dbi, $descr_cons, $id_cons_gen,$genere;
/*      			if ($do == "delete") {
     				if ($ok !="1") {
//						ele($id_cons);operatori
						echo "<center><br><br>"._DOMCANCELLA." "._COMUNE." $desc ?<br>";
						echo "[ <a href=\"admin.php?op=inscomuni&amp;id_comune=$id_comune&amp;desc=$desc\">"._NO."</a> ] - [<a href=\"admin.php?op=inscomuni&amp;do=delete&amp;desc=$desc&amp;id_comune=$id_comune&amp;ok=1\">"._YES."</a> ]";
     				}else{
		  				$result = sql_query("delete from ".$prefix."_ele_comuni where id_comune='$id_comune'", $dbi) || die("<br><br>Errore di eliminazione: ".mysql_error());
          				if (!$result) return;
		  				Header("Location: admin.php?op=inscomuni&id_comune=$id_comune");
					}
      		}else*/ 
      	$_SESSION['id_comune']=$id_comune;
	if ($do == "add") {
      		if ($desc) {
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
      			$result = mysql_query("insert into ".$prefix."_ele_comuni (id_comune,descrizione,indirizzo,centralino,fax,email,fascia,capoluogo,simbolo,stemma) values ('$id_comune','$desc','$indirizzo','$centralino','$fax','$email','$fascia','$prov','$stemmanome','$stemmablob')", $dbi) || die("<br><br>Errore di inserimento: ".mysql_error());
           		Header("Location: admin.php?op=inscomuni&id_cons_gen=$id_cons_gen");
     		} else {
        		OpenTable();
			echo "<center>"._GESTIONE." "._OPERATORI." desc=$desc; ";
        		echo "<br><br><a href=\"admin.php?op=inscomuni&amp;id_comune=$id_comune\">"._IMM." "._OPERATORI."</a></center>";
			CloseTable();
     		}
   	}else if ($do == "update") {
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
			} else {$cond='';$stemmanome=''; $stemmablob='';}
        	$result = mysql_query("update  ".$prefix."_ele_comuni set descrizione='$desc' , indirizzo='$indirizzo', centralino='$centralino', fax='$fax', email='$email', fascia='$fascia',capoluogo='$prov' $cond where id_comune='$id_comune'", $dbi) || die("<br><br>Errore di inserimento: ".mysql_error());
           	Header("Location: admin.php?op=inscomuni&id_cons_gen=$id_cons_gen");
   	}
}

if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';

if ($do)
	comuni($ok, $do,$desc,$indirizzo,$centralino,$fax,$email,$id_comune2,$fascia,$prov,$simbolo);
ele();
all();
include("footer.php");

?>

