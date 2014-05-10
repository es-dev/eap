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
if ($perms<32) die("Non hai i permessi per effettuare questa operazione!");

$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=intval($param['id_cons_gen']);
if (isset($param['datafile'])) get_magic_quotes_gpc() ? $datafile=$param['datafile']:$datafile=addslashes($param['datafile']); else $datafile='';
include("modules/Elezioni/ele.php");


function insgruppo()
{
global $prefix, $dbi;
global $ar_gruppo,$ar_lista,$ar_candi,$idcns;

foreach ($ar_gruppo as $rigagruppo){
	$newidg=0;
	$oldidg=0;
	foreach($rigagruppo as $key=>$campo){
		if ($key==0) $valori="'$idcns',";
		elseif ($key==1) {$valori.= "null"; $oldidg=$campo;}
		elseif ($key==6) $valori.= ",0";
		else $valori.= ",'$campo'";
		if ($key==2) $numgruppo= $campo;
	} 
	if(isset($valori)){
		$res_gruppo = mysql_query("insert into ".$prefix."_ele_gruppo values($valori)" ,$dbi)||die("(1104) Non e' stato possibile inserire i gruppi nel database! contattare l'amministratore".mysql_error());
		$resnew = mysql_query("select id_gruppo from ".$prefix."_ele_gruppo where num_gruppo='$numgruppo' and id_cons='$idcns'" ,$dbi);
		$resnew = mysql_query("select id_gruppo from ".$prefix."_ele_gruppo where num_gruppo='$numgruppo' and id_cons='$idcns'");
		list ($newidg) = mysql_fetch_row($resnew);
		unset($valori);
		if($oldidg)
			$_SESSION['gruppi']['idg_'.$oldidg]=$newidg; 
#		inslista($oldidg,$newidg);
	}
}
}

function inslista()#$oldidg,$newidg
{
global $prefix, $dbi;
global $ar_lista,$ar_candi,$idcns;

	foreach ($ar_lista as $rigalista){
		if(!isset($rigalista[3])) continue;
		$oldidl=0;
		$okl=0; 
		$oldidg=$rigalista[3];
		$newidg=$_SESSION['gruppi']['idg_'.$oldidg];
		foreach($rigalista as $key=>$campo){
			if ($key==0) $valori="'$idcns',";
			elseif ($key==1) {$valori.= "null";$oldidl=$campo;}
			elseif ($key==3) {$valori.= ",'$newidg'"; if ($campo!=$oldidg) $okl=1;}
			elseif ($key==4) $valori.= ",0"; 
			else $valori.= ",'$campo'";
			if ($key==2) $numlista= $campo;
		}
		if(isset($valori)){
		if ($okl) {$okl=0;continue;}
		$res_lista = mysql_query("insert into ".$prefix."_ele_lista values($valori)" ,$dbi)||die("(1104) Non e' stato possibile inserire le liste nel database! contattare l'amministratore".mysql_error());
		$reslnew = mysql_query("select id_lista from ".$prefix."_ele_lista where num_lista='$numlista' and id_cons='$idcns'" ,$dbi);
		list ($newidl) = mysql_fetch_row($reslnew);
		unset($valori);
		if($oldidl)
			$_SESSION['liste']['idl_'.$oldidl]=$newidl; 

#		inscandi($oldidl,$newidl);
		}
}
}

function inscandi()#$oldidl,$newidl
{
global $prefix, $dbi;
global $ar_candi,$idcns;

		foreach ($ar_candi as $rigacandi){
			if(!isset($rigacandi[2])) continue;
			$okc=0;
			$oldidl=$rigacandi[2];
			$newidl=$_SESSION['liste']['idl_'.$oldidl];
			foreach($rigacandi as $key=>$campo){#echo "$key -- $campo<br>";
				if (count($rigacandi)!=8) {unset($valori);continue;}
				if ($key==0) $valori= "null,";
				elseif ($key==1) $valori.="'$idcns',";
				elseif ($key==2) {$valori.= "'$newidl'"; if ($campo!=$oldidl) $okc=1;}
				else $valori.= ",'$campo'";
			}
			if(isset($valori)){
				if ($okc) {$okc=0;continue;}
				$res_lista = mysql_query("insert into ".$prefix."_ele_candidati values($valori)" ,$dbi)||die("(1104) Non e' stato possibile inserire i candidati nel database! contattare l'amministratore".mysql_error());
			}
		}
#foreach($_SESSION['liste'] as $key=>$val) echo "$key -- $val<br>"; 
}





