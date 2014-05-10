<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Admin	                                                          */
/* Amministrazione                                                      */
/************************************************************************/

/* Descrizione file admin.php = 
effettua il login o il rilancio alla gestione */

define('ADMIN_FILE', true);
#$LIMITE=3; //fascia di separazione del maggioritario (15.000 abitanti)
# tempo di sessione: ini_set('session.gc_maxlifetime','3600');

// Adattamento variabili superglobal
// Versione di php
$phpver = phpversion();

// converte superglobal se php e' < 4.1.0

if ($phpver < '4.1.0') {
  $_GET = $HTTP_GET_VARS;
  $_POST = $HTTP_POST_VARS;
  $_SERVER = $HTTP_SERVER_VARS;
  $_FILES = $HTTP_POST_FILES;
  $_ENV = $HTTP_ENV_VARS;
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $_REQUEST = $_POST;
  } elseif($_SERVER['REQUEST_METHOD'] == "GET") {
    $_REQUEST = $_GET;
  }
  if(isset($HTTP_COOKIE_VARS)) {
    $_COOKIE = $HTTP_COOKIE_VARS;
  }
  if(isset($HTTP_SESSION_VARS)) {
    $_SESSION = $HTTP_SESSION_VARS;
  }
}

$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
if (isset($param['aid'])) get_magic_quotes_gpc() ? $aid=$param['aid']:$aid=addslashes($param['aid']); 
if (isset($param['pwd'])) get_magic_quotes_gpc() ? $pwd2=$param['pwd']:$pwd2=addslashes($param['pwd']); 
// Additional security (Union, CLike, XSS)

// We want to use the function stripos,
// but thats only available since PHP5.
// So we cloned the function...
if(!function_exists('stripos')) {
  function stripos_clone($haystack, $needle, $offset=0) {
    return strpos(strtoupper($haystack), strtoupper($needle), $offset);
  }
} else {
// But when this is PHP5, we use the original function	
  function stripos_clone($haystack, $needle, $offset=0) {
    return stripos($haystack, $needle, $offset=0);
  }
}

  if(isset($_SERVER['QUERY_STRING']) && (!stripos_clone($_SERVER['QUERY_STRING'], "ad_click") || !stripos_clone($_SERVER['QUERY_STRING'], "url"))) {
    $queryString = $_SERVER['QUERY_STRING'];
    if (stripos_clone($queryString,'%20union%20') OR stripos_clone($queryString,'/*') OR stripos_clone($queryString,'*/union/*') OR stripos_clone($queryString,'c2nyaxb0') OR stripos_clone($queryString,'+union+') OR stripos_clone($queryString,'http://') OR (stripos_clone($queryString,'cmd=') AND !stripos_clone($queryString,'&cmd')) OR (stripos_clone($queryString,'exec') AND !stripos_clone($queryString,'execu')) OR stripos_clone($queryString,'concat')) {
      die('Operazione non consentita');
    }
  }


foreach ($_GET as $sec_key => $secvalue) {
    if ((preg_match("/<[^>]*script*\"?[^>]*>/i",$secvalue)) ||
	(preg_match("/<[^>]*object*\"?[^>]*>/i", $secvalue)) ||
	(preg_match("/<[^>]*iframe*\"?[^>]*>/i", $secvalue)) ||
	(preg_match("/<[^>]*applet*\"?[^>]*>/i", $secvalue)) ||
	(preg_match("/<[^>]*meta*\"?[^>]*>/i", $secvalue)) ||
	(preg_match("/<[^>]*style*\"?[^>]*>/i", $secvalue)) ||
	(preg_match("/<[^>]*form*\"?[^>]*>/i", $secvalue)) ||
	(preg_match("/<[^>]*img*\"?[^>]*>/i", $secvalue)) ||
	(preg_match("/<[^>]*onmouseover*\"?[^>]*>/i", $secvalue)) ||
	(preg_match("/<[^>]*body*\"?[^>]*>/i", $secvalue)) ||
	(preg_match("/\([^>]*\"?[^)]*\)/", $secvalue)) ||
	(preg_match("/\"/", $secvalue)) ||
	(preg_match("/inside_mod/i", $sec_key))) {
        die ("Operazione non consentita");
     }
  }

  foreach ($_POST as $secvalue) {
    if ((preg_match("/<[^>]*onmouseover*\"?[^>]*>/i", $secvalue)) || (preg_match("/<[^>]script*\"?[^>]*>/i", $secvalue)) || (preg_match("/<[^>]*body*\"?[^>]*>/i", $secvalue)) || (preg_match("/<[^>]style*\"?[^>]*>/i", $secvalue))) {
      die ('Operazione non consentita');
    }
  }
  
