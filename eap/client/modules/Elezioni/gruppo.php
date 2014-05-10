<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

if (!defined('MODULE_FILE')) {
    die ("You can't access this file directly...");
}
if ($xls=='1' or $pdf=='1') {
include_once("modules/Elezioni/language/lang-$lang.php");
include_once("modules/Elezioni/funzioni.php");
}
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ?
	$_GET : $_POST;

if (isset($param['id_cons_gen'])) $id_cons_gen=intval($param['id_cons_gen']); else $id_cons_gen='';
//if (isset($param['op'])) $op=$param['op']; else $op='';
if (isset($param['minsez'])) $minsez=intval($param['minsez']); else $minsez='';
if (isset($param['id_lista'])) $id_lista=intval($param['id_lista']); else $id_lista='';
if (isset($param['id_circ'])) $id_circ=intval($param['id_circ']); else $id_circ='';
if (isset($param['csv'])) $csv=intval($param['csv']); else $csv='';
if (isset($param['min'])) $min=intval($param['min']); else $min= 0;
if (isset($param['orvert'])) $orvert=intval($param['orvert']); else $orvert='';
if (isset($param['offset'])) $offset=intval($param['offset']); else $offset='';
if (isset($param['offsetsez'])) $offsetsez=intval($param['offsetsez']); else $offsetsez='';
if (isset($param['perc'])) $perc=$param['perc']; else $perc='';
if (isset($param['info'])) get_magic_quotes_gpc() ? $info=$param['info']:$info=addslashes($param['info']); else $info='';
if (isset($param['files'])) get_magic_quotes_gpc() ? $files=$param['files']:$files=addslashes($param['files']); else $files='';
if (isset($param['voti_lista'])) $voti_lista=intval($param['voti_lista']); else $voti_lista= 0;
if (isset($param['perc_lista'])) $perc_lista=$param['perc_lista']; else $perc_lista= 0;
if (isset($param['lettera'])) get_magic_quotes_gpc() ? $lettera=$param['lettera']:$lettera=addslashes($param['lettera']); else $lettera='';
if (isset($param['id_gruppo'])) $id_gruppo=intval($param['id_gruppo']); else $id_gruppo='';
#if (isset($param['tipo_cons'])) $tipo_cons=intval($param['tipo_cons']); else $tipo_cons='';

# anti-xss nov. 2009 
$id_comune=htmlentities($id_comune);
$id_comune=intval($id_comune);
$perc=htmlentities($perc);
$perc_lista=floatval($perc_lista);
#$datipdf= htmlentities($datipdf);
$op= htmlentities($op);
$info= htmlentities($info);
$files=htmlentities($files);
$lettera=htmlentities($lettera);







include("crea_pagina.php");
$res = mysql_query("SELECT descrizione from  ".$prefix."_ele_comuni where id_comune='$id_comune'" , $dbi);
list($descr_comune) = mysql_fetch_row($res);

