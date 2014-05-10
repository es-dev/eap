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
if (isset($param['idw'])) $idw=intval($param['idw']); else $idw='';
if (isset($param['nome_file'])) get_magic_quotes_gpc() ? 
$nome_file=$param['nome_file']:$nome_file=addslashes($param['nome_file']); else $nome_file='';
if (isset($param['titolo'])) get_magic_quotes_gpc() ? 
$titolo=$param['titolo']:$titolo=addslashes($param['titolo']); else $titolo='';
if (isset($param['pos_or'])) $pos_or=intval($param['pos_or']); else $pos_or='';
if (isset($param['pos_ver'])) $pos_ver=intval($param['pos_ver']); else $pos_ver='';
if (isset($param['attivo'])) $attivo=intval($param['attivo']); else $attivo='';


############# controllo dei widget
        make_db_widget(); // crea tabella se non esiste
    $tlist='';
	$path = "../client/modules/Elezioni/blocchi";
	$handle=opendir($path);
    	while ($file = readdir($handle)) {
		   $tlist .= "$file ";
   	}

    	closedir($handle);
    	$tlist = explode(" ", $tlist);
    	sort($tlist);

    	for ($i=0; $i < sizeof($tlist); $i++) {
		$ext = substr($tlist[$i], strrpos( $tlist[$i], '.' ) + 1 );

		if($ext=="php"){ // verifica estensione php	
		    $files=$tlist[$i];
		   
		    $sql = mysql_query("SELECT id FROM ".$prefix."_ele_widget where nome_file='$files'", $dbi);
		    list($idwid) = mysql_fetch_row($sql);
		    $id = intval($idwid);


		    if (empty($id)) { // inserisce widget db se non esiste
			$result = mysql_query("insert into ".$prefix."_ele_widget (id,nome_file,titolo,pos_or,pos_ver, attivo) values ( NULL,'$files', '$files','1','','0')", $dbi);
	          }
		  
		  




	
		}   

	}
 
		  # se non esiste cancella dal db
		  $sql2 = mysql_query("SELECT * FROM ".$prefix."_ele_widget", $dbi);
		  while ($row = mysql_fetch_array($sql2)) {
			$esi=0;
			for ($i=0; $i < sizeof($tlist); $i++) {
			      $files=$tlist[$i];
			      if($row['nome_file']==$files) $esi=1;
			}
			if($esi!=1){
			      $del=mysql_query("DELETE FROM ".$prefix."_ele_widget WHERE id = '$row[id]'",$dbi);
		      }
		}



/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/
	function all() {
   		global $tipo_cons,$param,$currentlang, $bgcolor1, $bgcolor2, $prefix, $prefix2, $dbi, $offset, $min, $id_cons,$id_cons_gen,$id_comune,$do,$tema;

	
	$result = mysql_query("SELECT * FROM ".$prefix."_ele_widget order by pos_or,pos_ver asc", $dbi);
	
	


	
	echo "<br><table border=\"0\" width=\"100%\">";
	echo "<tr bgcolor=\"$bgcolor2\"><td align=\"center\"><b>"._CONFIGWIDGET."</b></td></tr></table>";
	
	while ($row = mysql_fetch_array($result)) {
	    echo "<form name=\"widget\" enctype=\"multipart/form-data\" method=\"post\" action=\"admin.php\">";
	    echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
	    echo "<input type=\"hidden\" name=\"op\" value=\"widget\">";
	    echo "<table style=\"border:0.5px solid; width:100%; color: #000000;\"><tr >";
	    $idw = intval($row['id']);
	    echo "<input type=\"hidden\" name=\"idw\" value=\"$idw\">";
	    $titolo=$row['titolo'];
	    $nome_file=$row['nome_file'];
	    $pos_or = intval($row['pos_or']);
	    $pos_ver = intval($row['pos_ver']);
	    $attivo = intval($row['attivo']);
	    echo "<td><b> Titolo:</b> <input type=\"text\" name=\"titolo\" value=\"".$titolo."\"></td><td>";
	    $sel= ($row['pos_or']==1) ? "selected":"";
	    echo "<b>Posizione :</b><select name=\"pos_or\"><option value=\"0\">Sx<option value=\"1\" $sel>Dx</select>
	    </td><td>
	    
	    <b>Altezza :</b><input type=\"text\" size=\"4\" name=\"pos_ver\" value=\"".$pos_ver."\"></td><td>";
	    echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	   
	    
	    
	    $sel= ($row['attivo']==1) ? "selected":"";
	    echo "<b>"._ATTIVO."</b></td><td><select name=\"attivo\"><option value=\"0\">No<option value=\"1\" $sel>Si</select></td>";
	    echo "<td><input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td>";
	    echo "</tr></table>";
	    echo "</form>";


	} // while
	
	
	

	}

//***********************************************************
//Funzione di inserimento e gestione dei gruppi
//************************************************************

function confcons() {
	
	global $id_cons_gen, $prefix, $dbi,$idw,$titolo,$pos_or,$pos_ver,$attivo;
	
	
	$aid=$_SESSION['aid'];
	$perms=ChiSei($id_cons_gen);
	if ($perms >128) {
				
		$result = mysql_query("update  ".$prefix."_ele_widget set titolo='$titolo', pos_or='$pos_or', pos_ver='$pos_ver', attivo='$attivo' where id='$idw'", $dbi) || die("Errore di aggiornamento dei dati!".mysql_error());

		Header("Location: admin.php?id_cons_gen=$id_cons_gen&op=widget");

	}
}

if ($do and $do="modify")
	confcons();

ele();

all();
echo"</td></tr></table>";
include("footer.php");

//*********************************************************************
//Funzione crea db se non esiste
//**********************************************************************

function make_db_widget(){
global $dbi,$prefix;
$result = mysql_query("CREATE TABLE IF NOT EXISTS ".$prefix."_ele_widget (
  `id` int(10) NOT NULL auto_increment,
  `nome_file` varchar(255) NOT NULL default '',
  `titolo` varchar(255) NOT NULL default '',
  `pos_or` int(1) NOT NULL default '1',
  `pos_ver` int(3) NOT NULL default '0',
 `attivo` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)",$dbi);


}


?>