// Posting from other servers in not allowed
// Fix by Quake
// Bug found by PeNdEjO

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_SERVER['HTTP_REFERER'])) {
    if (!stripos_clone($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) {
        die('Posting da un altro server non  consentito!');
    }
  } else {
#    die('<b>Attenzione:</b> il tuo browser non puo inviare gli header HTTP_REFERER al website.<br>'.$_SERVER['HTTP_REFERER']);
  }
}
  

  




//===================================================================
session_name('sesadmin');
session_start();//MODIFICHE PER GESTIONE SESSIONI
  // gestione sessione



include("config.php");
		$dbi=mysql_connect($dbhost, $dbuname, $dbpass) or die("Connessione non riuscita: " . mysql_error());
		mysql_select_db($dbname)or die("Connessione non riuscita:" . mysql_error());
	mysql_query("SET NAMES 'utf8'", $dbi);
//---10/05/2009  gestione consultazione predefinita
		$res_config = mysql_query("select * from ".$prefix."_config ",$dbi);
		list ($sitename,$siteurl,$site_logo,$slogan,$startdate,$adminmail,$tema,$foot,$language,$blocco
,$testata,$logo,$fileout,$copyright,$versione,$patch,$id_comune,$multicomune,$flash,$displayerrors,$editor,$tema_on,$ed_user) = mysql_fetch_row($res_config);
		$siteistat=$id_comune;
