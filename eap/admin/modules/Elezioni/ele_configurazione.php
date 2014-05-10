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
$id_cons_gen=$param['id_cons_gen'];	
$perms=ChiSei($id_cons_gen);
if ($perms<32) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");

$id_comune=$_SESSION['id_comune'];
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune' " , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");

if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['ok'])) get_magic_quotes_gpc() ? $ok=$param['ok']:$ok=addslashes($param['ok']); else $ok='';
if (isset($param['blocco'])) get_magic_quotes_gpc() ? 
$blocco=$param['blocco']:$blocco=addslashes($param['blocco']); else $blocco='';
if (isset($param['tema2'])) get_magic_quotes_gpc() ? $tema2=$param['tema2']:$tema2=addslashes($param['tema2']); else $tema2='';
if (isset($param['multicomune'])) get_magic_quotes_gpc() ? $multicomune=$param['multicomune']:$multicomune=addslashes($param['multicomune']); else $multicomune='';
if (isset($param['fileout'])) get_magic_quotes_gpc() ? $fileout=$param['fileout']:$fileout=addslashes($param['fileout']); else $fileout='';
if (isset($param['prefix2'])) get_magic_quotes_gpc() ? $prefix2=$param['prefix2']:$prefix2=addslashes($param['prefix2']); else $prefix2='';
if (isset($param['adminmail'])) get_magic_quotes_gpc() ? $adminmail=$param['adminmail']:$adminmail=addslashes($param['adminmail']); else $adminmail='';
if (isset($param['siteurl'])) get_magic_quotes_gpc() ? $siteurl=$param['siteurl']:$siteurl=addslashes($param['siteurl']); else $siteurl='';
if (isset($param['sitename'])) get_magic_quotes_gpc() ? $sitename=$param['sitename']:$sitename=addslashes($param['sitename']); else $sitename='';
if (isset($param['siteistat'])) get_magic_quotes_gpc() ? $siteistat=$param['siteistat']:$siteistat=addslashes($param['siteistat']); else $siteistat='';
if (isset($param['language2'])) get_magic_quotes_gpc() ? $language2=$param['language2']:$language2=addslashes($param['language2']); else $language2='';
if (isset($param['flash2'])) get_magic_quotes_gpc() ? $flash2=$param['flash2']:$flash2=addslashes($param['flash2']); else $flash2='';
if (isset($param['displayerrors'])) $displayerrors=intval($param['displayerrors']); else $displayerrors='0';

if (isset($param['gkey'])) get_magic_quotes_gpc() ? $gkey=$param['gkey']:$gkey=addslashes($param['gkey']); else $gkey='';
if (isset($param['ed_user'])) get_magic_quotes_gpc() ? $ed_user=$param['ed_user']:$ed_user=addslashes($param['ed_user']); else $ed_user='';
if (isset($param['googlemaps'])) $googlemaps=intval($param['googlemaps']); else $googlemaps='0';
if (isset($param['editor'])) $editor=intval($param['editor']); else $editor='0';
if (isset($param['tema_on'])) $tema_on=intval($param['tema_on']); else $tema_on='0';
if (isset($param['help'])) $help=intval($param['help']);