$res = mysql_query("SELECT t1.id_cons, t2.descrizione FROM ".$prefix."_ele_cons_comune as t1 left join ".$prefix."_ele_consultazione as t2 on t1.id_cons_gen=t2.id_cons_gen where t1.id_comune='$id_comune' and t2.id_cons_gen='$id_cons_gen'" , $dbi);
list($id_cons,$descrizione) = mysql_fetch_row($res);
 if (!isset($_FILES['datafile']['tmp_name']) or !is_uploaded_file($_FILES['datafile']['tmp_name'])) 
	{
	ele();
	echo "<form name=\"importa\" enctype=\"multipart/form-data\" method=\"post\" action=\"admin.php\" >"
	."<input type=\"hidden\" name=\"op\" value=\"importa\">";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\">";
	echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"1\"><tr class=\"bggray\"><td colspan=\"2\" align=\"center\">"._SEL_DATA_FILE2."</td></tr><tr><td><input name=\"datafile\" type=\"file\"></td>";
	echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._OK."\"></td></tr></table></form>";
////////////////////////////
}else{
$idcns=$id_cons; 
$res_del = mysql_query("delete from ".$prefix."_ele_voti_ref where id_cons=$idcns" ,$dbi);
$res_del = mysql_query("delete from ".$prefix."_ele_voti_candidati where id_cons=$idcns" ,$dbi);
$res_del = mysql_query("delete from ".$prefix."_ele_voti_lista where id_cons=$idcns" ,$dbi);
$res_del = mysql_query("delete from ".$prefix."_ele_voti_gruppo where id_cons=$idcns" ,$dbi);
$res_del = mysql_query("update ".$prefix."_ele_sezioni set validi='0', contestati='0', validi_lista='0', nulli='0',bianchi='0',contestati_lista='0', voti_nulli_lista='0'  where id_cons=$idcns" ,$dbi);
$res_del = mysql_query("delete from ".$prefix."_ele_voti_parziale where id_cons=$idcns" ,$dbi);
$res_del = mysql_query("delete from ".$prefix."_ele_candidati where id_cons=$idcns" ,$dbi);
$res_del = mysql_query("delete from ".$prefix."_ele_lista where id_cons=$idcns" ,$dbi);
$res_del = mysql_query("delete from ".$prefix."_ele_gruppo where id_cons=$idcns" ,$dbi);
$datafile=$_FILES['datafile']['tmp_name'];
$arrFile = file($datafile);
$handle = fopen($datafile, "r");
$test=array();
$errore=0;
$fine=0;
$numgruppo=0;
$numlista=0;
// Set counters
    $currentLine = 0;
    $cntFile = count($arrFile);
$tabs=array($prefix."_ele_gruppo",$prefix."_ele_lista",$prefix."_ele_candidati",$prefix."_ele_circoscrizione");
$x=0;$k=0;
$scarto=0;
$primog=0;
$primol=0;
$conta=array();
   $currentLine = 0;
	$x=0;$k=0;
	$y=0;
$ar_gruppo=array(array());
$ar_lista=array(array());
$ar_candi=array(array());
		$z=0;
		$tab=substr($arrFile[$currentLine],1,-2);
		$conf=$tabs[$x];
if($k==0) {while (substr($arrFile[$currentLine],1,-2)!=$conf and $currentLine <= $cntFile) $currentLine++; $k++;}
			$currentLine++;
			while($currentLine <= $cntFile and $fine==0){
#				$appo=substr($arrFile[$currentLine],1,-2);
				if(isset($arrFile[$currentLine])) 
					$appo=substr($arrFile[$currentLine],1,-2);
				else $appo='';
				if (isset($tabs[($x+1)]) and $appo==$tabs[($x+1)]){ $x++;$conf=$tabs[$x];$currentLine++; continue;}
				$test=explode(':',$appo); if(!is_array($test)) {die("errore di import<br>");}
				foreach($test as $key=>$val) 
						if ($conf==$prefix."_ele_gruppo"){
							$ar_gruppo[$z][$key]=addslashes(base64_decode($val));}
						elseif ($conf==$prefix."_ele_lista"){
							if($primog==0){
								$gruppofil= array_filter($ar_gruppo);
								$numgruppo=count($gruppofil);
								insgruppo();
								$primog=1;
								unset($ar_gruppo);
							}
							$ar_lista[$z][$key]=addslashes(base64_decode($val));}
						elseif ($conf==$prefix."_ele_candidati"){
							if($primog==0){
								$gruppofil= array_filter($ar_gruppo);
								$numgruppo=count($gruppofil);
								insgruppo();
								$primog=1;
								unset($ar_gruppo);
							}
							elseif($primol==0){
								$listafil= array_filter($ar_lista);
								$numlista=count($listafil);
								inslista();
								$primol=1;
								unset($ar_lista);
							}
							$ar_candi[$z][$key]=addslashes(base64_decode($val));
						}
						elseif ($conf==$prefix."_ele_circoscrizione"){
							if($primog==0){
								$gruppofil= array_filter($ar_gruppo);
								$numgruppo=count($gruppofil);
								insgruppo();
								$primog=1;
								unset($ar_gruppo);
							}
							elseif($primol==0){
								$listafil= array_filter($ar_lista);
								$numlista=count($listafil);
								inslista();
								$primol=1;
								unset($ar_lista);
							}else{
								inscandi();
								unset($ar_candi);
								$fine=1;
								break;
							}
						}
				$currentLine++;
				$z++;
			}
fclose($handle);



if ($numgruppo){
#	insgruppo();
	Header("Location: admin.php?op=gruppo&id_cons_gen=$id_cons_gen");
	}
elseif ($numlista) {
	inslista(0,0);
	Header("Location: admin.php?op=lista&id_cons_gen=$id_cons_gen");
	}
else Header("Location: admin.php?op=lista&id_cons_gen=$id_cons_gen");

}