if (!isset($_SESSION['id_comune'])){
	$_SESSION['sitename']=$sitename;
	$_SESSION['siteurl']=$siteurl;
	$_SESSION['site_logo']=$site_logo;
	$_SESSION['slogan']=$slogan;
	$_SESSION['startdate']=$startdate;
	$_SESSION['adminmail']=$adminmail;
	if ($tema=='facebook')
		$_SESSION['tema']=$tema;
	else $_SESSION['tema']='default';
	$_SESSION['foot']=$foot;
	$_SESSION['lang']=$language;
	$_SESSION['blocco']=$blocco;
	$_SESSION['testata']=$testata;
	$_SESSION['logo']=$logo;
	$_SESSION['fileout']=$fileout;
	$_SESSION['copyright']=$copyright;
	$_SESSION['versione']=$versione;
	$_SESSION['patch']=$patch;
	$_SESSION['id_comune']=$id_comune;
	$_SESSION['multicomune']=$multicomune;
	$_SESSION['flash']=$flash;
	$_SESSION['displayerrors']=$displayerrors;
	$_SESSION['editor']=$editor;
	$_SESSION['tema_on']=$tema_on;
	$_SESSION['ed_user']=$ed_user;
}
//fine
if (isset($param['aid'])) {
        if (strlen($aid)>25 ) { die ("Nome utente troppo lungo: $aid"); }	
	if (!isset($param['id_ses']) or $param['id_ses'] != session_id()) logout();
	if (strstr( $aid," ")) { die ("Gli spazi non sono ammessi nel nome utente: $aid"); }
	if (isset($_SESSION['aid'])){
		logout();//se hai gia' una sessione aperta non puoi postare 'aid'
	}else{
		
	
	      //  $pwd2=$param['pwd'];
		$mpwd=md5($pwd2);

		// se superUserAdmin 
########
		$res_comune = mysql_query("select adminsuper from ".$prefix."_authors where aid='$aid' and pwd='$mpwd'",$dbi);
		list ($adminsuper) = mysql_fetch_row($res_comune);
		if ($adminsuper==1) $id_comune='0';
		elseif (is_numeric($param['id_comune']) and intval($param['id_comune'])>0) $id_comune=intval($param['id_comune']);
		$res= mysql_query("select counter,admlanguage from ".$prefix."_authors where aid='$aid' and pwd='$mpwd' and id_comune='$id_comune'", $dbi);

		if ($res){
			$esiste=mysql_num_rows($res);


			list ($counter,$tmplang) = mysql_fetch_row($res);
			$counter+=1; 
			if(strlen($tmplang)==2) $language=$tmplang;
			$resup=mysql_query("update ".$prefix."_authors set counter=$counter where aid='$aid' and pwd='$mpwd' and id_comune='$id_comune'", $dbi);
			if ($esiste==1) {
				$_SESSION['dbi']=$dbi;
				$_SESSION['aid']="$aid";
				$_SESSION['pwd']="$mpwd";
				$_SESSION['lang']="$language";
				$_SESSION['id_comune']="$id_comune";
				$_SESSION['prefix']="soraldo";
				$_SESSION['remote']=$_SERVER['REMOTE_ADDR'];
				$_SESSION['bgcolor1']='#ffffff';
				$_SESSION['bgcolor2']='#c5c5c5';
    				session_regenerate_id();
			} 
		}
	}
}else{
$_SESSION['dbi']=$dbi;

}
if (! isset($_SESSION['lang'])) $_SESSION['lang']=$language;
$currentlang=strlen($_SESSION['lang'])==2 ? $_SESSION['lang']: $language;
#if (isset($_SESSION['lang'])) $currentlang=$_SESSION['lang']; else $currentlang='it';
if (isset($_SESSION['aid']))
{
//lettura sessione
$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$id_comune=$_SESSION['id_comune'];
if (isset($_GET['id_cons_gen'])) $id_cons_gen=intval($_GET['id_cons_gen']);
else {
//10/05/2009 gestione consultazione predefinita
	$result = mysql_query("select id_cons_gen  from ".$prefix."_ele_cons_comune where preferita='1' and (id_comune='$id_comune' or id_comune=0)", $dbi);
list($id_cons_gen) = mysql_fetch_row($result);
//---fine	$id_cons_gen='';
}
$currentlang=$_SESSION['lang'];
$bgcolor1=$_SESSION['bgcolor1'];
$bgcolor2=$_SESSION['bgcolor2'];
$bgcolor1='#e7e7e7';
$session=$_SESSION['remote'];

$perms=ChiSei($id_cons_gen);
}


/*********************************************************/
/* Login Function                                        */
/*********************************************************/
function ChiSei($id_cons_gen){

//$server=$_SERVER['REMOTE_ADDR'];
//$session=$_SESSION['remote'];
//if ($session!=$server) { die ("Problema di sessione"); };
$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$pwd=$_SESSION['pwd'];
$id_comune=$_SESSION['id_comune'];


$perms=0;
$result = mysql_query("select adminsuper, admincomune, adminop  from ".$prefix."_authors where aid='$aid' and pwd='$pwd' and (id_comune='$id_comune' or id_comune=0)", $dbi);
list($adminsuper,$admincomune,$adminop) = mysql_fetch_row($result);
//exit;
if (($adminsuper==1 || $admincomune==1 || $adminop==1)) {
	if ($adminsuper==1)
		return 256;
//		$ressup = mysql_query("select permessi from ".$prefix."_ele_operatori where id_cons='0' and aid='$aid' and id_comune='0'",$dbi);
	elseif ($adminop==1) 
		$ressup = mysql_query("select permessi from ".$prefix."_ele_operatori where id_cons='0' and aid='$aid' and id_comune='$id_comune'",$dbi);
	elseif ($admincomune==1) {
		$res=mysql_query("select id_cons from ".$prefix."_ele_cons_comune where id_comune='$id_comune' and id_cons_gen='$id_cons_gen'",$dbi);
		list ($id_cons)=mysql_fetch_row($res);
		$ressup = mysql_query("select permessi from ".$prefix."_ele_operatori where id_cons='$id_cons' and aid='$aid' and id_comune='$id_comune'",$dbi);
	}
	if (mysql_num_rows($ressup)==1) list($perms)=mysql_fetch_row($ressup); else $perms=0;
	return $perms;
} else return 0;
}