/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/
	function all() {
   		global $tipo_cons,$param,$currentlang, $bgcolor1, $bgcolor2, $prefix, $prefix2, $dbi, $offset, $min, $id_cons,$id_cons_gen,$id_comune,$do,$tema,$language,$help;
		global $gkey,$ed_user,$googlemaps,$editor,$tema_on;
//		$restemp = mysql_query("select count(0) from ".$prefix."_ele_conf where tema='$tema'", $dbi);
//		list($numtemp)=mysql_fetch_row($restemp);


		if (isset($help)) include("language/$language/ele_configurazione.html");

	//-----------------------visualizza riga superiore per inserimento -
	echo "<form name=\"gruppo2\" enctype=\"multipart/form-data\" method=\"post\" action=\"admin.php\">"
	."<input type=\"hidden\" name=\"op\" value=\"confconsiglio\">";
	$resl = mysql_query("SELECT * FROM ".$prefix."_config", $dbi);
	$gru=mysql_fetch_array($resl);
	echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
	echo "<input type=\"hidden\" name=\"op\" value=\"configurazione\">";
	echo "<br><table style=\"color: #000000;\">";
	echo "<tr bgcolor=\"$bgcolor2\"><td colspan=\"4\" align=\"center\"><b>"._CONFIGDEFAULT."</b></td></tr><tr><td>&nbsp</td></tr>";
	echo "<tr><td>";
	$sel= ($gru['tema_on']==1) ? "selected":"";
	echo "<b>"._TEMAATTIVO."</b></td><td><select name=\"tema_on\"><option value=\"0\">No<option value=\"1\" $sel>Si</select></td>";
	echo "<td>";
	echo "<b>"._TEMA."</b></td>";
 ########## 
	$resmod = mysql_query("SELECT tema FROM ".$prefix."_ele_temi order by tema", $dbi);

	echo "<td><select name=\"tema2\"><option value=\"\">";
	while (list($desc) = mysql_fetch_row($resmod)){
			if (!$gru['tema']) $gru['tema']=$desc;
			$sel= ($gru['tema']==$desc) ? "selected":"";
			echo "<option value=\"".$desc."\" $sel>".$desc;
		}
	echo "</select></td></tr>";
	$sel= ($gru['blocco']==1) ? "selected":"";
	echo "<tr><td><b>"._BLOCCO."</b></td><td><select name=\"blocco\"><option value=\"0\">No<option value=\"1\" $sel>Si</select></td>";
	$sel= ($gru['flash']==1) ? "selected":"";
	echo "<td><b>"._FLASH."</b></td><td><select name=\"flash2\"><option value=\"0\">No<option value=\"1\" $sel>Si</select></td>";
	echo "</tr>";
	$sel= ($gru['multicomune']==1) ? "selected":"";
	echo "<tr><td><b>"._MULTICOMUNE."</b></td><td><select name=\"multicomune\"><option value=\"0\">No<option value=\"1\" $sel>Si</select></td>";
//	echo "<td><b>"._FILEOUT."</b></td><td><input type=\"text\" name=\"fileout\">".$gru['fileout']."</td>";
#	echo "</tr>"
#	."<tr><td><b>"._PREFIX."</b></td><td><input type=\"text\" name=\"prefix2\" value=\"".$gru['prefix']."\"></td>"
	echo "<td><b>"._ADMINMAIL."</b></td><td><input type=\"text\" name=\"adminmail\" value=\"".$gru['adminmail']."\"></td></tr>"
	."<tr><td><b>"._SITEURL."</b></td><td><input type=\"text\" name=\"siteurl\" value=\"".$gru['siteurl']."\"></td>";
	echo"<td><b>"._TESTATA."</b></td>";
	echo "<td><input type=\"file\" name=\"sitelogo\" size=\"10\"></td></tr>";
#	echo"<td><b>"._SITENAME."</b></td><td><input type=\"text\" name=\"sitename\" value=\"".$gru['sitename']."\"></td></tr>";
	$resmod = mysql_query("SELECT id_comune,descrizione FROM ".$prefix."_ele_comuni order by descrizione", $dbi);
	echo "<tr><td><b>"._SITEISTAT."</b></td>";
	echo "<td><select name=\"siteistat\"><option value=\"\">";
	while (list($id_comune2,$desc) = mysql_fetch_row($resmod)){
			if (!$gru['siteistat']) $gru['siteistat']=$id_comune2;
			$sel= ($gru['siteistat']==$id_comune2) ? "selected":"";
			echo "<option value=\"".$id_comune2."\" $sel>".$desc;
		}
	echo "</select></td>";

##########
	echo "<td><b>"._LANGUAGE."</b></td><td><input type=\"text\" name=\"language2\" value=\"".$gru['language']."\"></td></tr>";
	$sel= ($gru['googlemaps']==1) ? "selected":"";
	echo "<tr><td><b>"._GOOGLEMAPS."</b></td><td><select name=\"googlemaps\"><option value=\"0\">No<option value=\"1\" $sel>Si</select></td>";
	echo "<td><b>"._GKEY."</b></td><td><input type=\"text\" name=\"gkey\" value=\"".$gru['gkey']."\"></td></tr>";
	$sel= ($gru['editor']==1) ? "selected":"";
	echo "<tr><td><b>"._EDITOR."</b></td><td><select name=\"editor\"><option value=\"0\">No<option value=\"1\" $sel>Si</select></td>";
	echo "<td><b>"._EDUSER."</b></td>";
	echo "<td><select name=\"ed_user\">";
	$sel=$gru['ed_user']=='Admin'? "selected":"";
			echo "<option value=\"Admin\" $sel>Admin";
	$sel=$gru['ed_user']=='User'? "selected":"";
			echo "<option value=\"User\" $sel>User";
	$sel=$gru['ed_user']=='Eleonline'? "selected":"";
			echo "<option value=\"Eleonline\" $sel>Eleonline</td></tr>";

	echo "<tr>";

#	$sel= ($gru['displayerrors']==1) ? "selected":"";
#	echo "<td><b>"._DISPLAYERRORS."</b></td><td><select name=\"displayerrors\"><option value=\"0\">No<option value=\"1\" $sel>Si</select>";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<td><input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form><br>";

	}

//***********************************************************
//Funzione di inserimento e gestione dei gruppi
//************************************************************

function confcons() {
	
	global $id_cons_gen, $prefix, $dbi, $blocco,$tema2,$multicomune,$fileout,$prefix2,$adminmail,$siteurl,$sitename,$siteistat,$language2,$flash2,$displayerrors;
	global $gkey,$ed_user,$googlemaps,$editor,$tema_on;

	$aid=$_SESSION['aid'];
	$perms=ChiSei($id_cons_gen);
	if ($perms >128) {
				$stemmablob='';
				$stemmanome='';
				$STEMM=$_FILES['sitelogo'];
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
#displayerrors='$displayerrors', 
#per il momento non è usato: , site_logo='$site_logo'
		$result = mysql_query("update  ".$prefix."_config set testata='$stemmablob', nome_testata='$stemmanome', blocco='$blocco', multicomune='$multicomune', language='$language2', siteistat='$siteistat', adminmail='$adminmail', sitename='$sitename', siteurl='$siteurl', flash='$flash2', tema='$tema2',gkey='$gkey',ed_user='$ed_user',googlemaps='$googlemaps',editor='$editor',tema_on='$tema_on' ", $dbi) || die("Errore di aggiornamento dei dati!".mysql_error());
	if ($tema2=='facebook')
		$_SESSION['tema']=$tema2;
	else $_SESSION['tema']='default';
		Header("Location: admin.php?id_cons_gen=$id_cons_gen");

	}
}

if ($do and $do="modify")
	confcons();

ele();

all();
echo"</td></tr></table>";
include("footer.php");




?>