echo"</td></tr></table>";
include("footer.php");











/*
foreach ($ar_gruppo as $rigagruppo){
	$newidg=0;
	$oldidg=0;
	foreach($rigagruppo as $key=>$campo){
		if ($key==0) $valori="'$idcns',";
		elseif ($key==1) {$valori.= "null"; $oldidg=$campo;}
		elseif ($key==6) $valori.= ",0";
		else $valori.= ",'$campo'";
		if ($key==2) $numgruppo= $campo;
	} 
	if(isset($valori)){
	$res_gruppo = mysql_query("insert into ".$prefix."_ele_gruppo values($valori)" ,$dbi)||die("(1104) Non e' stato possibile inserire i gruppi nel database! contattare l'amministratore".mysql_error());
	$resnew = mysql_query("select id_gruppo from ".$prefix."_ele_gruppo where num_gruppo='$numgruppo' and id_cons='$idcns'" ,$dbi);
	list ($newidg) = mysql_fetch_row($resnew);
	unset($valori);
	foreach ($ar_lista as $rigalista){
		$oldidl=0;
		foreach($rigalista as $key=>$campo){
			if ($key==0) $valori="'$idcns',";
			elseif ($key==1) {$valori.= "null";$oldidl=$campo;}
			elseif ($key==3) {$valori.= ",'$newidg'"; if ($campo!=$oldidg) $okl=1;}
			elseif ($key==4) $valori.= ",0"; 
			else $valori.= ",'$campo'";
			if ($key==2) $numlista= $campo;
		}
		if(isset($valori)){
		if ($okl) {$okl=0;continue;}
		$res_lista = mysql_query("insert into ".$prefix."_ele_lista values($valori)" ,$dbi)||die("(1104) Non e' stato possibile inserire le liste nel database! contattare l'amministratore".mysql_error());
		$reslnew = mysql_query("select id_lista from ".$prefix."_ele_lista where num_lista='$numlista' and id_cons='$idcns'" ,$dbi);
		list ($newidl) = mysql_fetch_row($reslnew);
		unset($valori);
		foreach ($ar_candi as $rigacandi){
			foreach($rigacandi as $key=>$campo){if (count($rigacandi)!=8) {unset($valori);continue;}
				if ($key==0) $valori= "null,";
				elseif ($key==1) $valori.="'$idcns',";
				elseif ($key==2) {$valori.= "'$newidl'"; if ($campo!=$oldidl) $okc=1;}
				else $valori.= ",'$campo'";
			}
			if(isset($valori)){
				if ($okc) {$okc=0;continue;}
				$res_lista = mysql_query("insert into ".$prefix."_ele_candidati values($valori)" ,$dbi)||die("(1104) Non e' stato possibile inserire i candidati nel database! contattare l'amministratore".mysql_error());
			}
		}
		}
	}
	}
}	
*/

?>