function OpenTable(){
echo "<table  width=\"100%\"   cellpadding=\"0\" cellspacing=\"2\"  BORDER=\"0\">";
}

function CloseTable(){
echo "</table>";
}

function login() {
    global $param,$prefix,$dbi,$multicomune,$siteistat,$language,$tema;
    $lang=strlen($_SESSION['lang'])==2 ? $_SESSION['lang']: $language;
    if (isset($param['id_comune'])) $id_comune=intval($param['id_comune']);
    if (!isset($id_comune)) $id_comune=0;
    session_regenerate_id();
    $id_ses=session_id();
#die("test:$tema");
    //include("modules/Elezioni/language/lang-$lang.php");
    include ("header.php");
    echo "<div align=\"middle\"><font class=\"title\"><b>"._GESTIONE."</b></font></center>";
    echo "<br>";  # method=\"post\"
    echo "<form name=\"login\" method=\"post\" action=\"admin.php\">"
        ."<table align=\"middle\" border=\"0\">"
	."<tr><td>"._ADMINID."</td>"
	."<td><input type=\"text\" NAME=\"aid\" SIZE=\"20\" MAXLENGTH=\"25\"></td></tr>"
	."<tr><td>"._PASSWORD."</td>"
	."<td><input type=\"password\" NAME=\"pwd\" SIZE=\"20\" MAXLENGTH=\"18\"></td></tr>"
	."<tr><td>";
	// scelta comune 
	if($multicomune=='1'){
		echo ""._COMUNE."</td><td>";
		$sqlcomu="select id_comune,descrizione from ".$prefix."_ele_comuni order by descrizione asc";
		$rescomu= mysql_query("$sqlcomu",$dbi);
	
		echo "<select name=\"id_comune\">";
		while (list($id,$descrizione)=mysql_fetch_row($rescomu))
		{
			$sel=($id == $id_comune) ? "selected":"";
			echo "<option value=\"$id\" $sel>$descrizione";
		}
	}else{
		echo "<input type=\"hidden\" name=\"id_comune\" value=\"$siteistat\">";
	}
//	echo "<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\">";
	if(strlen($lang)==2) echo "<input type=\"hidden\" name=\"language\" value=\"$lang\">";
	echo "</td></tr><tr><td>";
	echo "<input type=\"hidden\" name=\"id_ses\" value=\"$id_ses\">";
	echo "<input type=\"submit\" VALUE=\""._OK."\">"
	."</td></tr></table>"
	."</form></div>";
        
    include ("footer.php");
}

function logout()
{
/* $lang=$_SESSION['lang'];
$id_comune=$_SESSION['id_comune'];
//	setcookie ("PHPSESSID", "", time() - 3600);
	session_cache_expire (0);
        $_SESSION=array();  //MODIFICHE PER GESTIONE SESSIONI
	session_unset();        
	session_destroy();
        Header("Location: admin.php?id_comune=$id_comune&language=$lang");
*/
global $siteistat; 

$ref="Location: admin.php?"; 
if (isset($_SESSION['id_comune'])) 
$id_comune=$_SESSION['id_comune']; 
else 
$id_comune=$siteistat; 
$ref=$ref."id_comune=".$id_comune; 

if (isset($_SESSION['lang'])) 
$ref=$ref."&language=".$_SESSION['lang']; 

session_cache_expire (0); 
$_SESSION=array();  
session_unset(); 
session_destroy(); 
Header($ref); 

}

