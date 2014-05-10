<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Inserimento dati                                              */
/* Amministrazione                                                      */
/************************************************************************/

if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}
$perms=ChiSei(0);
if ($perms!=256) die("Non hai i permessi per effettuare questa operazione!");

$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
if (isset($param['datafile'])) get_magic_quotes_gpc() ? $datafile=$param['datafile']:$datafile=addslashes($param['datafile']); else $datafile='';
include("modules/Elezioni/ele.php");
ele();
if (isset($_FILES['datafile']['tmp_name'])) $updfile=$_FILES['datafile']['tmp_name']; else $updfile='';
 if (!is_uploaded_file($updfile)) 
# if (!is_uploaded_file($_FILES['datafile']['tmp_name'])) 
# if (file_exists($datafile))
	{
	echo "<form name=\"restore\" enctype=\"multipart/form-data\" method=\"post\" action=\"admin.php\" >"
	."<input type=\"hidden\" name=\"op\" value=\"restore\">";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\">";
	echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"1\"><tr class=\"bggray\"><td colspan=\"2\" align=\"center\">"._SEL_DATA_FILE."</td></tr><tr><td><input name=\"datafile\" type=\"file\"></td>";
	echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._OK."\"></td></tr></table></form>";
////////////////////////////
}else{$datafile=$_FILES['datafile']['tmp_name'];
$arrFile = file($datafile);
$handle = fopen($datafile, "r");
$test=array();
$errore=0;

// Set counters
    $currentLine = 0;
    $cntFile = count($arrFile);
//    $res_comune = mysql_query("delete from ".$prefix."_ele_lista where id_cons='10'" ,$dbi); if(!$res_comune) echo "delete ".$prefix."_ele_lista where id_cons='10'--- errore di cancellazione".mysql_error();
// Write contents, inserting $item as first item
$tabs=array($prefix."_ele_cons_comune",$prefix."_ele_gruppo",$prefix."_ele_lista",$prefix."_ele_candidati",$prefix."_ele_circoscrizione",$prefix."_ele_sede",$prefix."_ele_sezioni",$prefix."_ele_link",$prefix."_ele_come",$prefix."_ele_numeri",$prefix."_ele_servizi",$prefix."_ele_voti_candidati",$prefix."_ele_voti_gruppo",$prefix."_ele_voti_lista",$prefix."_ele_voti_parziale",$prefix."_ele_voti_ref");
$x=0;
$scarto=0;
$conta=array();
    while( $currentLine <= $cntFile ){
	$appo=substr($arrFile[$currentLine],1,-2);
	$conta[$x]=0; 
	$conf=$tabs[$x];
	if ($appo==$conf){
		$currentLine++;
		while($currentLine <= $cntFile ){
			if(isset($arrFile[$currentLine])) 
				$appo=substr($arrFile[$currentLine],1,-2);
			else $appo='';
			if(isset($tabs[($x+1)])) 
				if ($appo==$tabs[($x+1)]){ $x++; break;}
			elseif($appo=='') { $x++; break;}
			$conta[$x]++;
			$currentLine++;
		}
	}else {$scarto++;$currentLine++;}
	}
if ($scarto==0){
   $currentLine = 0;
	$x=0;
	$y=0;
    while( $currentLine <= $cntFile ){
		if(isset($arrFile[$currentLine]))
			$tab=substr($arrFile[$currentLine],1,-2);
		else $tab='';
		if(isset($tabs[$x]))
			$conf=$tabs[$x];
		else $conf='';
		if ($tab==$conf){
			$currentLine++;
			while($currentLine <= $cntFile ){
#				$appo=substr($arrFile[$currentLine],1,-2);
#				if ($appo==$tabs[($x+1)]){ $x++; break;}
				if(isset($arrFile[$currentLine]))
					$appo=substr($arrFile[$currentLine],1,-2);
				else $appo='';
				if(isset($tabs[($x+1)]))
					if ($appo==$tabs[($x+1)]){ $x++; break;}
				elseif($appo=='') { $x++; break;}
				if(isset($arrFile[$currentLine]))				
					$test=explode(':',$arrFile[$currentLine]); if(!is_array($test)) {die("errore di import<br>");}
				$valori='';
				foreach($test as $key=>$val)
					if($key==0){
						$valori.= "'".base64_decode($val)."'";
						if ($y==0) {$idcns=$valori;$y++;
						foreach($tabs as $tbs){
							$res_del = mysql_query("delete from $tbs where id_cons=$idcns" ,$dbi);
							} 
						}
						if(!$res_del) die ("delete $tbs where id_cons=$idcns--- errore di cancellazione").mysql_error();
					}else $valori.= ",'".addslashes(base64_decode($val))."'";
				$res_comune = mysql_query("insert into $tab values($valori)" ,$dbi);	
				$currentLine++;
			}
		}

	}
} else $errore=1;
fclose($handle);
}
if (isset($errore))
	if ($errore) die( _MEX_RESTORE_FAILED);
	else echo _MEX_RESTORE_OK;
echo"</td></tr></table>";
include("footer.php");

?>
