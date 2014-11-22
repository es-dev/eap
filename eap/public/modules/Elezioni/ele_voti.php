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
$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$currentlang=$_SESSION['lang'];
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$vari= implode(',',$_GET);//param);
$id_comune=$_SESSION['id_comune'];
$id_cons_gen=intval($_GET['id_cons_gen']);
$perms=ChiSei($id_cons_gen);
if ($perms<16 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");

$res = mysql_query("SELECT tipo_cons FROM ".$prefix."_ele_consultazione where id_cons_gen='$id_cons_gen'" , $dbi);
list($tipo_cons) = mysql_fetch_row($res);
if ($tipo_cons!=3) $limite=0; #die ("limite: $limite");}
if (isset($_GET['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
//if (isset($param['id_cons'])) $id_cons=intval($param['id_cons']); else $id_cons='';
if (isset($param['ops'])) $ops=intval($param['ops']); else $ops='';
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['ok'])) $ok=intval($param['ok']); else $ok='';
if (isset($param['ov'])) $ov=intval($param['ov']); else $ov='';
if (isset($param['mv'])) $mv=intval($param['mv']); else $mv='';
if (isset($param['gv'])) $gv=intval($param['gv']); else $gv='';
if (isset($param['msv'])) $msv=intval($param['msv']); else $msv='';
if (isset($param['av'])) $av=intval($param['av']); else $av='';
if (isset($param['id_circ'])) $id_circ=intval($param['id_circ']); else
	if (isset($_SESSION['id_circ'])) $id_circ=intval($_SESSION['id_circ']); else $id_circ='';
if (isset($param['id_sede'])) $id_sede=intval($param['id_sede']); else $id_sede='';
if (isset($param['id_sez'])) $id_sez=intval($param['id_sez']); else $id_sez='';
if (isset($param['id_lista'])) $id_lista=intval($param['id_lista']); else $id_lista='';
if (isset($param['prev_sez'])) $prev_sez=intval($param['prev_sez']); else $prev_sez='';
if (isset($param['id_gruppo'])) $id_gruppo=intval($param['id_gruppo']); else $id_gruppo='';
include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
$res = mysql_query("SELECT count(id_circ) FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons' ", $dbi);
list($num_circ)=mysql_fetch_row($res);
if ($conscirc){  // or $num_circ==1
	if (!$id_circ){
		$res = mysql_query("SELECT id_circ FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons' order by num_circ limit 0,1", $dbi);
		if (!$res) die("Errore, non trovo circoscrizioni inserite! Consultare l'amministratore");
		list($id_circ)=mysql_fetch_row($res);
		$_SESSION['id_circ']=$id_circ;
	}
	$result = mysql_query("select id_sede from ".$prefix."_ele_sede where id_circ='$id_circ'", $dbi);
	$i=0;
	while(list($tmp) = mysql_fetch_row($result)) $idsedi[$i++]=$tmp;$tmp=implode (",",$idsedi);
	unset($idsedi);$i=0;$idsezi=array();unset($result);
	$result = mysql_query("SELECT id_sez FROM ".$prefix."_ele_sezioni where id_sede in ($tmp)", $dbi);
	unset($tmp);
	while(list($tmp) = mysql_fetch_row($result)) $idsezi[$i++]=$tmp;
	$tmp=implode (",",$idsezi);
	$sezi = "and id_sez in ($tmp)";
	$circo = "and id_circ='$id_circ'";
}else{
	$sezi='';
	$circo='';
}



// Offset - visualizza il numero di elementi per pagina
$offset=2;
if (!isset($min)) $min=0;
$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";

function numeri_sezione() {
// tabella visualizzazione sezioni per numero
global $aid,$bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min, $tipo_cons, $genere,$id_cons_gen,$id_cons,$id_lista,$ops, $perms,$id_sez;
//	$ressup = mysql_query("select permessi from ".$prefix."_ele_operatori where aid='$aid'",$dbi);
//	list ($perms)=mysql_fetch_row($ressup);
	//if ($perms>16) { // tolto per guidonia
		$res = mysql_query("SELECT num_sez, id_sez ,id_sede FROM ".$prefix."_ele_sezioni where id_cons='$id_cons' order by num_sez", $dbi);
		$max = mysql_num_rows($res);
		echo "\n<table align=\"left\" border=\"0\" width=\"90%\"><tr bgcolor=\"$bgcolor1\">";
		//if ($max>=64){
		$i=0;
		while(list($sez_num, $sez_id ,$sede_id) = mysql_fetch_row($res)) {
			$i++;
			$result = mysql_query("SELECT id_circ FROM ".$prefix."_ele_sede where id_cons='$id_cons' and id_sede='$sede_id' ", $dbi);
			list($circ_id) = mysql_fetch_row($result);
			//clora la sezione
			$res2= mysql_query("SELECT num_sez FROM ".$prefix."_ele_sezioni where id_sez='$id_sez'", $dbi);
			list($numero_sez) = mysql_fetch_row($res2);
			if ($sez_num==$numero_sez) {$bgsez="#FFFF00";}else{$bgsez="";}
			echo "\n<td align=\"center\" width=\"5%\" bgcolor=\"$bgsez\"><b><a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_circ=$circ_id&amp;id_sede=$sede_id&amp;id_sez=$sez_id&amp;ops=$ops&amp;do=spoglio&amp;id_lista=$id_lista\">$sez_num</a></b></td>\n";
			if (($i%8) ==0) echo "</tr>\n<tr bgcolor=\"$bgcolor1\">";
		}
		//}
		echo "<td></td></tr></table>\n";
		
	echo"</td></tr></table>";
	//}// fine tabella per numero sezioni
	// inizio tabella centrale
        echo "\n</td><td valign=\"top\" align=\"left\">";
}
///////////////////////////////////////////////////////////////////////////////////


function voti($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops,$ov,$mv,$gv,$msv,$av,$id_lista) {
   	global $aid,$bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min, $tipo_cons, $genere,$id_cons_gen,$prev_sez,$votog,$votol,$votoc,$conscirc;

   	echo "<table border=\"0\" width=\"100%\"  align=\"left\"><tr>";
    	echo "\n<td bgcolor=\"$bgcolor1\" align=\"left\">";
	//echo "<h6>";
	///////////////////////
	// Circoscrizione : scelta
	///////////////////////

	$resoper=mysql_query("SELECT t1.id_sede,t2.id_circ FROM ".$prefix."_ele_operatori as t1,
			 ".$prefix."_ele_sede as t2 
			 where t1.id_cons='$id_cons' AND t1.id_sede=t2.id_sede and t1.aid='$aid'", $dbi);
	list($id_sede2,$id_circ2) = mysql_fetch_row($resoper);
	if ($id_sede2 and !($id_sede==$id_sede2)) {
		$id_sede=$id_sede2;
		$id_circ=$id_circ2;
		$do="spoglio";
		$res= mysql_query("SELECT id_sez FROM ".$prefix."_ele_sezioni where id_cons='$id_cons' and id_sede=$id_sede order by num_sez limit 0,1", $dbi);
		list($id_sez) = mysql_fetch_row($res);
	}
	if  ($do == "circo") {
		OpenTable();
		echo "<tr><td><form name=\"voti\" action=\"admin.php\">"
      		."<input type=\"hidden\" name=\"op\" value=\"voti\">"
      		."<input type=\"hidden\" name=\"do\" value=\"sede\">"
		// Circoscrizione: lista
		//**************************************
		.""._CIRCO.": "
		."<select name=\"id_circ\">";
		$res= mysql_query("SELECT id_circ,descrizione FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons' order by num_circ", $dbi);
        	while(list($id,$descr) = mysql_fetch_row($res)) {
        		if ($descr!="Tutte"){
        			if ($id == $id_circ) {
		     			$sel = "selected";
	        		} else {
		     			$sel = "";
	          		}
			 	echo "<option value=\"$id\" $sel>$descr";
      			}
		}
    		echo "</select>"
		//***********************************
      		."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
      		."<input type=\"submit\" name=\"update\" value=\""._OK."\">"
      		."</form></td></tr>";
      		CloseTable();
  	}

	///////////////////////
	// sede : scelta
	///////////////////////


	if ($do == "sede") {
		OpenTable();
 		echo "\n<tr><td><form name=\"sede\" action=\"admin.php\">";
		$res= mysql_query("SELECT  descrizione FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons' AND id_circ='$id_circ' order by num_circ", $dbi);
        	list( $descr_circ) = mysql_fetch_row($res);
		echo "<a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;do=circo\">"._CIRCO."</a> $descr_circ ->";
      		echo "<input type=\"hidden\" name=\"op\" value=\"voti\">"
      		."<input type=\"hidden\" name=\"do\" value=\"spoglio\">"

	// Indirizzo: lista
	//**************************************
		.""._INDIRIZZO.": "
		."<select name=\"id_sede\">";
		$res= mysql_query("SELECT id_sede,indirizzo FROM ".$prefix."_ele_sede where id_cons='$id_cons' and id_circ='$id_circ' order by indirizzo", $dbi);
//        	echo "$id_circ - $id_cons";
		while(list($id,$indir) = mysql_fetch_row($res)) {
        		if ($id == $id_sede) {
		     		$sel = "selected";
	          	} else {
		     		$sel = "";
	          	}
	 		echo "<option value=\"$id\" $sel>$indir";
      		}
    		echo "</select>"
	//*************************************
      		."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
      		."<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">"
      		."<input type=\"submit\" name=\"update\" value=\""._OK."\">"
      		."</form></td></tr>\n";
		CloseTable();
	}

	///////////////////////
	// sezione : scelta
	///////////////////////
	if ($do == "spoglio") {
		echo "\n<form name=\"sezione\" action=\"admin.php\">";
		OpenTable();
		echo "<tr><td>";
		$res= mysql_query("SELECT descrizione FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons' AND id_circ='$id_circ' order by num_circ", $dbi);
        	list($descr_circ) = mysql_fetch_row($res);
        	$res= mysql_query("SELECT indirizzo FROM ".$prefix."_ele_sede where id_cons='$id_cons' AND id_sede='$id_sede' order by indirizzo", $dbi);
        	list($indir) = mysql_fetch_row($res);
		echo "<input type=\"hidden\" name=\"pag_sez\" value=\"admin.php?op=voti&amp;do=spoglio&amp;ops=$ops&amp;id_cons_gen=$id_cons_gen&amp;id_circ=$id_circ&amp;id_sede=$id_sede&amp;id_lista=$id_lista&amp;id_sez=\">";
		echo "<a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;do=circo\">"._CIRCO."</a> $descr_circ ->
		<a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_circ=$id_circ&amp;do=sede\">"._INDIRIZZO."</a> $indir ->
			<input type=\"hidden\" name=\"op\" value=\"voti\">
		<input type=\"hidden\" name=\"do\" value=\"spoglio\">"
	// Sezioni:lista
	//**************************************
		."<b>"._SEZIONE."</b>: "
		."<select name=\"id_sez\" onChange=\"top.location.href=this.form.pag_sez.value+this.form.id_sez.options[this.form.id_sez.selectedIndex].value;return false\">";
		$res= mysql_query("SELECT id_sez,num_sez FROM ".$prefix."_ele_sezioni where id_cons='$id_cons' and id_sede='$id_sede' order by num_sez", $dbi);
		$rif_sez=0;
		$next_sez=0;
		unset($prev_sez);
		while(list($id,$num) = mysql_fetch_row($res)) {
			if (!($id_sez>0)) {$id_sez=$id;}
			if ($id == $id_sez) {
				$sel = "selected";
				$prev_sez=$rif_sez;
			} else {
				$sel = "";
				if (isset($prev_sez) and ($next_sez==0)) { $next_sez=$id;}
				$rif_sez=$id;
			}
			echo "<option value=\"$id\" $sel>$num";
		}
		echo "</select>"
	//*************************************
		."<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">\n"
		."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">\n"
		."<input type=\"hidden\" name=\"id_sede\" value=\"$id_sede\">\n"
		."<input type=\"hidden\" name=\"ops\" value=\"$ops\">\n"
		."&nbsp;&nbsp;<input type=\"submit\" name=\"update\" value=\""._OK."\">\n";
		if ($prev_sez) {
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;do=spoglio&amp;id_circ=$id_circ&amp;id_sede=$id_sede&amp;id_sez=$prev_sez&amp;ops=$ops&amp;id_lista=$id_lista\">"._PREV."</a>&nbsp;&nbsp;&nbsp;&nbsp;\n";
		}else {echo "      <span style=\"color: rgb(204, 204, 204);\">"._PREV."</span>      ";}
		if ($next_sez) {
			echo "<a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;do=spoglio&amp;id_circ=$id_circ&amp;id_sede=$id_sede&amp;id_sez=$next_sez&amp;ops=$ops&amp;id_lista=$id_lista\">"._NEXT."</a>\n";
		}else {echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color: rgb(204, 204, 204);\">"._NEXT."</span>\n";}
     		echo "\n</td></tr>";
		CloseTable();

      		echo "</form>\n";
    		echo "\n</td></tr><tr><td>\n";
//    		echo "\n</td></tr></table>\n";


	//************************************
	// Menu spoglio
	//************************************
     		$result = mysql_query("select id_cons,id_sez,id_sede,num_sez, maschi, femmine  from ".$prefix."_ele_sezioni where id_cons='$id_cons' and id_sez='$id_sez'", $dbi);
     		list($id_cons2,$id_sez2,$id_sede,$num_sez, $maschi, $femmine) = mysql_fetch_row($result);

		//$bgcolor1="#b0b0b0";
   		echo "<table border=\"0\" width=\"60%\"  align=\"center\"><tr>";
    		echo "\n<td bgcolor=\"$bgcolor1\" align=\"center\"><b><a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_sez=$id_sez&amp;id_circ=$id_circ&amp;id_sede=$id_sede&amp;do=spoglio&amp;ops=1\">"._AFFLUENZE."</a></b></td>\n";
		if(!($genere==4) and !($votog)){ //if(!($genere==4) and !($tipo_cons==10 or $tipo_cons==11)){
			echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b><a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_sez=$id_sez&amp;id_circ=$id_circ&amp;id_sede=$id_sede&amp;do=spoglio&amp;ops=4\">"._GRUPPO."</a></b></td>\n";
		}
		if(($genere>2 or $votog)){ //if(($genere>2 or $tipo_cons==10 or $tipo_cons==11)){
			echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b><a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_sez=$id_sez&amp;id_circ=$id_circ&amp;id_sede=$id_sede&amp;do=spoglio&amp;ops=3\">"._PREFLISTA."</a></b></td>\n";
		}
    		echo "</tr></table>\n";
//    		echo "\n</td></tr></table>\n";


	///////////////////////////////////////////
	// opzioni per le funzioni di immissione

   		if ($ops == 1) {
     			votanti($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops,$ov,$mv,$gv,$msv,$av);
   		}
	/*
   		if ($ops == 2) {
     			finale($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops);
   		}
	*/
    		if ($ops == 3) {
     			preferenze($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops);
   		}
    		if ($ops == 4) {
     			preferenze_gruppi($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops);
                  
   		}

	}
		CloseTable();

}
////////////////////////////////////////////////////////////////////////////////
//   FUNZIONI DI IMMISSIONE
//   - preferenze (candidati consiglieri)
//   - preferenze_gruppi
//   - votanti
////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////
// da qui va la sezione per le preferenze candidati consiglieri
//////////////////////////////////////////////////////////////////////
function preferenze($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops){
 	global $aid, $prefix, $dbi, $id_lista,$genere,$id_cons_gen,$id_gruppo,$sezi,$circo,$votog,$votol,$votoc,$conscirc;
global $tipo_cons,$fascia,$limite;
$bgcolor1="#7777ff";
$bgcolor2=$_SESSION['bgcolor2'];
    //controlla se sono stati inseriti i votanti
if(!$votog and ($genere==3 or $genere==5))
	$result = mysql_query("select validi_lista,nulli,bianchi,contestati_lista,voti_nulli_lista from ".$prefix."_ele_sezioni where id_cons='$id_cons' and id_sez='$id_sez' ", $dbi);
else
	$result = mysql_query("select validi,nulli,bianchi,contestati,voti_nulli from ".$prefix."_ele_sezioni where id_cons='$id_cons' and id_sez='$id_sez' ", $dbi);
#e
    list($validi,$nulli,$bianchi,$contestati,$votinulli) = mysql_fetch_row($result);
#	if ($validi+$nulli+$bianchi) die("entra($genere==3) OR ($genere==5)) and !$id_lista and ($fascia>$limite)");
		echo "<table border=\"0\" width=\"100%\" align=\"center\"><tr>";
		$res_lis = mysql_query("SELECT id_lista, descrizione,num_lista from ".$prefix."_ele_lista where id_cons=$id_cons $circo order by num_lista",$dbi);
		$num_liste = mysql_num_rows($res_lis);
		$ele_lista='';
		if (($genere==4 or $genere==5) and !$votoc) { //liste a piu' candidati
			if($fascia<=$limite and !$id_lista) {
				$result = mysql_query("SELECT id_lista from ".$prefix."_ele_lista where id_cons=$id_cons limit 0,1",$dbi);
				list($id_lista)=mysql_fetch_row($result);
			}
			echo "<td>&nbsp;</td></tr><tr><td style=\"vertical-align: top;\">";
			echo "<form name=\"liste\" action=\"admin.php\">";
			echo "<input type=\"hidden\" name=\"pag\" value=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_sez=$id_sez&amp;id_circ=$id_circ&amp;id_sede=$id_sede&amp;do=spoglio&amp;ops=3&amp;id_lista=\">";
			echo "<select name=\"id_lista\" size=\"".($num_liste+1)."\" onChange=\"vai_lista()\">";
			if ($id_lista){
				echo "<option value=\"0\">"._VOTI_LISTA;
				$ele_lista=" and t1.id_lista='$id_lista' ";
			}else{
				echo "<option value=\"0\" selected>"._VOTI_LISTA;
				$ele_lista=" group by t1.id_lista ";

			}
			while(list($id_rif,$descrizione,$num_lis) = mysql_fetch_row($res_lis)) {
				$sel = ($id_rif == $id_lista) ? "selected" : "";
				echo "<option value=\"$id_rif\" $sel>";
				for ($j=strlen($num_lis);$j<2;$j++) { echo "&nbsp;&nbsp;";}
				echo $num_lis.") ".substr($descrizione,0,30);
			}
			echo "</select></form></td>\n";
		}else {
			$id_lista=0;
		}
		echo "<td style=\"vertical-align: top;\">";

		if ((!$id_lista)){$tab="_ele_voti_lista";} else {$tab="_ele_voti_candidati";}
###############prova
if($genere==4 and !$id_lista)	
		$result = mysql_query("SELECT sum(t1.voti),t2.validi, t2.solo_gruppo,t2.contestati,t2.voti_nulli from ".$prefix."_ele_sezioni as t2 left join ".$prefix.$tab." as t1 on (t1.id_sez=t2.id_sez) where t2.id_sez=$id_sez group by t1.id_sez",$dbi);
else
		$result = mysql_query("SELECT sum(t1.voti),t2.validi_lista, t2.solo_gruppo,t2.contestati,t2.voti_nulli from ".$prefix."_ele_sezioni as t2 left join ".$prefix.$tab." as t1 on (t1.id_sez=t2.id_sez) where t2.id_sez=$id_sez group by t1.id_sez",$dbi);
		list( $voti_sez, $validi2, $sg,$cont2,$vnulli2) = mysql_fetch_row($result);
		if(!$id_lista or $genere==3){	//controllo di congruenza
			$res2 = mysql_query("SELECT max(voti_complessivi) FROM ".$prefix."_ele_voti_parziale where id_cons='$id_cons' and id_sez='$id_sez'", $dbi);
			list($tot) = mysql_fetch_row($res2);
			if ($validi+$nulli+$bianchi+$contestati+$votinulli+$sg!=$tot and $validi+$sg>0){
				echo "<table border=\"0\" width=\"50%\"  align=\"center\"><tr><td style=\"background-color: rgb(255, 0, 0); align=center\"><img src=\"modules/Elezioni/images/alert.gif\" align=\"middle\" alt=\"\"><br><b> "._ATT_VOTANTI." ".$tot." "._NO_TOT_VOTI." ".($validi+$nulli+$bianchi+$contestati+$votinulli+$sg)."</b><br></td></table>";
			}

			if((($voti_sez)!=$validi2) and ($voti_sez>0)){
				echo "<table border=\"0\" width=\"50%\"  align=\"center\"><tr><td style=\"background-color: rgb(255, 0, 0); align=center\"><img src=\"modules/Elezioni/images/alert.gif\" align=\"middle\" alt=\"\"><br><b> "._ATT_VOTI." ".($voti_sez)." "._NO_VAL_VOTI." ".$validi2."</b><br></td></tr></table>";
			}
		}



		echo "\n<form name=\"sezioni\" action=\"admin.php\">"
		."<input type=\"hidden\" name=\"op\" value=\"rec_voti\">"
		."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
		."<input type=\"hidden\" name=\"id_sez\" value=\"$id_sez\">"
		."<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">"
		."<input type=\"hidden\" name=\"id_sede\" value=\"$id_sede\">"
		."<input type=\"hidden\" name=\"tabella\" value=\"$tab\">"
		."<input type=\"hidden\" name=\"id_lista\" value=\"$id_lista\">\n";
		echo "<table border=\"0\" width=\"90%\"  align=\"center\">";
		echo "<tr><td bgcolor=\"$bgcolor1\" align=\"left\" width=\"32\">";
		if ($genere<4){
//			echo "<td bgcolor=\"$bgcolor1\" align=\"center\" width=\"32\"><b>"._LISTA."</b></td>";
		}
		echo "<b>"._NUM."</b></td>";
		if($id_lista){
			echo "<td bgcolor=\"$bgcolor1\" align=\"left\"><b>"._CANDIDATO."</b></td>"
			."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._VOTI."</b></td>";
		}else{
			echo "<td bgcolor=\"$bgcolor1\" align=\"left\"><b>"._DESCR."</b></td>"
			."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._VOTI."</b></td>";
		}
		echo "</tr>\n";





		$result = mysql_query("select t1.* from ".$prefix."_ele_candidati as t1 left join ".$prefix."_ele_lista as t2 on (t1.id_lista=t2.id_lista) WHERE t1.id_cons=$id_cons and t1.id_cons=t2.id_cons $ele_lista ORDER BY t2.num_lista,t1.num_cand", $dbi);
		$max = mysql_num_rows($result);
		$tot_pref=0;
		$i=1;

		if($id_lista) {
			while(list($id_cand,$id_cons2,$id_lista2, $cognome, $nome, $note, $simbolo, $num_cand) = mysql_fetch_row($result)){
				// dati lista
				$result1 = mysql_query("select id_lista, descrizione,simbolo,num_lista from ".$prefix."_ele_lista where id_lista='$id_lista2'", $dbi);
				list($id_lista3,$descr_lista,$simb_lista,$num_lista)=mysql_fetch_row($result1);
			// dati gruppo
				$result2 = mysql_query("select descrizione,simbolo from ".$prefix."_ele_gruppo where id_gruppo='$id_gruppo'", $dbi);
				list($descr_gruppo,$simb_gruppo)=mysql_fetch_row($result2);
				
				echo "<tr bgcolor=\"$bgcolor2\">";
				if ($genere<4){
					echo "<td align=\"left\"><b><img src=\"images/lista/$simb_lista \" width=\"32\" heigth=\"32\" align=\"center\" ALT=\"$descr_lista\" > </b></td>";
				}
				echo "<td align=\"center\"><b> $num_cand </b></td>"
				."<td align=\"left\"><b>$cognome $nome</b></td>";
				$cond_sele="and id_cand=$id_cand";
				$res = mysql_query("SELECT * FROM ".$prefix."$tab where id_cons='$id_cons' and id_sez='$id_sez' $cond_sele", $dbi);
				$pro= mysql_fetch_array($res, 3);
				echo "<td align=\"right\"><input  name=\"voti$i\" value=\"".$pro['voti']."\" size=\"7\" >";
				echo "<input type=\"hidden\" name=\"id_cand$i\" value=\"$id_cand\"></td></tr>\n";
				$i++;
				$tot_pref+=$pro['voti'];
			} 
		}else {
			$result1 = mysql_query("select t2.voti,t1.id_lista, descrizione,simbolo,num_lista 
			from ".$prefix."_ele_lista as t1, ".$prefix."_ele_voti_lista as t2
			where t1.id_cons='$id_cons' 
			and t1.id_lista=t2.id_lista
			and t2.id_sez=$id_sez
			order by t1.num_lista", $dbi);
			$num_lista=mysql_num_rows($result1);
			if (!$num_lista){
				$result1 = mysql_query("select '',t1.id_lista, descrizione,simbolo,num_lista
				from ".$prefix."_ele_lista as t1 where t1.id_cons='$id_cons' $circo
				order by t1.num_lista", $dbi);
			}
			while (list($pro['voti'],$id_lista3,$descr_lista,$simb_lista,$num_lista)=mysql_fetch_row($result1)){
				echo "<tr bgcolor=\"$bgcolor2\">";
//				if ($genere<4 or $votoc){
//				}

				echo "<td align=\"center\"><b> $num_lista </b></td>"
				."<td align=\"left\"><b> $descr_lista</b></td>";
				$cond_sele="and id_lista=$id_lista3";
				echo "<td align=\"right\"><input  name=\"voti$i\" value=\"".$pro['voti']."\" size=\"7\" >";
				echo "<input type=\"hidden\" name=\"id_lista$i\" value=\"$id_lista3\"></td></tr>\n";
				$i++;
				$tot_pref+=$pro['voti'];
			}
		}
		echo "<tr bgcolor=\"$bgcolor1\"><td></td><td>"._TOTPREF."</td><td align=\"center\">$tot_pref</td></tr>";
		// toglie ai candidati la visual... del solo_gruppo 
		if(!$votog) {
		   if (($genere==3 OR $genere==5) and (!$id_lista) and ($fascia>$limite)) { //gruppo e liste
			echo "<tr bgcolor=\"$bgcolor2\"><td></td><td><b>"._SOLO_GRUPPO."</b></td><td align=\"center\"><input type=\"hidden\" name=\"id_sez\" value=\"$id_sez\"><input name=\"sg\" value=\"$sg\" size=\"5\"></td></tr>";
			echo "<tr bgcolor=\"$bgcolor2\"><td></td><td><b>"._NULLI_LISTE."</b></td><td align=\"center\"><input  name=\"votinulli\" value=\"$votinulli\" size=\"5\">"
	."</td></tr><tr bgcolor=\"$bgcolor2\"><td></td><td><b>"._CONTESTATI_LISTE."</b></td><td align=\"center\"><input  name=\"contestati\" value=\"$contestati\" size=\"5\"></td></tr>";
			
		   }elseif (($genere==3 OR $genere==5) and !$votoc and $fascia>$limite){ //}elseif ($tipo_cons!=10 and $tipo_cons!=11){
			echo "<tr bgcolor=\"$bgcolor1\"><td></td><td><b>"._SOLO_GRUPPO."</b></td><td align=\"center\">$sg</td></tr>";
		   }
######modifica del 16-04-2009 per visualizzare i voti al solo sindaco nei comuni con meno di 15000 abitanti
elseif(($genere==3 OR $genere==5) and ($id_lista) and ($fascia<=$limite)) {
$resvg = mysql_query("SELECT id_gruppo FROM ".$prefix."_ele_lista where id_lista='$id_lista'", $dbi);
list($id_gruppo) = mysql_fetch_row($resvg);
$resvg = mysql_query("SELECT sum(voti) FROM ".$prefix."_ele_voti_gruppo where id_gruppo='$id_gruppo' and id_sez='$id_sez'", $dbi);
        list($voti_sind) = mysql_fetch_row($resvg);

echo "<tr bgcolor=\"$bgcolor1\"><td></td><td><b>"._SOLO_GRUPPO."</b></td><td align=\"center\">".($voti_sind - $tot_pref)."</td></tr>";
}
###### fine modifica del 16-04-2009

	}
		echo "<tr><td></td><td></td><td align=\"center\"><input type=\"submit\" name=\"update\" value=\" "._OK. "\"></td>";
		echo "</tr></table></form></tr></table>";
		echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n"
		."document.sezioni.voti1.focus()\n"
		."document.sezioni.voti1.select()\n"
		."//-->\n";
		echo "function vai_lista() {\n";
		echo "window.document.location.href=document.liste.pag.value+document.liste.id_lista.value\n";
		echo "}\n";
		echo "</script>\n";
#	}
if (!((!$votog) and ($genere==3 OR $genere==5) and ($fascia>$limite)))
	finale($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops);
 }

/////////////////////////////////////////////
// registra le preferenze ai candidati
/////////////////////////////////////////////

function rec_voti() {
	global $prefix, $dbi,$aid,$id_cons,$ops,$genere,$votog,$fileout,$id_comune,$limite;
	$sqlcomu="select fascia from ".$prefix."_ele_comuni where id_comune='$id_comune'";
	$res = mysql_query($sqlcomu);
	list($fascia)=mysql_fetch_row($res);

	if ($fileout) while (!$fp = fopen($fileout,"a"));
	$username=$aid;
	$log_data= date("Y/m/d");
	$log_ora=getdate(time());
	$orario=($log_ora['hours'].":".$log_ora['minutes'].":".$log_ora['seconds']);
	$arg2 = func_get_args();
	$arg = split(",",$arg2[0]);
	$id_cons_gen=intval($arg[1]);
	$id_sez = intval($arg[2]);
	$id_circ = intval($arg[3]);
	$id_sede = intval($arg[4]);
	$tab = $arg[5];
	$id_lista = intval($arg[6]);
	if ($tab=="_ele_voti_candidati") {
		$condizione="id_cand";
	}else{
		$condizione="id_lista";
	}
	if ((($genere==3) OR ($genere==5)) and !$id_lista and !$votog and ($fascia>$limite)) $y = (count($arg)-4);
	else $y=count($arg);
	for($i=7,$y--;$i< $y;$i++) {
		$voti = intval($arg[$i++]);
		$id_cand = intval($arg[$i]);
		$result = mysql_query("select * from ".$prefix."$tab where id_cons='$id_cons' and id_sez='$id_sez' and $condizione='$id_cand'", $dbi);
        	$ar=mysql_fetch_array($result);
		if ($ar){
			if ($ar['voti']!=$voti) {
				mysql_query("update  ".$prefix."$tab set voti='$voti' where id_cons='$id_cons' and id_sez='$id_sez' and $condizione='$id_cand'", $dbi);
				if ($fileout) fwrite($fp,"update  ".$prefix."$tab set voti='$voti' where id_cons='$id_cons' and id_sez='$id_sez' and $condizione='$id_cand';\n");
	        	mysql_query("insert into ".$prefix."_ele_log values('$id_cons','$id_sez','$username','$log_data','$orario','voti=".$ar['voti']."','$condizione:$id_cand voti: $voti','$tab')", $dbi);
			}
		} else {
			if ($voti)
	    		mysql_query("insert into ".$prefix."_ele_log values('$id_cons','$id_sez','$username','$log_data','$orario',' ','$condizione:$id_cand voti: $voti','$tab')", $dbi);
			mysql_query("insert into ".$prefix."$tab values ('$id_cons', '$id_cand','$id_sez','$voti')", $dbi);
			if ($fileout) fwrite($fp,"insert into ".$prefix."$tab values ('$id_cons', '$id_cand','$id_sez','$voti');\n");
		}
	}
//		foreach ($arg as $vval) echo $vval." - ";
	// solo gruppo e preferenze alle liste
	if(!$votog) {
	   if ((($genere==3) OR ($genere==5)) and !$id_lista and ($fascia>$limite)) {
			$result = mysql_query("update ".$prefix."_ele_sezioni set solo_gruppo='".$arg[$i]."' where id_sez='$id_sez'",$dbi);
			if ($fileout) fwrite($fp,"update ".$prefix."_ele_sezioni set solo_gruppo='".$arg[$i]."' where id_sez='$id_sez';\n");
			if ($condizione=="id_lista"){
				$result = mysql_query("select * from ".$prefix."_ele_sezioni where id_sez='$id_sez'", $dbi);
        		$ar=mysql_fetch_array($result);
				++$i;
				mysql_query("update  ".$prefix."_ele_sezioni set voti_nulli_lista='".$arg[$i++]."', contestati_lista='".$arg[$i++]."' where id_sez='$id_sez'", $dbi);
				if ($fileout) fwrite($fp,"update  ".$prefix."_ele_sezioni set voti_nulli_lista='".$arg[$i++]."', contestati_lista='".$arg[$i++]."' where id_sez='$id_sez';\n");
#				if ($ar['validi'] and !$ar['validi_lista']){
				if ($ar['validi']){
#					$result = mysql_query("select sum(voti) from ".$prefix."_ele_voti_lista where id_sez='$id_sez'", $dbi);
#					list($val)=mysql_fetch_row($result);
#					mysql_query("update  ".$prefix."_ele_sezioni set validi_lista='$val' where id_sez='$id_sez'", $dbi);
					mysql_query("update  ".$prefix."_ele_sezioni set validi_lista=(`validi`+`contestati`+`voti_nulli`-`solo_gruppo`-`voti_nulli_lista`-`contestati_lista`) where id_sez='$id_sez'", $dbi);
					if ($fileout) fwrite($fp,"update  ".$prefix."_ele_sezioni set validi_lista=(`validi`+`contestati`+`voti_nulli`-`solo_gruppo`-`voti_nulli_lista`-`contestati_lista`) where id_sez='$id_sez';\n");
				}
			}
	   }	
	}
	
//	$ops = $arg[$argc];
	if ($fileout)fclose($fp);
	Header("Location: admin.php?op=voti&id_cons_gen=$id_cons_gen&id_circ=$id_circ&id_sede=$id_sede&id_sez=$id_sez&do=spoglio&ops=3&id_lista=$id_lista");
}


////////////////////////////////////////////
// da qua va la sezione per i votanti
///////////////////////////////////////////

function votanti($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops,$ov,$mv,$gv,$msv,$av){
//function votanti($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops,$ov,$mv,$gv,$msv,$av){
 global $aid, $prefix, $dbi,$tipo_cons,$genere,$id_cons_gen;
$bgcolor1=$_SESSION['bgcolor2'];
OpenTable();
echo "<tr><td>&nbsp;</td></tr>";
$res = mysql_query("SELECT orario,data FROM ".$prefix."_ele_rilaff where id_cons_gen=$id_cons_gen order by data,orario ", $dbi);
$num = mysql_num_rows($res);
$ressez = mysql_query("SELECT maschi,femmine FROM ".$prefix."_ele_sezioni where id_sez=$id_sez", $dbi);
list($maschi,$femmine)=mysql_fetch_row($ressez);
$y=0;
while (list($ora,$giorno)= mysql_fetch_row($res)){
	$y++;
	echo "\n<tr><td>";
	echo "<form name=\"votanti$y\" action=\"admin.php\">";
 	echo "<table border=\"0\" width=\"100%\" align=\"center\"><tr>";
	if ($genere==0){ //e' un referendum
		echo "<td bgcolor=\"$bgcolor1\" align=\"center\" width=\"32\"><b>"._NUM."</b></td>";
	}
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\" width=\"32\"><b>"._ORA."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"width=\"32\"><b>"._DATA."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._VOTIU."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._VOTID."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._VOTIT."</b>"; 
	if ($genere==0){ 
		$res2 = mysql_query("SELECT * FROM ".$prefix."_ele_gruppo where id_cons='$id_cons'  ", $dbi);
		$max = mysql_num_rows($res2);
	}else{ $max=1;}
	echo "<input type=\"hidden\" name=\"op\" value=\"rec_add_votanti\">";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
	."<input type=\"hidden\" name=\"id_sez\" value=\"$id_sez\">"
	."<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">"
	."<input type=\"hidden\" name=\"id_sede\" value=\"$id_sede\">";
	echo "</td>"; //la riga viene chiusa nel ciclo for    
	for ($i=1;$i<=$max;$i++){
		$query="SELECT * FROM ".$prefix."_ele_voti_parziale as t1 left join ".$prefix."_ele_gruppo as t2 
		on (t1.id_gruppo=t2.id_gruppo) where t1.id_sez='$id_sez' 
		and t1.id_cons='$id_cons' and t1.orario='$ora' and t1.data='$giorno'";
		if ($genere==0){
			$query.=" and t2.num_gruppo=$i";
		}
		$result = mysql_query($query, $dbi);
		list($id_cons2,$id_sez2,$id_parz,$orario,$data, $voti_u, $voti_d, $voti_t,$id_gruppo) = mysql_fetch_row($result);
	   	$res2 = mysql_query("SELECT num_gruppo FROM ".$prefix."_ele_gruppo where id_gruppo=$id_gruppo ", $dbi);
		if ($res2)
			list($gruppo)= mysql_fetch_row($res2);
		else
			$gruppo=0;
		if (!$gruppo>0) {
			$gruppo=$i;
			$res3 = mysql_query("SELECT id_gruppo FROM ".$prefix."_ele_gruppo where num_gruppo=$gruppo and id_cons=$id_cons", $dbi);
			if ($res3)
			list($id_gruppo)=mysql_fetch_row($res3);
		}
		if ($voti_u+$voti_d and $voti_u+$voti_d!=$voti_t){
			echo "</tr><tr style=\"background-color: rgb(255, 0, 0); align=center\">";
		}else{
			echo "</tr><tr align=\"center\">";
		}
		if ($genere==0){ // e' un referendum
			echo "<td align=\"center\">$gruppo</td>";
		}
                
                list ($anno,$mese,$di)=explode('-',$giorno);
		echo "<td align=\"center\">$ora</td><td align=\"center\">$di-$mese-$anno</td>";
		if ($voti_u > $maschi) echo "<td align=\"center\" bgcolor=\"red\"><input";
		else echo "<td align=\"center\"><input";
		if ($y>$num) { echo " type=\"hidden\"";}
		echo " name=\"voti_u$i\" value=\"$voti_u\" size=\"5\"></td>";
		if ($voti_d > $femmine) echo "<td align=\"center\" bgcolor=\"red\"><input";
		else echo "<td align=\"center\"><input";
		if ($y>$num) { echo " type=\"hidden\"";}
		echo "  name=\"voti_d$i\" value=\"$voti_d\" size=\"5\"></td>";
		if ($voti_t > ($maschi+$femmine)) echo "<td align=\"center\" bgcolor=\"red\"><input name=\"voti_t$i\" value=\"$voti_t\" size=\"5\">";
		else echo "<td align=\"center\"><input name=\"voti_t$i\" value=\"$voti_t\" size=\"5\">";
		echo "<input type=\"hidden\" name=\"id_parz$i\" value=\"$id_parz\">"
		."<input type=\"hidden\" name=\"data$i\" value=\"$giorno\">"
		."<input type=\"hidden\" name=\"orario$i\" value=\"$ora\">"
		."<input type=\"hidden\" name=\"gruppo$i\" value=\"$id_gruppo\">";
		echo "</td>";
	}
	echo "<td style=\"text-align: right;\" rowspan=\"1\" colspan=\"6\"><input type=\"submit\" name=\"update\" value=\""._OK."\"></td></tr>";



   echo "</table></form></td></tr>";
   	$compl= mysql_query("select voti_complessivi from ".$prefix."_ele_voti_parziale where data='$giorno' and orario='$ora' and id_sez=$id_sez", $dbi);
   	list ($complessivi)= mysql_fetch_row($compl);
	if (!$complessivi) 
	{
		echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n";
		if ($y==$num) {
			echo "document.votanti$y.voti_u1.focus()\n";
			echo "document.votanti$y.voti_u1.select()\n";
		}else{
			echo "document.votanti$y.voti_t1.focus()\n";
			echo "document.votanti$y.voti_t1.select()\n";
		}
		echo "//-->\n"
		."</script>\n";
		break;
	}
	}
CloseTable();
}


///////////////////////////
// registra i votanti
///////////////////////////

function rec_add_votanti() {
global $prefix, $dbi,$aid,$tipo_cons,$genere,$id_cons,$fileout;
//ordine dei parametri: 0)op 1)voti_u 2) voti_d 3)voti_t 4)id_cons 5)id_sez 6)id_circ 7)id_sede
// 8)id_parz 9)ops 10)data 11)orario 12)tipo 13)id_gruppo 14) update
if ($fileout) while (!$fp = fopen($fileout,"a"));

$username="$aid";
$arg2 = func_get_args();
$arg = split(",",$arg2[0]);//foreach($arg as $key=>$val) echo "$key:$val<br>";die();
$arg = split(",",$arg2[0]);
$id_cons_gen=intval($arg[1]);
$id_sez=intval($arg[2]);
$id_circ=intval($arg[3]);
$id_sede=intval($arg[4]);
for($i=5;$i< count($arg)-1;) {
	$voti_u = intval($arg[$i++]);
	$voti_d = intval($arg[$i++]);
	$voti_t = intval($arg[$i++]);
	if($voti_t==0) $voti_t=$voti_d+$voti_u;
	$id_parz = intval($arg[$i++]);
	$giorno = $arg[$i++];
	$ora = $arg[$i++];
	$id_gruppo = intval($arg[$i++]);
    $data=date("Y/m/d");
	$tempo=date("H:i:s");
	$query="select * from ".$prefix."_ele_voti_parziale where data='$giorno' and orario='$ora' and id_sez='$id_sez'";
	if ($genere==0){
		$query.=" and id_gruppo=$id_gruppo";
	}
	$res=mysql_query("$query",$dbi);
	$righe=mysql_num_rows($res);
    if (!$righe){
        mysql_query("insert into ".$prefix."_ele_log values('$id_cons','$id_sez','$username','$data','$tempo','','id_parz:$id_parz ora: $ora data:$giorno voti uomini:$voti_u donne:$voti_d totali:$voti_t id_gruppo:$id_gruppo','".$prefix."_ele_voti_parziale')", $dbi);
	mysql_query("insert into ".$prefix."_ele_voti_parziale values ('$id_cons', '$id_sez','$id_parz','$ora','$giorno','$voti_u','$voti_d','$voti_t','$id_gruppo')", $dbi);
	if ($fileout) fwrite($fp,"insert into ".$prefix."_ele_voti_parziale values ('$id_cons', '$id_sez','$id_parz','$ora','$giorno','$voti_u','$voti_d','$voti_t','$id_gruppo');\n");
     } else {
  	$res=mysql_query("select * from ".$prefix."_ele_voti_parziale where id_parz=$id_parz",$dbi);
	$ar=mysql_fetch_array($res);
	if ($ar['voti_uomini']!=$voti_u or $ar['voti_donne']!=$voti_d or $ar['voti_complessivi']!=$voti_t){   	
	mysql_query("insert into ".$prefix."_ele_log values('$id_cons','$id_sez','$username','$data','$tempo','ora:$ar[3] data:$ar[4] voti uomini:$ar[5] donne:$ar[6] totali:$ar[7] gruppo:$ar[8]','id_parz:$id_parz ora: $ora data:$giorno voti uomini:$voti_u donne:$voti_d totali:$voti_t id_gruppo:$id_gruppo','".$prefix."_ele_voti_parziale')", $dbi);	
	$result = mysql_query("update  ".$prefix."_ele_voti_parziale set voti_uomini='$voti_u', voti_donne='$voti_d', voti_complessivi='$voti_t' where id_parz='$id_parz'", $dbi);
	if ($fileout) fwrite($fp,"update  ".$prefix."_ele_voti_parziale set voti_uomini='$voti_u', voti_donne='$voti_d', voti_complessivi='$voti_t' where id_parz='$id_parz';\n");
	}
     }
  }   
if ($fileout)fclose($fp);
Header("Location: admin.php?op=voti&id_cons_gen=$id_cons_gen&id_circ=$id_circ&id_sede=$id_sede&id_sez=$id_sez&ops=1&do=spoglio");
}



function finale($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops){
 global $aid, $prefix, $dbi,$id_cons_gen,$genere,$votog,$fascia,$limite;
////////////////////////////////////////////
// da qua va la sezione per i voti finali
///////////////////////////////////////////
$bgcolor1="#7777ff";
$bgcolor2=$_SESSION['bgcolor2'];



     	echo "<form name=\"spogliovoti\" action=\"admin.php\">"
      	."<input type=\"hidden\" name=\"op\" value=\"rec_finale\">";
   	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
     	."<input type=\"hidden\" name=\"id_sez\" value=\"$id_sez\">"
    	."<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">"
     	."<input type=\"hidden\" name=\"id_sede\" value=\"$id_sede\">";

	echo "<table border=\"0\" width=\"80%\" align=\"center\"><tr bgcolor=\"$bgcolor1\" align=\"center\">";
/*	if($ops==3 and ($genere==3 or ($genere==5 and $fascia>$limite)) )
		echo "<td width=\"32\"><b>"._VOTI_LISTA."</b></td>";
	else */
		echo "<td width=\"32\"><b>"._VALIDI."</b></td>";
	echo "<td width=\"32\"><b>"._NULLI."</b></td>"
    ."<td><b>"._BIANCHI."</b></td>"
//	."<td width=\"32\"><b>"._VOTINULLI."</b></td>"
	."<td width=\"0\"><b></b></td>"
	."<td><b>"._CONTESTATI."</b></td>"
    ."<td><b>"._TOTNON."</b></td>"
	."<td><b>"._TOTALEVOTI."</b></td>"
	."<td bgcolor=\"#ffffff\"></td> </tr>";
/*if($ops==3 and ($genere==3 or ($genere==5 and $fascia>$limite)) )
    $result = mysql_query("select id_cons,id_sez,validi_lista,nulli,bianchi,contestati_lista,voti_nulli_lista,solo_gruppo,contestati,voti_nulli from ".$prefix."_ele_sezioni where id_cons='$id_cons' and id_sez='$id_sez' ", $dbi);
else */
    $result = mysql_query("select id_cons,id_sez,validi,nulli,bianchi,contestati,voti_nulli,'0','0','0' from ".$prefix."_ele_sezioni where id_cons='$id_cons' and id_sez='$id_sez' ", $dbi);
    list($id_cons2,$id_sez2,$validi, $nulli, $bianchi, $contestati,$votinulli,$sg,$conts,$nullis) = mysql_fetch_row($result);
    $tot_nulli=$nulli+$bianchi+$contestati+$votinulli;
    $tot_voti=$validi+$tot_nulli+$sg+$conts+$nullis;

	echo "<tr bgcolor=\"$bgcolor2\" align=\"center\"><td align=\"left\"><input  name=\"validi\" value=\"$validi\" size=\"5\">";
/*	if(($genere==3 or $genere==5) and !$votog and $ops==3){
	echo "</td><td>$nulli"
	."</td><td>$bianchi";
	echo "<input type=\"hidden\" name=\"nulli\" value=\"$nulli\"><input type=\"hidden\" name=\"bianchi\" value=\"$bianchi\">";
	}else{ */
	echo "</td><td><input  name=\"nulli\" value=\"$nulli\" size=\"5\">"
	."</td><td><input  name=\"bianchi\" value=\"$bianchi\" size=\"5\">";
//	}
//	echo "</td><td><input  name=\"votinulli\" value=\"$votinulli\" size=\"5\">"
	echo "</td><td><input type=\"hidden\" name=\"votinulli\" value=\"$votinulli\" size=\"5\">"
	."</td><td><input  name=\"contestati\" value=\"$contestati\" size=\"5\">"
	."</td><td>$tot_nulli"
	."</td><td>$tot_voti</td><td>"
//    	."<input type=\"hidden\" name=\"id_cand\" value=\"$id_cand\">"
    	."<input type=\"hidden\" name=\"ops\" value=\"$ops\">"
       	."<input type=\"submit\" name=\"update\" value=\""._OK."\">"
      	."</td></tr></table></form>"; //</td></tr>";


//    echo "</table>";
	echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n";
	if (!$validi) {
		echo "document.spogliovoti.validi.focus()\n";
		echo "document.spogliovoti.validi.select()\n";
	}
	echo "//-->\n"
	."</script>\n";


    }






///////////////////////////
// registra voti finali
///////////////////////////

function rec_finale() {
global $prefix, $dbi,$aid,$id_cons,$fileout,$genere,$votog;

if ($fileout) while (!$fp = fopen($fileout,"a"));
$arg2 = func_get_args();
$arg = split(",",$arg2[0]);
$id_cons_gen=intval($arg[1]);
$id_sez = intval($arg[2]);
$id_circ = intval($arg[3]);
$id_sede = intval($arg[4]);
$validi = intval($arg[5]);
$nulli = intval($arg[6]);
$bianchi = intval($arg[7]);
$votinulli = intval($arg[8]);
$contestati = intval($arg[9]);
$ops = $arg[10];
$username="$aid";
$log_data= date("Y/m/d");
$log_ora=getdate(time());	
$orario=($log_ora['hours'].":".$log_ora['minutes'].":".$log_ora['seconds']);

$result= mysql_query("select voti_complessivi from ".$prefix."_ele_voti_parziale where id_cons='$id_cons' and id_sez='$id_sez' order by id_parz desc", $dbi);
list($voti_t) = mysql_fetch_row($result);
   $tot_voti=$validi+$nulli+$bianchi+$contestati+$votinulli;
	$result= mysql_query("select * from ".$prefix."_ele_sezioni where id_cons='$id_cons' and id_sez='$id_sez' ", $dbi);
	$ar=mysql_fetch_array($result);
#die("qui: if($ops==3 and ($genere==3 or $genere==4 or $genere==5) and $votog){");
	if($ops==3 and ($genere==3 or $genere==4 or $genere==5) and ($votog or $genere==4)){
	mysql_query("insert into ".$prefix."_ele_log values('$id_cons','$id_sez','$username','$log_data','$orario','validi_lista:$ar[14] nulli:$ar[7] bianchi:$ar[8] contestati_lista:$ar[15]  voti_nulli_lista:$ar[16]','validi_lista=$validi, nulli=$nulli,bianchi=$bianchi,contestati_lista=$contestati,voti_nulli_lista=$votinulli','_ele_sezioni')", $dbi);	

/*		$result = mysql_query("update  ".$prefix."_ele_sezioni set validi='$validi', contestati='$contestati', validi_lista='$validi', nulli='$nulli',bianchi='$bianchi',contestati_lista='$contestati', voti_nulli_lista='$votinulli' where id_cons='$id_cons' and id_sez='$id_sez' ", $dbi);
		if ($fileout) fwrite($fp,"update  ".$prefix."_ele_sezioni set validi='$validi', contestati='$contestati', validi_lista='$validi', nulli='$nulli',bianchi='$bianchi',contestati_lista='$contestati', voti_nulli_lista='$votinulli' where id_cons='$id_cons' and id_sez='$id_sez';\n"); */
		$result = mysql_query("update  ".$prefix."_ele_sezioni set validi='$validi', contestati='$contestati', validi_lista='$validi', nulli='$nulli',bianchi='$bianchi',contestati_lista='$contestati', voti_nulli='$votinulli' where id_cons='$id_cons' and id_sez='$id_sez' ", $dbi);
		if ($fileout) fwrite($fp,"update  ".$prefix."_ele_sezioni set validi='$validi', contestati='$contestati', validi_lista='$validi', nulli='$nulli',bianchi='$bianchi',contestati_lista='$contestati', voti_nulli='$votinulli' where id_cons='$id_cons' and id_sez='$id_sez';\n");
	}else{
 	mysql_query("insert into ".$prefix."_ele_log values('$id_cons','$id_sez','$username','$log_data','$orario','validi:$ar[6] nulli:$ar[7] bianchi:$ar[8] contestati:$ar[9] voti_nulli:$ar[13]','validi=$validi, nulli=$nulli,bianchi=$bianchi,contestati=$contestati, voti_nulli=$votinulli','_ele_sezioni')", $dbi);	
	$valista="";
	if ($ar['validi_lista']){
	  $tvalista=$validi+$contestati+$votinulli-$ar['solo_gruppo']-$ar['voti_nulli_lista']-$ar['contestati_lista'];
	  $valista=",validi_lista='$tvalista'";
	}

		$result = mysql_query("update  ".$prefix."_ele_sezioni set validi='$validi', nulli='$nulli',bianchi='$bianchi',contestati='$contestati',voti_nulli='$votinulli' $valista where id_cons='$id_cons' and id_sez='$id_sez' ", $dbi);
		if ($fileout) fwrite($fp,"update  ".$prefix."_ele_sezioni set validi='$validi', nulli='$nulli',bianchi='$bianchi',contestati='$contestati',voti_nulli='$votinulli' $valista where id_cons='$id_cons' and id_sez='$id_sez';\n");
	}
//	}
// Il test non e' piu' necessario perche' le sezioni sono state gia' inserite in precedenza
 	if ($fileout) fclose($fp);
         Header("Location: admin.php?op=voti&id_cons_gen=$id_cons_gen&id_circ=$id_circ&id_sede=$id_sede&id_sez=$id_sez&do=spoglio&ops=$ops");

/*}else{

echo "<b><br><center><h1>I voti totali  non corrispondono con i votanti</h1><b>";
echo "<hr><a href=\"admin.php?op=voti&amp;id_cons=$id_cons&amp;id_circ=$id_circ&amp;id_sede=$id_sede&amp;id_sez=$id_sez&amp;do=spoglio&amp;ops=$ops\">Torna e correggi i dati immessi</a></center>";
}*/
}


function preferenze_gruppi($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops){
 global $aid, $prefix, $dbi, $tipo_cons, $genere,$id_cons_gen,$sezi,$circo;
////////////////////////////////////////////
// da qua va la sezione per le preferenze ai gruppi
///////////////////////////////////////////
// Controllo immmissioni
$bgcolor1="#7777ff";
$bgcolor2=$_SESSION['bgcolor2'];
    $res = mysql_query("SELECT * FROM ".$prefix."_ele_gruppo where id_cons='$id_cons'  ", $dbi);
    $max = mysql_num_rows($res);
    $max = $max-1;
	 echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n";
	if ($genere==0) {
		echo "document.sezioni.si1.focus()\n";
		echo "document.sezioni.si1.select()\n";
	} else {
		echo "document.sezioni.voti1.focus()\n"
		."document.sezioni.voti1.select()\n";
	}
	echo "//-->\n"
	."</script>\n";
// tabella votanti
    if ($genere!=0){
	$result = mysql_query("SELECT voti_uomini,voti_donne, voti_complessivi FROM ".$prefix."_ele_voti_parziale where id_sez='$id_sez' and id_cons='$id_cons' and (voti_uomini > 0 or voti_donne > 0) order by id_parz desc", $dbi);
    	list( $voti_u, $voti_d, $voti_t) = mysql_fetch_row($result);
   	echo "<table border=\"0\" width=\"50%\" align=\"center\">"
	."<tr><td></td><td align=\"center\"></td><td bgcolor=\"$bgcolor1\" align=\"center\">"._VOTIU."</td><td bgcolor=\"$bgcolor1\" align=\"center\">"._VOTID."</td><td bgcolor=\"$bgcolor1\" align=\"center\">"._VOTIT."</td></tr>"
	."<tr><td></td><td bgcolor=\"$bgcolor1\" align=\"center\">"._TOT_ULT."</td><td bgcolor=\"$bgcolor2\" align=\"center\">$voti_u</td><td align=\"center\" bgcolor=\"$bgcolor2\">$voti_d</td><td bgcolor=\"$bgcolor2\" align=\"center\">$voti_t</td></tr>";
   	echo "</table>";
    }
	echo "<table border=\"0\" width=\"50%\"  align=\"center\"><tr>";
    if ($genere==0){
    	$res = mysql_query("SELECT id_gruppo,si+no,validi,nulli,bianchi,contestati FROM ".$prefix."_ele_voti_ref where id_cons='$id_cons' and id_sez='$id_sez'  ", $dbi);
		while (list($id_gruppo,$voti_parz,$validi,$nulli,$bianchi,$contestati) = mysql_fetch_row($res)){
			if ($voti_parz!=$validi){
				$res2 = mysql_query("SELECT num_gruppo FROM ".$prefix."_ele_gruppo where id_cons='$id_cons' and id_gruppo='$id_gruppo'  ", $dbi);
				list($num_gruppo) = mysql_fetch_row($res2);
				echo "<td style=\"background-color: rgb(255, 0, 0); align=center\"><img src=\"modules/Elezioni/images/alert.gif\" align=\"middle\" alt=\"\"><br><b> "._ATT_VOTI_REF." $num_gruppo: ".$voti_parz." "._NO_VAL_VOTI.": ".$validi."</b><br></td>";
			}
			$res2 = mysql_query("SELECT max(voti_complessivi) FROM ".$prefix."_ele_voti_parziale where id_cons='$id_cons' and id_sez='$id_sez' and id_gruppo='$id_gruppo' ", $dbi);
			list($tot) = mysql_fetch_row($res2);
			if (($validi+$nulli+$bianchi+$contestati)!= $tot ){
				$res2 = mysql_query("SELECT num_gruppo FROM ".$prefix."_ele_gruppo where id_cons='$id_cons' and id_gruppo='$id_gruppo'", $dbi);
				list($num_gruppo) = mysql_fetch_row($res2);
				echo "<td style=\"background-color: rgb(255, 0, 0); align=center\"><img src=\"modules/Elezioni/images/alert.gif\" align=\"middle\" alt=\"\"><br><b> "._ATT_VOTANTI_REF." $num_gruppo: ".$tot." "._NO_SOMMA." ".($validi+$nulli+$bianchi+$contestati)."</b><br></td>";
			}
		}
    }else{
    	$res = mysql_query("SELECT sum(voti) FROM ".$prefix."_ele_voti_gruppo where id_cons='$id_cons' and id_sez='$id_sez'", $dbi);
       	list($voti_parz) = mysql_fetch_row($res);
        $res = mysql_query("SELECT validi,nulli,bianchi,contestati,solo_gruppo,voti_nulli FROM ".$prefix."_ele_sezioni where id_cons='$id_cons' and id_sez='$id_sez'", $dbi);
    	list($validi,$nulli,$bianchi,$contestati,$solo_gruppo,$votinulli) = mysql_fetch_row($res);
		if ($voti_parz!=$validi and $voti_parz>0){
			echo "<td style=\"background-color: rgb(255, 0, 0); align=center\"><img src=\"modules/Elezioni/images/alert.gif\" align=\"middle\" alt=\"\"><br><b> "._ATT_VOTI." ".$voti_parz." "._NO_VAL_VOTI." ".$validi."</b><br></td>";
    	}
		$res2 = mysql_query("SELECT max(voti_complessivi) FROM ".$prefix."_ele_voti_parziale where id_cons='$id_cons' and id_sez='$id_sez'", $dbi);
		list($tot) = mysql_fetch_row($res2);
		if ($validi+$nulli+$bianchi+$contestati+$votinulli!=$tot and $validi+$nulli+$bianchi+$contestati+$votinulli>0){
			echo "<td style=\"background-color: rgb(255, 0, 0); align=center\"><img src=\"modules/Elezioni/images/alert.gif\" align=\"middle\" alt=\"\"><br><b> "._ATT_VOTANTI." ".$tot." "._NO_TOT_VOTI." ".($validi+$nulli+$bianchi+$contestati+$votinulli)."</b><br></td>";
    	}
    }
	echo "<td></td></tr></table>";
	if ($validi+$nulli+$bianchi+$contestati+$votinulli>0 or $genere==0) {
    echo "<form name=\"sezioni\" action=\"admin.php\">";
   	echo "<input type=\"hidden\" name=\"op\" value=\"rec_voti_gruppi\">"
    ."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
    ."<input type=\"hidden\" name=\"id_sez\" value=\"$id_sez\">"
    ."<input type=\"hidden\" name=\"id_circ\" value=\"$id_circ\">"
     ."<input type=\"hidden\" name=\"id_sede\" value=\"$id_sede\">";
	echo "<br><br> <table border=\"0\" width=\"60%\" align=\"center\"><tr align=\"center\" bgcolor=\"$bgcolor1\">"
	."<td width=\"3%\"><b>"._NUM."</b></td>"
    ."<td width=\"50%\"><b>"._GRUPPO."</b></td>";
	if ($genere==0){
		echo "<td><b>"._SI."</b></td>"
		."<td><b>"._NO."</b></td>"
		."<td><b>"._VALIDI."</b></td>"
		."<td><b>"._BIANCHI."</b></td>"
		."<td><b>"._CONTESTATI."</b></td>"
		."<td><b>"._NULLI."</b></td>"
		."<td><b>"._TOTNON."</b></td>";
	}else{
		echo "<td width=\"5%\"><b>"._VOTI."</b></td>";
	}
    echo "</tr>";
    $res = mysql_query("SELECT * FROM ".$prefix."_ele_gruppo where id_cons='$id_cons' $circo ", $dbi);
    $max = mysql_num_rows($res);
    //echo "Massimo:$max - id=$id_cons - circo: $circo";
    $result = mysql_query("select * from ".$prefix."_ele_gruppo where id_cons='$id_cons' $circo ORDER BY num_gruppo  ", $dbi);
    $i=1;
	$tot_pref=0;
       
    while(list($id_cons2,$id_gruppo,$num_gruppo, $descr_gruppo, $simbolo) = mysql_fetch_row($result)){
  
      //echo "test: $id_cons2,$id_gruppo,$num_gruppo, $descr_gruppo, $simbolo";
      

     if ($num_gruppo != ''){
	if ($genere==0){
		$res = mysql_query("SELECT max(voti_complessivi) FROM ".$prefix."_ele_voti_parziale where id_cons='$id_cons' and id_sez='$id_sez' and id_gruppo='$id_gruppo' ", $dbi);
		list($tot) = mysql_fetch_row($res);
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_voti_ref where id_cons='$id_cons' and id_sez='$id_sez' and id_gruppo='$id_gruppo' ", $dbi);
		$pro= mysql_fetch_array($res, 3);
	
		if ($pro['si']+$pro['no']!=$pro['validi'] or ($pro['validi']+$pro['nulli']+$pro['bianchi']+$pro['contestati']!=$tot and $pro['validi']+$pro['nulli']+$pro['bianchi']+$pro['contestati']!=0)){
			echo "<tr style=\"background-color: rgb(255, 0, 0); align=center\">";
		}else{
			echo "<tr style=\"background-color: $bgcolor2; align=center\">";
		}
		$descr = explode('.',$descr_gruppo, 100);
		echo "<td align=\"center\"><input type=\"hidden\" name=\"id_gruppo$i\" value=\"$id_gruppo\"><b>$num_gruppo</b>"
		."</td><td align=\"left\" width=\"50%\"><b> $descr[0] </b>";
		$pro['si']=$pro['si']>0 ? $pro['si']:0;
		$pro['no']=$pro['no']>0 ? $pro['no']:0;
		$pro['validi']=$pro['validi']>0 ? $pro['validi']:0;
		$pro['bianchi']=$pro['bianchi']>0 ? $pro['bianchi']:0;
		$pro['contestati']=$pro['contestati']>0 ? $pro['contestati']:0;
		$pro['nulli']=$pro['nulli']>0 ? $pro['nulli']:0;
		$tot_nulli=$pro['nulli']+$pro['bianchi']+$pro['contestati'];
		echo "</td><td align=\"right\" width=\"3%\"><input  name=\"si$i\" value=\"".$pro['si']."\" size=\"7\" ></td>";
		echo "</td><td align=\"right\" width=\"3%\"><input  name=\"no$i\" value=\"".$pro['no']."\" size=\"7\" ></td>";
		echo "</td><td align=\"right\" width=\"3%\"><input  name=\"val$i\" value=\"".$pro['validi']."\" size=\"7\" ></td>";
		echo "</td><td align=\"right\"><input  name=\"bia$i\" value=\"".$pro['bianchi']."\" size=\"7\" ></td>";
		echo "</td><td align=\"right\"><input  name=\"con$i\" value=\"".$pro['contestati']."\" size=\"7\" ></td>";
		echo "</td><td align=\"right\"><input  name=\"nul$i\" value=\"".$pro['nulli']."\" size=\"7\" ></td>";
		echo "</td><td align=\"right\">$tot_nulli</td>";
	}else{
		echo "<tr style=\"background-color: $bgcolor2; align=center\"><td align=\"center\"><input type=\"hidden\" name=\"id_gruppo$i\" value=\"$id_gruppo\"><b>$num_gruppo</b>"
		."</td><td align=\"left\"><b> $descr_gruppo </b>";
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_voti_gruppo where id_cons='$id_cons' and id_sez='$id_sez' and id_gruppo='$id_gruppo' ", $dbi);
		$pro= mysql_fetch_array($res, 3);
		echo "</td><td align=\"right\"><input  name=\"voti$i\" value=\"".$pro['voti']."\" size=\"7\" ></td>";
		$tot_pref += $pro['voti'];
	}
	
	$i++;
    }

   }
	if ($genere!=0) {
		echo "<tr style=\"background-color: $bgcolor1; align=center\"><td></td><td>"._TOTPREF."</td><td>$tot_pref</td></tr>";
	}

   echo "<tr><td></td><td></td><td align=\"center\"><input type=\"submit\" name=\"update\" value=\" "._OK. "\"></td>";

    echo "</tr></table></form><br><br> ";
	}
    if ($genere!=0){
    	finale($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops);
    }
}






///////////////////////////
// registra le preferenze ai gruppi
///////////////////////////

function rec_voti_gruppi() {
global $prefix, $dbi,$aid, $tipo_cons, $genere,$id_cons,$ops,$fileout;
if ($fileout) while (!$fp = fopen($fileout,"a"));
$username="$aid";
$log_data= date("Y/m/d");
$log_ora=getdate(time());
$arg2 = func_get_args();
$arg = split(",",$arg2[0]);
$id_cons_gen=intval($arg[1]);
$id_sez = intval($arg[2]);
$id_circ = intval($arg[3]);
$id_sede = intval($arg[4]);
$y=count($arg)-1;
if ($genere==0) {
	$tab="_ele_voti_ref";
} else {
	$tab="_ele_voti_gruppo";
	$y--;
}

for($i=5;$i< $y;) {
	$id_gruppo = intval($arg[$i++]);
	switch ($genere){    
		case (0):         
			$si=intval($arg[$i++]);
			$no=intval($arg[$i++]);
			$val=intval($arg[$i++]);
			if ($val==0){$val=$si+$no;}
			$bia=intval($arg[$i++]);
			$con=intval($arg[$i++]);
			$nul=intval($arg[$i++]);
			$voti = "$si,$no,$val,$nul,$bia,$con";
			$riga="si=$si,no=$no,validi=$val,nulli=$nul,bianchi=$bia,contestati=$con";
			break;
		default:
			$voti = intval($arg[$i++]);
			if (!$voti) {$voti="0";}
			$riga="voti=$voti";
			break;
	}
	$result = mysql_query("select * from ".$prefix."$tab where id_cons='$id_cons' and id_sez='$id_sez' and id_gruppo='$id_gruppo'", $dbi);
	$ar=mysql_fetch_array($result);
	$res = mysql_query("select num_gruppo from ".$prefix."_ele_gruppo where id_cons='$id_cons' and id_gruppo='$id_gruppo'", $dbi);
	list($num_gruppo)=mysql_fetch_array($res);
	$oldval='';
	if ($ar){
		switch ($genere){  
			case (0): 
				if ($ar['si']!=$si or $ar['no']!=$no or $ar['validi']!=$val or $ar['nulli']!=$nul
				or $ar['bianchi']!=$bia or $ar['contestati']!=$con){
					$oldval=" si:$ar[3] no:$ar[4] validi:$ar[5] nulli:$ar[6] bianchi:$ar[7] contestati:$ar[8]";
				}
				break;
			default:
				if ($ar['voti']!=$voti) {
					$oldval="voti:".$ar['voti'];
					$voti.=",null";
				}
				if (isset($ar['num_gruppo'])) $dstgruppo=$ar['num_gruppo'];
				break;
		}
		if ($oldval) {
			mysql_query("update  ".$prefix."$tab set $riga where id_cons='$id_cons' and id_sez='$id_sez' and id_gruppo='$id_gruppo'", $dbi);
			if ($fileout) fwrite($fp,"update  ".$prefix."$tab set $riga where id_cons='$id_cons' and id_sez='$id_sez' and id_gruppo='$id_gruppo';\n");
			mysql_query("insert into ".$prefix."_ele_log values('$id_cons','$id_sez','$username','$log_data','".$log_ora['hours'].":".$log_ora['minutes'].":".$log_ora['seconds']."','$oldval','num_gruppo:$num_gruppo $riga','$tab')", $dbi);
		}
	} else {
		mysql_query("insert into ".$prefix."_ele_log values('$id_cons','$id_sez','$username','$log_data','".$log_ora['hours'].":".$log_ora['minutes'].":".$log_ora['seconds']."','','num_gruppo:$num_gruppo $riga','$tab')", $dbi);
		mysql_query("insert into ".$prefix."$tab values ('$id_cons', '$id_gruppo','$id_sez',$voti)", $dbi);
		if ($fileout) fwrite($fp,"insert into ".$prefix."$tab values ('$id_cons', '$id_gruppo','$id_sez',$voti);\n");
	//
	}

}
//$ops = $arg[$argc];
if ($fileout) fclose($fp);
Header("Location: admin.php?op=voti&id_cons_gen=$id_cons_gen&id_circ=$id_circ&id_sede=$id_sede&id_sez=$id_sez&do=spoglio&ops=4");

}


 	if (!ereg("rec",$op)) {
		ele(); //menu
		numeri_sezione();
	}

 switch ($op){
	case "voti": //fa eccezione perche' chiamata con minor numero di parametri - riesaminare 
    	voti($id_cons,$do,$id_circ,$id_sede,$id_sez,$ops,$ov,$mv,$gv,$msv,$av,$id_lista);
    	break;
	default :
    	$op($vari); //chiamata a funzione variabile con parametri variabili (da cambiare!)
  }
echo"</td></tr></table>";
   include ("footer.php");
?>