if (isset($param['op'])) get_magic_quotes_gpc() ? $op=$param['op']:$op=addslashes($param['op']); else $op='ele';
//if (isset($param['op'])) $op=$param['op']; else $op='ele';
if (isset($_SESSION['aid']) AND $_SESSION['remote']==$_SERVER['REMOTE_ADDR']) {
switch($op) {
    case "tipo":
    include("modules/Elezioni/ele_tipi.php");
	break;
    case "constipi":
    include("modules/Elezioni/ele_consultazionitipi.php");
	break;
    case "aggiorna":
    include("modules/Elezioni/aggiorna.php");
	break;
    case "parziali":
    include("modules/Elezioni/ele_parziali.php");
	break;
    case "ele": 
    include("modules/Elezioni/ele.php");
    break;
    case "consultazione":
    include("modules/Elezioni/ele_consultazioni.php");
    break;
    case "configurazione":
    include("modules/Elezioni/ele_configurazione.php");
    break;
    case "cons_comuni":
    include("modules/Elezioni/ele_cons_comuni.php");
    break;
    case "confconsiglio":
    include("modules/Elezioni/ele_confcons.php");
    break;
    case "inscomuni":
    include("modules/Elezioni/ele_comuni.php");
    break;
    case "oper_admin":
    include("modules/Elezioni/ele_operatori.php");
    break;
    case "inscollegi":
    include("modules/Elezioni/ele_collegi.php");
    break;
    case "associazioni":
    include("modules/Elezioni/ele_associazioni.php");
    break;
    case "operatori":
    include("modules/Elezioni/ele_operatori.php");
    break;
    case "permessi":
    include("modules/Elezioni/ele_permessi.php");
    break;
    case "circo":
    include("modules/Elezioni/ele_circo.php");
    break;
 case "sede":
    include("modules/Elezioni/ele_sede.php");
    break;
case "sezione":
    include("modules/Elezioni/ele_sezione.php");
    break;
case "gruppo":
    include("modules/Elezioni/ele_gruppo.php");
    break;
case "rec_add_aff":
    include("modules/Elezioni/ele_affluenze.php");
    break;
case "rec_add_mod":
    include("modules/Elezioni/ele_modelli.php");
    break;
case "upgruppo":
    include("modules/Elezioni/ele_gruppo.php");
    break;
case "delimggruppo":
    include("modules/Elezioni/ele_gruppo.php");
    break;
case "lista":
    include("modules/Elezioni/ele_lista.php");
    break;
case "uplista":
    include("modules/Elezioni/ele_lista.php");
    break;
case "delimglista":
    include("modules/Elezioni/ele_lista.php");
    break;
case "candidato":
    include("modules/Elezioni/ele_candidato.php");
    break;
case "upcandidato":
    include("modules/Elezioni/ele_candidato.php");
    break;
case "delimgcandidato":
    include("modules/Elezioni/ele_candidato.php");
    break;

case "voti":
    include("modules/Elezioni/ele_voti.php");
    break;
case "sezioni_voti":
    include("modules/Elezioni/ele_voti.php");
    break;
case "rec_voti":
    include("modules/Elezioni/ele_voti.php");
    break;
case "rec_voti_gruppi":
    include("modules/Elezioni/ele_voti.php");
    break;
case "rec_add_votanti":
    include("modules/Elezioni/ele_voti.php");
    break;
case "rec_finale":
    include("modules/Elezioni/ele_voti.php");
    break;
case "controllo_voti":
    include("modules/Elezioni/controllo_voti.php");
    break;
case "controllo_votanti":
    include("modules/Elezioni/controllo_votanti.php");
    break;
case "come":
    include("modules/Elezioni/ele_come.php");
    break;
case "numeri":
    include("modules/Elezioni/ele_come.php");
    break;
case "servizi":
    include("modules/Elezioni/ele_come.php");
    break;
case "link":
    include("modules/Elezioni/ele_come.php");
    break;
case "conf":
    include("modules/Elezioni/ele_conf.php");
    break;
case "stampa":
    include("modules/Elezioni/ele_stampe.php");
 break;
case "cambiopwd":
    include("modules/Elezioni/ele_pwd.php");
    break;
case "eletti":
    include("modules/Elezioni/ele_eletti.php");
    break;
case "foto":
    include("modules/Elezioni/foto.php");
    break;
case "consiglieri":
    include("modules/Elezioni/ele_consiglieri.php");
    break;
case "backup":
    include("modules/Elezioni/backup.php");
    break;
case "restore":
    include("modules/Elezioni/restore.php");
    break;
case "scarica":
    include("modules/Elezioni/scarica.php");
    break;
case "importa":
    include("modules/Elezioni/importa.php");
    break;
case "widget":
    include("modules/Elezioni/ele_widget.php");
    break;
   

case "logout":
	logout();
    break;
}
}else {

    login();

}


?>