$res = mysql_query("SELECT t1.descrizione, t1.tipo_cons,t2.genere, t2.voto_g, t2.voto_l, t2.voto_c, t2.circo FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_tipo as t2 where t1.tipo_cons=t2.tipo_cons and t1.id_cons_gen='$id_cons_gen' ", $dbi);
list($descr_cons,$tipo_cons,$genere,$votog,$votol,$votoc,$circo) = mysql_fetch_row($res);
$res = mysql_query("SELECT t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($id_cons) = mysql_fetch_row($res);







////////////////////////////////////////////////////////////
//   Visualizza i dati per liste, gruppi e referendum, per sezione o circoscrizione
////////////////////////////////////////////////////////////

function gruppo_circo(){
	global $prefix, $dbi, $descr_cons, $id_cons, $id_cons_gen,$tipo_cons,$votog,$votol,$votoc,$circo, $genere,$id_gruppo,$id_lista,$bgcolor1,$bgcolor2,$id_comune,$descr_comune,$id_circ;
	global $id_comune,$id_cons_gen,$op,$minsez,$id_lista,$id_circ,$csv,$min,
	$orvert,$offset,$offsetsez,$perc,$info,$files;
	#Denominazione pagine
	if($op=="gruppo_circo") $pagina=_GRUPPO." "._PER." "._CIRCO;
	if($op=="gruppo_sezione") $pagina=_GRUPPO." "._PER." "._SEZIONI;
	if($op=="lista_circo") $pagina=_LISTA." "._PER." "._CIRCO;
	if($op=="lista_sezione") $pagina=_LISTA." "._PER." "._SEZIONI;
	if($op=="candidato_circo") $pagina=_CONSI." "._PER." "._CIRCO;
	if($op=="candidato_sezione") $pagina=_CONSI." "._PER." "._SEZIONI;
	if($op=="consiglieri") $pagina=_CALCONS;




	if (strstr( $op,'circo')) { //$op=='gruppo_circo' or $op=='lista_circo') {
		$tab1="circ";
		$tab2="t5.num_circ,t5.descrizione";
		$tab3="t5.num_circ";
		$tipo1=_DA." "._CIRCO;
		$tipo2=_CIRCOS;
		$tipo3=_CIRCO;
	}else{
		$tab1="sez";
		$tab2="t3.num_sez,''";
		$tab3="t3.num_sez";
		$tipo1=_DA." "._SEZIONE;
		$tipo2=_SEZIONI;
		$tipo3=_SEZIONE;
	}
	if (strstr( $op,"gruppo")){
		$tab="gruppo";
	}elseif (strstr( $op,'lista')) {	
		$tab="lista";
	}else{
		$tab="candidati";
	}
	if ($orvert) {
		$righe='';
		$colonne='checked';
	}else{
		$righe='checked';
		$colonne='';
	}
	if ($genere>0) {       //se non e' un referendum
		
		
		$voticompl=0;
		if (!($offset)) $offset=25;
		if (!($min)) $min=1;
		if (!($offsetsez)) $offsetsez=20; 
		if (!($minsez)) $minsez=1;
		if ($min>$offset) { 
			$appo=$min;
			$min=$offset;
			$offset=$appo;
		}
		if ($minsez>$offsetsez) { 
			$appo=$minsez;
			$minsez=$offsetsez;
			$offsetsez=$appo;
		}
		if (!$csv){
		echo "<form id=\"voti\" method=\"post\" action=\"modules.php\">";
		echo "<div><input type=\"hidden\" name=\"pag\" value=\"modules.php?name=Elezioni&amp;op=$op&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_circ=$id_circ&amp;id_lista=\"></input>";
		echo "<input type=\"hidden\" name=\"pagina\" value=\"modules.php?name=Elezioni&amp;op=$op&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_circ=\"></input>";
		}
		$condcirc='';
		if ($circo){ //gestione circoscrizionali
			if(!$id_circ){
			$res_cir = mysql_query("SELECT id_circ from ".$prefix."_ele_circoscrizione where id_cons=$id_cons and num_circ=1",$dbi); //se non si e' scelta una circoscr. prende la prima
			list($id_circ)=mysql_fetch_row($res_cir);
			}
			$res_cir = mysql_query("SELECT num_circ from ".$prefix."_ele_circoscrizione where id_circ=$id_circ",$dbi); //estrae il numero della circoscrizione
			list($num_circ)=mysql_fetch_row($res_cir);
			$condcirc="and id_circ=$id_circ";  //variabile aggiunta nelle select per le circ.
			$res_sez = mysql_query("SELECT count(t1.num_sez) from ".$prefix."_ele_sezioni as t1, ".$prefix."_ele_sede as t2 where t1.id_cons=$id_cons and t1.id_sede=t2.id_sede and t2.id_circ=$id_circ",$dbi); //numero di sezioni nella circoscrizione
			$res_min = mysql_query("SELECT min(t1.num_sez) from ".$prefix."_ele_sezioni as t1, ".$prefix."_ele_sede as t2 where t1.id_cons=$id_cons and t1.id_sede=t2.id_sede and t2.id_circ=$id_circ",$dbi); //setta minsez sulla prima sezione della circoscrizione
			list($minsez)=mysql_fetch_row($res_min);
			}
		else
			$res_sez = mysql_query("SELECT count(num_sez) from ".$prefix."_ele_sezioni where id_cons=$id_cons",$dbi);
		list($tot_sez)=mysql_fetch_row($res_sez);
		$num_sez=$tot_sez;//mysql_data_seek($res_sez,0);
		if ($circo) $offsetsez=$num_sez+$minsez-1;//setta offsetsez sull'ultima sezione della circoscrizione
		if(strstr( $op,"circo")) {
				$res_sez = mysql_query("SELECT count(num_circ) from ".$prefix."_ele_circoscrizione where id_cons=$id_cons",$dbi);  //estrae il numero delle circoscrizioni
				list($num_sez)=mysql_fetch_row($res_sez);
			}
#Tolgo la scelta della circoscrizione o collegio perché gestita per tutte le pagine in index.php
/*			if ($circo){ // elenco per scelta circoscrizione
				$res_sez = mysql_query("SELECT id_circ,descrizione,num_circ from ".$prefix."_ele_circoscrizione where id_cons=$id_cons",$dbi);
				echo "<div >"._SCELTA_CIR.": 
				<select name=\"id_circ\" class=\"modulo\" onChange=\"top.location.href=this.form.pagina.value+this.form.id_circ.options[this.form.id_circ.selectedIndex].value;return false\">";
				while(list($id_rif,$descrizione,$num_cir)=mysql_fetch_row($res_sez)) {
					if (!$id_circ) $id_circ=$id_rif;
					$sel = ($id_rif == $id_circ) ? "selected=\"selected\"" : "";
					echo "<option value=\"$id_rif\" $sel>";
					for ($j=strlen($num_cir);$j<2;$j++) { echo "&nbsp;&nbsp;";}
					echo $num_cir.") ".$descrizione."</option>";
				}
				echo "</select></div>";
			
			}
*/
			$visvot='';
			if(strstr( $op,'candidato')){
//			$numliste=mysql_num_rows($res_lis);
				$visvot="cand";
				if (!$csv){
					$res_lis = mysql_query("SELECT id_lista, descrizione,num_lista from ".$prefix."_ele_lista where id_cons=$id_cons $condcirc order by num_lista",$dbi);
					//elenco delle liste per la scelta
					echo "<p>Scegli la lista: 
					<select name=\"id_lista\" class=\"modulo\" onChange=\"top.location.href=this.form.pag.value+this.form.id_lista.options[this.form.id_lista.selectedIndex].value;return false\">";
					while(list($id_rif,$descrizione,$num_lis) = mysql_fetch_row($res_lis)) {
						if (!$id_lista) $id_lista=$id_rif;
						$sel = ($id_rif == $id_lista) ? "selected=\"selected\"" : "";
						echo "<option value=\"$id_rif\" $sel>";
						for ($j=strlen($num_lis);$j<2;$j++) { echo "&nbsp;&nbsp;";}
						echo $num_lis.") ".$descrizione."</option>";
					}
					echo "</select></p>";
				}
				$res_scr = mysql_query("SELECT count(t1.id_sez) from ".$prefix."_ele_voti_$tab as t1, ".$prefix."_ele_$tab as t2 where t2.id_lista=$id_lista and t1.id_cand=t2.id_cand group by t1.id_cand",$dbi);
				$res_cand = mysql_query("SELECT id_cand, concat(cognome,' ', nome), num_cand from ".$prefix."_ele_$tab where id_cons=$id_cons and id_lista=$id_lista order by num_cand",$dbi);
				if ($circo) $condcirc="and t5.id_circ=$id_circ";
				$res_voti = mysql_query("select $tab2, t1.num_cand, concat(t1.cognome,' ', t1.nome), sum(t2.voti),'','','','','' 
				from ".$prefix."_ele_candidati as t1, ".$prefix."_ele_voti_candidati as t2, "
				.$prefix."_ele_sezioni as t3, ".$prefix."_ele_sede as t4, ".$prefix."_ele_circoscrizione as t5
				where t1.id_lista=$id_lista
				and t1.id_cons=$id_cons
				and t1.id_cand=t2.id_cand
				and t2.id_sez=t3.id_sez
				and t3.id_sede=t4.id_sede
				and t4.id_circ=t5.id_circ $condcirc
				group by t1.num_cand,$tab3
				order by $tab3,t1.num_cand",$dbi);

		}else{
			if (!$csv)
				echo "<input type=\"hidden\" name=\"id_lista\" value=\"\"></input>";
				
				// camera e senato nel 2006 aggiunte le somme della coalizione
				// divise per circo e sez. in quanto nella tabella del gruppo
				// all'atto dell'immsione non viene fatta la somma
				// quindi leggere prima i voti di lista e poi agganciali al gruppo
				// la var $tab diviene lista, $tab15 diviene gruppo in caso di somma
				// dei voti di lista...oltre naturalmnte alle condizioni messe in variabile
				// 4 aprile 2006 by luc
				if ($votog && $tab=="gruppo"){ // camera e senato 2006
					$t="t9";
					$tab="lista";
					$tab15="gruppo";
					$add_1= ",".$prefix."_ele_gruppo as t9";
					$and_1="and t1.id_gruppo=t9.id_gruppo";
				}else{
					$t="t1";
					$tab15=$tab;
					$add_1='';
					$and_1='';
				}
				// fine della modifica
				 
				$res_scr = mysql_query("SELECT count(id_sez) from ".$prefix."_ele_voti_$tab15 where id_cons='$id_cons' group by id_$tab15",$dbi); //numero sezioni scrutinate
				$res_cand = mysql_query("SELECT id_$tab15, descrizione, num_$tab15 from ".$prefix."_ele_$tab15 where id_cons='$id_cons' $condcirc order by num_$tab15",$dbi);
				if ($circo) $condcirc="and t5.id_circ=$id_circ";			
                                if ($tab=="gruppo")
                                        $votigl=" sum(t3.validi),sum(t3.nulli),sum(t3.bianchi),sum(t3.contestati),sum(t3.voti_nulli)";
                                else
                                        if ($votog) $votigl=" (t3.validi_lista),(t3.nulli),(t3.bianchi),(t3.contestati_lista),(t3.voti_nulli_lista)";
                                        else $votigl=" sum(t3.validi_lista),sum(t3.nulli),sum(t3.bianchi),sum(t3.contestati_lista),sum(t3.voti_nulli_lista)";





				$res_voti = mysql_query("select $tab2, $t.num_$tab15, $t.descrizione, sum(t2.voti), $votigl
				from 
				".$prefix."_ele_$tab as t1, 
				".$prefix."_ele_voti_$tab as t2, 
				".$prefix."_ele_sezioni as t3, 
				".$prefix."_ele_sede as t4, 
				".$prefix."_ele_circoscrizione as t5
				$add_1
				
				where t1.id_cons=$id_cons 
				and t1.id_$tab=t2.id_$tab
				$and_1
				
				and t2.id_sez=t3.id_sez
				and t3.id_sede=t4.id_sede
				and t4.id_circ=t5.id_circ $condcirc
				
				
				group by $t.num_$tab15,$tab3
				order by $tab3,$t.num_$tab15",$dbi);
			}
			if ($res_scr) list($tot_scr)=mysql_fetch_row($res_scr);else $tot_scr=0;
			if ($res_cand) $num_cand=mysql_num_rows($res_cand); else $num_cand=0;
			if(!$circo){
				if (!(0 < $minsez and $minsez<=$num_sez)) $minsez=1;
				if (!(0<$offsetsez and $offsetsez<=$num_sez)) $offsetsez=$num_sez;
			}
			if (!(0 < $min and $min<=$num_cand)) $min=1;
			if (!(0<$offset and $offset<=$num_cand)) $offset=$num_cand;
			if (!$csv) {		
				echo "<br /><table>
				  <tr><td><h5>$pagina</h5></td></tr>";
				echo "<tr><td>"._DA.":&nbsp;  <select name=\"min\" class=\"modulo\">";
				while(list($id_rif,$descrizione,$num_lis) = mysql_fetch_row($res_cand)) {
					if (!$min) $min=$num_lis;
					$sel = ($num_lis == $min) ? "selected=\"selected\"" : "";
					echo "<option value=\"$num_lis\" $sel>";
					for ($j=strlen($num_lis);$j<2;$j++) { echo "&nbsp;&nbsp;";}
					echo $num_lis.") ".$descrizione."</option>";
					
				}
				echo "</select></td></tr>";
				echo "<tr><td>&nbsp;&nbsp;"._A.":&nbsp; <select name=\"offset\" class=\"modulo\">";
				mysql_data_seek($res_cand,0);
				while(list($id_rif,$descrizione,$num_lis) = mysql_fetch_row($res_cand)) {
					if (!$offset) $offset=$num_lis;
					$sel = ($num_lis == $offset) ? "selected=\"selected\"" : "";
					echo "<option value=\"$num_lis\" $sel>";
					for ($j=strlen($num_lis);$j<2;$j++) { echo "&nbsp;&nbsp;";}
					echo $num_lis.") ".$descrizione."</option>";
					
				}
				echo "</select></td></tr></table>";
				echo "<table><tr><td>";
				if(!$circo)
				echo "$tipo1 n. <input  name=\"minsez\" value=\"$minsez\" size=\"4\" ></input>";
				echo "</td>";
				echo "<td>";
				if(!$circo)
				echo _A." n. <input  name=\"offsetsez\" value=\"$offsetsez\" size=\"4\" ></input> (max. $num_sez)";
				echo "</td>
				<td align=\"right\">"._MOSTRA." $tipo2 <br/>"._PERCOL."<input type=\"radio\" name=\"orvert\" $righe value=\"0\"></input><br/>"._PERRIGHE." <input
				type=\"radio\" name=\"orvert\" $colonne value=\"1\"></input>";
				echo "<input type=\"hidden\" name=\"name\" value=\"Elezioni\"></input>
				</td></tr>";
$diff=($offsetsez-$minsez);
if ($minsez>1){
	$minsez_p= ($minsez-$diff)>1 ? $minsez-$diff-1:1;
	 
	$offsetsez_p=$offsetsez-$diff-1;
				echo "<tr><td valign=\"middle\"><div align=\"right\"><a href=\"modules.php?name=Elezioni&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;op=$op&amp;min=$min&amp;offset=$offset&amp;minsez=$minsez_p&amp;offsetsez=$offsetsez_p&amp;perc=$perc&amp;id_lista=$id_lista\"> <- Precedenti</a></div></td>";
}else{echo "<tr><td></td>";}
if ($offsetsez<$num_sez){
        $minsez_s=$minsez+$diff+1;
        $offsetsez_s= ($offsetsez+$diff)>$num_sez ? $num_sez: $offsetsez+$diff+1;

				echo "<td><div><a href=\"modules.php?name=Elezioni&amp;file=index&amp;op=$op&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;orvert=$orvert&amp;min=$min&amp;offset=$offset&amp;minsez=$minsez_s&amp;offsetsez=$offsetsez_s&amp;perc=$perc&amp;id_lista=$id_lista\"> Successive -></a></div></td><td></td></tr>";
}else{echo "<td></td><td></td></tr>";}	

				
				
				echo "<tr>";
				if (!strstr( $op,'candidato')) {
					echo "<td>"._VIS_PERC.": <input type=\"checkbox\" name=\"perc\" value=\"true\"";
					if($perc=='true') echo " checked=\"true\"";
					echo "></input></td>";
				}
				echo "<td>";
				echo "<input type=\"hidden\" name=\"op\" value=\"$op\"></input>";			
				echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\"></input>";
				echo "<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\"></input>";			
	
				echo "<input type=\"hidden\" name=\"pag2\" value=\"modules.php?name=Elezioni&amp;op=$op&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;csv=1&amp;orvert=$orvert&amp;min=$min&amp;offset=$offset&amp;minsez=$minsez&amp;offsetsez=$offsetsez&amp;perc=$perc&amp;id_lista=\"></input>";	

				 echo "<input type=\"submit\" name=\"update\" value=\""._OK."\"></input>"; 


				#### recupera dati stampa supporti diversi dati
				//echo "</tr><tr><td><b>"._COMUNE." $descr_comune</b> - "._RISULTATI.": $descr_cons <br/>"; 
				//echo "tot:$tot_scr";
				//if ($tipo_cons!=4 && $tot_scr) echo " - Sezioni scrutinate: $tot_scr su $tot_sez";

				# liste e gruppi da.... a	  
				if (!strstr( $op,'candidato')) {
				      $res_cand2 = mysql_query("SELECT descrizione from ".$prefix."_ele_$tab15 where id_cons='$id_cons' and num_$tab15 ='$min'",$dbi);
				      list($descrizione)= mysql_fetch_row($res_cand2);
				      $list1 ="da $descrizione ";  



				      $res_cand3 = mysql_query("SELECT descrizione from ".$prefix."_ele_$tab15 where id_cons='$id_cons' and num_$tab15 ='$offset'",$dbi);
				      list($descrizione)= mysql_fetch_row($res_cand3);
				      $list1 .=" a $descrizione <br/>";
			      
				}else{$list1='';}

				# nome della lista
				if (!isset($list2)) $list2='';
				if (strstr( $op,'candidato')) { 
					$res_lis2 = mysql_query("SELECT num_lista, descrizione from ".$prefix."_ele_lista where id_lista=$id_lista",$dbi);
					list($num_lista2,$descr_lista2)= mysql_fetch_row($res_lis2);
					$list2 .=" Lista n. $num_lista2 - $descr_lista2 <br/>";
				
					$res_cand4 = mysql_query("SELECT concat(cognome,' ', nome) from ".$prefix."_ele_$tab where id_cons=$id_cons and id_lista=$id_lista and num_cand=$min",$dbi);
					list($descrizione)= mysql_fetch_row($res_cand4);
				         $list3 ="da $descrizione "; 
					$res_cand5 = mysql_query("SELECT concat(cognome,' ', nome) from ".$prefix."_ele_$tab where id_cons=$id_cons and id_lista=$id_lista and num_cand=$offset",$dbi);
					list($descrizione)= mysql_fetch_row($res_cand5);
				         $list3 .="a $descrizione <br/>";

				}else{ $list2 .='';$list3='';}

			      
				$datipdf="<b>"._COMUNE." $descr_comune</b> - "._RISULTATI.": $descr_cons<br/><b>$pagina</b><br/><br/> $list1 $list2 $list3 
				dalla $tipo3 n. <b>$minsez</b> alla $tipo3 n. <b>$offsetsez</b> di <b>$num_sez</b> $tipo2<br/><br/>";
				
				


				
				  # verificare la stampa sulle circoscrizioni
				if(!$circo){ 
				  echo "</td><td><a href=\"".$_SERVER['PHP_SELF']."?name=Elezioni&amp;op=$op&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;csv=1&amp;orvert=$orvert&amp;min=$min&amp;offset=$offset&amp;minsez=$minsez&amp;offsetsez=$offsetsez&amp;perc=$perc&amp;id_lista=$id_lista&amp;datipdf=$datipdf\" ><img class=\"image\"  src=\"modules/Elezioni/images/printer.gif\" alt=\"Stampa\" /></a>";
				  echo "<a href=\"".$_SERVER['PHP_SELF']."?name=Elezioni&amp;op=$op&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;csv=1&amp;orvert=$orvert&amp;min=$min&amp;offset=$offset&amp;minsez=$minsez&amp;offsetsez=$offsetsez&amp;perc=$perc&amp;id_lista=$id_lista&amp;xls=1&amp;datipdf=$datipdf\" ><img class=\"image\"  src=\"modules/Elezioni/images/csv.gif\" alt=\"Export Csv\" /></a>";
				  echo "<a href=\"".$_SERVER['PHP_SELF']."?name=Elezioni&amp;op=$op&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;csv=1&amp;orvert=$orvert&amp;min=$min&amp;offset=$offset&amp;minsez=$minsez&amp;offsetsez=$offsetsez&amp;perc=$perc&amp;id_lista=$id_lista&amp;pdf=1&amp;datipdf=$datipdf\" ><img class=\"image\"  src=\"modules/Elezioni/images/pdf.gif\" alt=\"Export Pdf\" /></a>";
				}
				echo "</td></tr></table></div></form>";
				
				if (strstr( $op,'candidato')) echo $list2;	
				
				
			}
			if (!$csv){
				//echo "<table border=\"0\" width=\"100%\"><tr><td align=\"center\"><h5> Sezioni scrutinate";
				//if ($tipo_cons!=4) echo ": $tot_scr su $tot_sez";
				//echo "</h5></td></tr></table>";
			}
			$y=1;
			$ar[0][0]=$tipo2;
			$ra[0][0]=$tipo2;
			$num_sez++;
			$voticompl=0;
			$ominsez=$minsez-1;
			$sevaltot=0;
			$senultot=0;
			$sebiatot=0;
			$secontot=0;
			$sevnutot=0;
			$valar=array();$percar=array();
		      ////////////////////////////////////////////////////////////////////
		      // sandro: carica i numeri di sezione dal DB - giugno 2009
		      // caso: sezioni in collegi diversi non consecutive
			if($circo) { $secirco=" and t2.id_circ=$id_circ";} else $secirco="and t1.num_sez >= $minsez and t1.num_sez <= $offsetsez";
				$numsezioni = $offsetsez-$ominsez;
				$res_numsez = mysql_query("SELECT t1.num_sez from ".$prefix."_ele_sezioni as t1, ".$prefix."_ele_sede as t2 where t1.id_cons=$id_cons and t1.id_sede=t2.id_sede $secirco order by t1.num_sez",$dbi);
				for ($z=1;$z<=($offsetsez-$ominsez);$z++) {
					$res=mysql_fetch_row($res_numsez);
					$ar[$z][0]=$res[0];
					$pos[$z]=$res[0];
					#$valar[$z]=array();
				}
			if (!isset($pos)) $pos[0]=0;
			$minpos=min($pos);
			$maxpos=max($pos);
			////////////////////////////////////////////////////////////////////
			if ($res_voti)
			while (list($num_circ,$desc_circ,$num_cand,$nome,$voti,$sevalidi,$senulli,$sebianchi,$secontestati,$sevonulli) = mysql_fetch_row($res_voti)){
				if ($num_circ<$minpos or $num_circ>$maxpos) continue;
					$z=array_search($num_circ, $pos); 
				if (!isset($votitot[($z)])) {
					$votitot[($z)]=0;
				$sevaltot+=$sevalidi;
				$senultot+=$senulli;
				$sebiatot+=$sebianchi;
				$secontot+=$secontestati;
				$sevnutot+=$sevonulli;
				}
				$votitot[($z)]+=$voti;
				$voticompl+=$voti;
			}
			if ($voticompl) mysql_data_seek($res_voti,0);
			$piuvot=0;
			if ($visvot!='cand') $piuvot=5;




			for ($y=$min;$y<=($offset+$piuvot);$y++) $ar[0][$y]="&nbsp;";
			for ($z=1;$z<=($offsetsez-$ominsez);$z++)
 				for ($y=$min;$y<=($offset+$piuvot);$y++) $ar[$z][$y]="&nbsp;"; //inizializza le celle interne
			$onetime="";
			if ($res_voti)
			{
				if ($perc=='true'){
					while (list($num_circ,$desc_circ,$num_cand,$nome,$voti,$sevalidi,$senulli,$sebianchi,$secontestati,$sevonulli) = mysql_fetch_row($res_voti))
					if ($num_cand>=$min and $num_cand<=$offset){
						$z=array_search($num_circ, $pos);
						if($num_circ>=$minpos and $num_circ <=$maxpos){
								$valar[($z)][$num_cand]=$voti;
						}
						foreach ($valar as $key=>$val){
							$percar[$key]=arrayperc($val,$votitot[($key)]);
							foreach($percar as $key2=>$val2);
						}
					}
					 mysql_data_seek($res_voti,0);			
				}
			while (list($num_circ,$desc_circ,$num_cand,$nome,$voti,$sevalidi,$senulli,$sebianchi,$secontestati,$sevonulli) = mysql_fetch_row($res_voti)){
				if ($num_cand>=$min and $num_cand<=$offset){
					$z=array_search($num_circ, $pos); 
					if($num_circ>=$minpos and $num_circ <=$maxpos){
						$ar[0][$num_cand]=$num_cand.") ".$nome;
						if ($desc_circ && $onetime!=$desc_circ) {$ar[($z)][0].=") ".$desc_circ; $onetime=$desc_circ;}
						$percento=$voti;
						if ($perc=='true' and $votitot[($z)]) 
						{
							$percento=$voti."<br /><span class=\"red\"><i>".number_format($percar[$z][$num_cand],2)." %</i></span>";
						}
						$ar[($z)][$num_cand]=$percento;
					}
					if (!isset($temp[$num_cand])) $temp[$num_cand]=0;
					$temp[$num_cand]+=$voti;
					
				}
				if ($visvot!='cand'){
				$posvoti=($offset);
				$ar[0][$posvoti+1]='<b>Voti Validi</b>';
				$ar[0][$posvoti+2]='<b>Schede Nulle</b>';
				$ar[0][$posvoti+3]='<b>Schede Bianche</b>';
				$ar[0][$posvoti+4]='<b>Voti Contestati</b>';
				$ar[0][$posvoti+5]='<b>Voti Nulli</b>';
				if (($maxpos)>=$num_circ and $minpos<=$num_circ){  
				$posvoti++;
				$ar[($z)][$posvoti++]="<b>$sevalidi</b>";
				$ar[($z)][$posvoti++]="<b>$senulli</b>";
				$ar[($z)][$posvoti++]="<b>$sebianchi</b>";
				$ar[($z)][$posvoti++]="<b>$secontestati</b>";
				$ar[($z)][$posvoti]="<b>$sevonulli</b>"; 
				}
				}
			}
			}
			if (($offsetsez+1)>=$num_sez){ 
				$ar[(2+$offsetsez-$minsez)][0]="<b>"._TOT."<br />"._COMPLESSIVO."</b>";
				if(isset($temp)) {
					 if (!isset($tab15)) $tab15="candidati";
                     if($tab15=="gruppo"){
                          $votigl=" sum(validi),sum(nulli),sum(bianchi),sum(contestati),sum(voti_nulli)";
                     }else{
                          $votigl=" sum(validi_lista),sum(nulli),sum(bianchi),sum(contestati_lista),sum(voti_nulli_lista)";
                     }
					$resv = mysql_query("SELECT $votigl from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi);
					list ($sevaltot,$senultot,$sebiatot,$secontot,$sevnutot)= mysql_fetch_row($resv);
					$voticompl=$sevaltot+$senultot+$sebiatot+$secontot+$sevnutot;
					$resvt = mysql_query("SELECT voti from ".$prefix."_ele_voti_$tab15 where id_cons='$id_cons'",$dbi);
					list($votlt)=mysql_fetch_row($resvt);
					$temp3=arrayperc($temp,$sevaltot);
					while (list($key,$voti)= each($temp)) {
						if ($perc=='true' and $voticompl) 
						{
							$percento="<b>$voti<br /><span class=\"red\"><i>".$temp3[$key]." %</i></span></b>";
						} else
							$percento="<b>$voti</b>";
						$ar[2+$offsetsez-$minsez][$key]=$percento;
					}
				}
				if ($visvot!='cand') {
				$key=$offset+1;
				$tmp=array($sevaltot,$senultot,$sebiatot,$secontot,$sevnutot);
				$temp3=arrayperc($tmp,$voticompl);
 				while(list($k,$voti)= each($tmp)) {
					
                    if ($perc=='true' and $voticompl)
                    {
                         $percento="<b>$voti<br /><span class=\"red\"><i>".$temp3[$k]." %</i></span></b>";
                     } else $percento="<b>$voti</b>";
                     $ar[2+$offsetsez-$minsez][++$key]=$percento;

				}
				}
			}
			if($orvert!=1) {
				$i=0;
				foreach ( $ar as $riga) {
					$y=0;
					foreach($riga as $cella) {
						$ra[$y++][$i]=$cella;
					}
					$i++;
				}
				crea_tabella($ra);
			}else{
				crea_tabella($ar);
			}
//e' un referendum  
		}else{
			$res_lis = mysql_query("SELECT id_gruppo, descrizione,num_gruppo from ".$prefix."_ele_gruppo where id_cons=$id_cons order by num_gruppo",$dbi);
			$numliste=mysql_num_rows($res_lis);

			if (!isset($offset)) $offset=10;
			if (!isset($min)) $min=1;
			if (!isset($offsetsez)) $offsetsez=25; //lo 0 viene sostituito dal totale di sezioni presenti
			if (!isset($minsez)) $minsez=1;
			echo "<form id=\"voti\" method=\"post\" action=\"modules.php\">";
			echo "<div><input type=\"hidden\" name=\"name\" value=\"Elezioni\"></input>";			
			echo "<input type=\"hidden\" name=\"op\" value=\"$op\"></input>";			
			echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\"></input>";			
			echo "<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\"></input>";			
			echo "<table><tr><td>"._SCELTA." "._CONSULTAZIONE.": <select name=\"id_gruppo\">";
			while(list($id_rif,$descrizione,$num_lis) = mysql_fetch_row($res_lis)) {
				if (!$id_gruppo) $id_gruppo=$id_rif;
				$sel = ($id_rif == $id_gruppo) ? "selected=\"selected\"" : "";
				echo "<option value=\"$id_rif\" $sel>";
				for ($j=strlen($num_lis);$j<2;$j++) { echo "&nbsp;&nbsp;";}
				echo $num_lis.") ".strip_tags(substr($descrizione,0,50))."</option>";
			}
			echo "</select></td></tr>";
			echo "<tr><td>"._VIS_PERC.": <input type=\"checkbox\" name=\"perc\" value=\"true\"";
			if($perc=='true') echo " checked=\"true\"";
			echo "></td>";
			echo "<td><input type=\"submit\" name=\"update\" value=\""._OK."\"></td></tr></table></form>";
			$res_ref= mysql_query("select num_gruppo,descrizione from ".$prefix."_ele_gruppo where id_gruppo=$id_gruppo", $dbi);
			$res = mysql_query("select $tab2, t1.num_gruppo, t1.descrizione , t1.simbolo, 
			sum(t2.si),  sum(t2.no),sum(t2.validi),  sum(t2.nulli),sum(t2.bianchi),  sum(t2.contestati)
			from ".$prefix."_ele_gruppo as t1
			left join ".$prefix."_ele_voti_ref as t2 on (t1.id_gruppo=t2.id_gruppo)
			left join ".$prefix."_ele_sezioni as t3 on (t2.id_sez=t3.id_sez)
			left join ".$prefix."_ele_sede as t4 on (t3.id_sede=t4.id_sede)
			left join ".$prefix."_ele_circoscrizione as t5 on (t4.id_circ=t5.id_circ)
			where 	t1.id_cons='$id_cons' and t1.id_gruppo=$id_gruppo
			group by t2.id_gruppo,$tab3
			order by $tab3, t1.num_gruppo
			", $dbi);
			$num_sez=mysql_num_rows($res);
			list($num_gruppo,$descr)= mysql_fetch_row($res_ref);
			echo "<table><tr><td><b>Referendum n. ".$num_gruppo.") </b></td><td>".$descr."</td></tr></table></form>";
		$y=1;
		$ar[0][0]=$tipo2;
		$ar[0][1]=_SI;
		$ar[0][2]=_NO;
		$ar[0][3]=_VALIDI;
		$ar[0][4]=_NULLI;
		$ar[0][5]=_BIANCHI;
		$ar[0][6]=_CONTESTATI;
		
		while (list($num_gruppo,$desc_ref) = mysql_fetch_row($res_ref)){
			$ar[0][$i++]= $num_gruppo.") ".$desc_ref;
			$ar[1][$y++]= "SI";
			$ar[1][$y++]= "NO";
		}
		$num_sez++;
		$tot_si=0;
		$tot_no=0;
		$tot_va=0;
		$tot_nu=0;
		$tot_bi=0;
		$tot_co=0;
		while (list($num_circ,$desc_circ,$num_gruppo,$desc_ref,$simbolo,$si,$no,$validi,$nulli,$bianchi, $contestati)  = mysql_fetch_row($res)){
			$i=1;
			$votanti=$validi+$nulli+$bianchi+$contestati;
			$tot_si+=$si;
			$tot_no+=$no;
			$tot_va+=$validi;
			$tot_nu+=$nulli;
			$tot_bi+=$bianchi;
			$tot_co+=$contestati;
			$ar[$num_circ][0]=$num_circ."<br />".$desc_circ;
			if($validi){
			$ar[$num_circ][$i++]= $perc=='true' ? $si."<br /><span class=\"red\">".number_format($si*100/$validi,2)."%</span>":$si;
			$ar[$num_circ][$i++]= $perc=='true' ? $no."<br /><span class=\"red\">".number_format($no*100/$validi,2)."%</span>":$no;
			}else{
			$ar[$num_circ][$i++]= $perc=='true' ? $si."<br /><span class=\"red\">0.00%</span>":$si;
			$ar[$num_circ][$i++]= $perc=='true' ? $no."<br /><span class=\"red\">0.00%</span>":$no;
			}
			if($votanti){
			$ar[$num_circ][$i++]= $perc=='true' ? $validi."<br /><span class=\"red\">".number_format($validi*100/$votanti,2)."%</span>":$validi;
			$ar[$num_circ][$i++]= $perc=='true' ? $nulli."<br /><span class=\"red\">".number_format($nulli*100/$votanti,2)."%</span>":$nulli;
			$ar[$num_circ][$i++]= $perc=='true' ? $bianchi."<br /><span class=\"red\">".number_format($bianchi*100/$votanti,2)."%</span>":$bianchi;
			$ar[$num_circ][$i++]= $perc=='true' ? $contestati."<br /><span class=\"red\">".number_format($contestati*100/$votanti,2)."%</span>":$contestati;
			}else{
			$ar[$num_circ][$i++]= $perc=='true' ? $validi."<br /><span class=\"red\">0.00%</span>":$validi;
			$ar[$num_circ][$i++]= $perc=='true' ? $nulli."<br /><span class=\"red\">0.00%</span>":$nulli;
			$ar[$num_circ][$i++]= $perc=='true' ? $bianchi."<br /><span class=\"red\">0.00%</span>":$bianchi;
			$ar[$num_circ][$i++]= $perc=='true' ? $contestati."<br /><span class=\"red\">0.00%</span>":$contestati;
			}
		}
		$i=1;
		$tot_vo=$tot_va+$tot_nu+$tot_bi+$tot_co;
#		if($tot_va==0) $tot_va=1;
#		if($tot_vo==0) $tot_vo=1;
		$ar[$num_sez][0]=_TOT."<br />"._COMPLESSIVO;
		if($tot_va){
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_si."<br /><span class=\"red\">".number_format($tot_si*100/$tot_va,2)."%</span>":$tot_si;
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_no."<br /><span class=\"red\">".number_format($tot_no*100/$tot_va,2)."%</span>":$tot_no;
		}else{
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_si."<br /><span class=\"red\">0.00%</span>":$tot_si;
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_no."<br /><span class=\"red\">0.00%</span>":$tot_no;
		}
		if($tot_vo){
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_va."<br /><span class=\"red\">".number_format($tot_va*100/$tot_vo,2)."%</span>":$tot_va;
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_nu."<br /><span class=\"red\">".number_format($tot_nu*100/$tot_vo,2)."%</span>":$tot_nu;
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_bi."<br /><span class=\"red\">".number_format($tot_bi*100/$tot_vo,2)."%</span>":$tot_bi;
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_co."<br /><span class=\"red\">".number_format($tot_co*100/$tot_vo,2)."%</span>":$tot_co;
		}else{
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_va."<br /><span class=\"red\">0.00%</span>":$tot_va;
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_nu."<br /><span class=\"red\">0.00%</span>":$tot_nu;
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_bi."<br /><span class=\"red\">0.00%</span>":$tot_bi;
		$ar[$num_sez][$i++]= $perc=='true' ? $tot_co."<br /><span class=\"red\">0.00%</span>":$tot_co;
		}
		crea_tabella($ar);
	}
	if ($csv) echo "</body>\n</html>";
}

?>
