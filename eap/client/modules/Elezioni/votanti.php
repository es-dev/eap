<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

if (!defined('MODULE_FILE')) {
    die ("Non puoi accedere al file direttamente...");
}
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ?
	$_GET : $_POST;



$id_comune= (isset($param['id_comune'])) ? $param['id_comune']:$siteistat;
if (isset($param['id_cons_gen'])) $id_cons_gen=intval($param['id_cons_gen']); else $id_cons_gen='';
if (isset($param['op'])) $op=$param['op']; else $op='';
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
if (isset($param['tipo_cons'])) $tipo_cons=intval($param['tipo_cons']); else $tipo_cons='';
# anti-xss nov. 2009 
$id_comune=htmlentities($id_comune);
$perc=floatval($perc);
$perc_lista=floatval($perc_lista);
$datipdf= htmlentities($datipdf);
$op= htmlentities($op);
$info= htmlentities($info);
$files=htmlentities($files);
$lettera=htmlentities($lettera);

$id_comune=intval($id_comune);


//$id_cons_gen=$_GET['id_cons_gen'];
$res = mysql_query("SELECT t1.tipo_cons,t3.genere,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2, ".$prefix."_ele_tipo as t3 where t1.tipo_cons=t3.tipo_cons and t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$genere,$id_cons) = mysql_fetch_row($res);

if (isset($param['ops'])) $ops=$param['ops']; else $ops='';
if (isset($param['pag'])) $pag=$param['pag']; else $pag=0;
if (isset($param['num_ref'])) $num_ref=$param['num_ref'];
if (isset($param['num_refs'])) $num_refs=$param['num_refs'];
$bgcolor2='#cacaca';
//**************************************************************************
//        ELE
//**************************************************************************
//controllo_finale($id_cons);

global $prefix, $dbi,$id_circ,$lang;

include_once("modules/Elezioni/language/lang-$lang.php");
# testata

if($csv==1){
	include_once("modules/Elezioni/funzioni.php");
	
	$res = mysql_query("SELECT descrizione FROM ".$prefix."_ele_comuni where id_comune='$id_comune' ", $dbi);
	list($descr_com) = mysql_fetch_row($res);
        $descr_com =stripslashes($descr_com); 
	$datipdf .= "<div style=\"margin:0px auto; text-align:center;\">";
	$siteistat=$id_comune;
	if($xls!=1) $datipdf .= "<table><tr><td><img src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_comune=".$id_comune."\" alt=\"mappa\" /></td><td>";
        $datipdf .= ""._COMUNE." $descr_com <br/>
	"._RISULTA." "._CONSULTA."<br/>";
	$datipdf .= "<h1>$descr_cons</h1>"._DISCLAIMER."";
	if($xls!=1) $datipdf .=  "</td></tr></table>";
	$datipdf .="</div>";
	  





}


    
    // icone stampa e grafici
	if ($csv!=1){
	if (!isset($html)) $html='';
	$html .= "<div>
	<a href=\"modules.php?name=Elezioni&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;op=graf_votanti\">
	"._VER_GRAF." <img class=\"image\" src=\"modules/Elezioni/images/grafici.png\" alt=\"\" /></a>
	 <a href=\"modules.php?name=Elezioni&amp;op=come&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;info=votanti&amp;csv=1&amp;pag=$pag\">"._VER_STAMPA."
	<img class=\"image\" src=\"modules/Elezioni/images/printer.png\" alt=\"\" /></a>
	<a href=\"modules.php?name=Elezioni&amp;op=come&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;info=votanti&amp;xls=1&csv=1;&amp;pag=$pag\">
		<img class=\"image\" src=\"modules/Elezioni/images/csv.gif\" alt=\"\" /></a>


	</div>";
	}
       
    
    
	$res = mysql_query("SELECT sum(maschi),sum(femmine) FROM ".$prefix."_ele_sezioni where id_cons='$id_cons'", $dbi);
	list($totm,$totf) = mysql_fetch_row($res);
	$totel=$totm+$totf;
	if (!IsSet($pag)) {$pag=0;} //inizializza il numero di pagina 
	if (!IsSet($num_ref)) { 
		$num_ref=1;
		$resg = mysql_query("SELECT id_gruppo from ".$prefix."_ele_gruppo where id_cons=$id_cons", $dbi);
		$num_refs= mysql_num_rows($resg); //quante pagine?
	}
	if(($genere!=4) and $pag==0){ //diverso da liste a piu' candidati
		$ops=4;	//gestione gruppi (anche liste uninominali)
	}else{
		$ops=3; //gestione liste
	}
	
	$resg = mysql_query("SELECT id_gruppo,num_gruppo from ".$prefix."_ele_gruppo where id_cons=$id_cons and num_gruppo=$num_ref", $dbi);
	list($idg,$numg) = mysql_fetch_row($resg);
	$res = mysql_query("SELECT id_sez,num_sez,t1.id_sede as id_sede,t2.id_circ as id_circ FROM ".$prefix."_ele_sezioni as t1,".$prefix."_ele_sede as t2 where t1.id_cons='$id_cons' and t1.id_sede=t2.id_sede order by num_sez ", $dbi);
	$max = mysql_num_rows($res); //quante sezioni?
	$res = mysql_query("SELECT id_sez,num_sez,t1.id_sede as id_sede,t2.id_circ as id_circ FROM ".$prefix."_ele_sezioni as t1,".$prefix."_ele_sede as t2 where t1.id_cons='$id_cons' and t1.id_sede=t2.id_sede order by num_sez ", $dbi);
	$num_sez = mysql_num_rows($res); //quante sezioni?
	for ($i=1;$i<=$num_sez;$i++){
		$sezione[$i]=mysql_fetch_array($res, 3); //inizializza l'array delle sezioni
		$ar[$i]=0;
	}
	$tab3="_ele_voti_lista";
	if ($genere>0) {  //se non e' un referendum
		if (!($genere==4) and $pag==0){  //se non e' una lista uninominale ed e' la prima pagina
			$tab="SELECT 0,t2.id_sez,t2.num_sez,t2.validi,'0',t2.validi,t2.nulli,t2.bianchi,t2.contestati, t4.id_circ,t2.id_sede,'0' FROM ".$prefix."_ele_sezioni as t2 left join ".$prefix."_ele_sede as t4 on (t2.id_sede=t4.id_sede) where t2.id_cons='$id_cons' and t2.validi+t2.nulli+t2.bianchi+t2.contestati>0 group by t2.id_sez order by t2.num_sez ";
		
		}else{ // e' una lista uninominale o la seconda pagina
			$tab="SELECT '0',t1.id_sez,t1.num_sez,sum(t2.voti),t1.solo_gruppo,t1.validi,t1.nulli,t1.bianchi,t1.contestati, t4.id_circ,t1.id_sede,'0'
			FROM ".$prefix."_ele_sezioni as t1 left join ".$prefix.$tab3." as t2 on (t1.id_sez=t2.id_sez)
			left join ".$prefix."_ele_sede as t4 on (t1.id_sede=t4.id_sede)
			where t1.id_cons='$id_cons' and t1.id_cons=t2.id_cons group by t2.id_sez order by t1.num_sez ";
		}
		
		$riga1 = "<div style=\"margin:0px auto;text-align:center;\">";
		if($pag==0)$riga1 .="<h2>"._DETTAGLIO." "._VOTIE."</h2></div>";
		else $riga1 .="<h2>"._DETTAGLIO." "._VOTIE." "._ASOLA_LISTA."</h2></div>";
		
	}else{ // e' un referendum
		$tab="SELECT t1.id_gruppo,t1.id_sez,t2.num_sez,t1.si,t1.no,t1.validi,t1.nulli,t1.bianchi,t1.contestati, t4.id_circ,t2.id_sede,t3.num_gruppo
		FROM ".$prefix."_ele_voti_ref as t1 left join ".$prefix."_ele_sezioni as t2 on (t1.id_sez=t2.id_sez)
		left join  ".$prefix."_ele_gruppo as t3 on (t1.id_gruppo=t3.id_gruppo) left join ".$prefix."_ele_sede as t4 on (t2.id_sede=t4.id_sede)
		where t1.id_cons='$id_cons' and t1.id_gruppo='$idg' order by t2.num_sez ";
		$riga1  = "<div style=\"margin:0px auto;text-align:center;\">";
		$riga1 ="<h2>"._DETTAGLIO." "._VOTIE."</h2></div>";
		
		$des = mysql_query("select descrizione from ".$prefix."_ele_gruppo where id_gruppo='$idg'", $dbi);
		list($descrizione)=mysql_fetch_array($des);
		$riga1 .="<h4>$descrizione</h4>";
	}
	$res = mysql_query("$tab ", $dbi);
	$num_scr = mysql_num_rows($res);
	//$riga2= "<div>"._SEZSCR." $num_scr su $num_sez</div>";//sezioni scrutinate

	$riga2 = "<table style=\"border:1px solid #6A6A6A;\" summary=\"Tabella dei voti espressi\">";
	$riga3 = "<tr class=\"bggray\">
	<td>"._SEZIONI."</td>
    	<td>"._VOTIU."</td>
	<td>"._VOTID."</td>
	<td>"._VOTIE."</td>"; //testata con nomi dei campi
	if ($genere==0) {  //se e' un referendum
		$riga3 .= "<td>"._SI."</td><td>"._NO."</td>";
	} elseif ((($genere==5) or ($genere==3)) and $pag==1){
		$riga3 .= "<td>"._ASOLA_LISTA."</td><td>"._ASOLO_GRUPPO."</td>";
	}
	$riga3 .= "<td>"._VALIDI."</td><td>"._NULLI."</td><td>"._BIANCHI."</td><td>"._CONTESTATI."</td>"
    ."</tr>\n";
	$res = mysql_query("$tab ", $dbi);
	$num_scr = mysql_num_rows($res);
	$righe= "";
	$scrutinate=1;
	$tot_u=0;$tot_d=0;$tot_voti=0; $tot_si=0;$tot_no=0;$tot_validi=0;$tot_nulli=0;$tot_bianchi=0;$tot_contestati=0;
	while (list($id_gruppo,$id,$num,$si,$no,$validi,$nulli,$bianchi,$contestati,$id_circ,$id_sede,$gruppo) = mysql_fetch_row($res)){
	// inserimento numeri di sez non scrutinate
		while ($scrutinate < $num) { 
			$righe.= "<tr><td><span style=\"color: rgb(255, 0, 0);\">$scrutinate</span></td></tr>\n";
			$scrutinate++;
		}
		$scrutinate++; 
	// fine inserimento	
		$tab2="SELECT max(voti_donne),max(voti_uomini),max(voti_complessivi) FROM ".$prefix."_ele_voti_parziale where id_cons='$id_cons' and id_sez='$id'";
		if ($genere==0) $tab2 .= " and id_gruppo=$id_gruppo";
		$res2 = mysql_query($tab2, $dbi);
		list($votid,$votiu,$voti) = mysql_fetch_row($res2);
//		$voti=$votiu+$votid;
		$tot_u+=$votiu;
		$tot_d+=$votid;
		$tot_voti+=$voti;
		$tot_si+=$si;
		$tot_no+=$no;
		$tot_validi+=$validi;
		$tot_nulli+=$nulli;
		$tot_bianchi+=$bianchi;
		$tot_contestati+=$contestati;
		$righe .= "<tr class=\"bggray\">
		<td>$num</td>
		<td>".number_format($votiu,0,',','.')."</td>
		<td>".number_format($votid,0,',','.')."</td>
		<td>".number_format($voti,0,',','.')."</td>";
		if ($genere==0 or ((($genere==5) or ($genere==3)) and $pag==1)){$righe 
		.= "<td>".number_format($si,0,',','.')."</td>
		<td>".number_format($no,0,',','.')."</td>";}
		
		$righe .= "<td>".number_format($validi,0,',','.')."</td>
		<td>$nulli</td>
		<td>$bianchi</td>
		<td>$contestati</td></tr>";
	}
	if ($num<$num_sez) {
		for (;$scrutinate<=$num_sez;$scrutinate++) {
			$righe .= "<tr><td>";
			$righe .="<span style=\"color: rgb(255, 0, 0);\">$scrutinate</span></td></tr>";
		}
	}
	$righet='';
	if($num_scr){
	$righet = "<tr class=\"bggray\">
	<td ></td>
    	<td>"._VOTIU."</td>
	<td>"._VOTID."</td>
	<td>"._VOTIE."</td>"; //testata con nomi dei campi
	if ($genere==0) {  //se e' un referendum
		$righet .= "<td>"._SI."</td><td>"._NO."</td>";
	} elseif ((($genere==5) or ($genere==3)) and $pag==1){
		$righet .= "<td>"._ASOLA_LISTA."</td><td>"._ASOLO_GRUPPO."</td>";
	}
	if($totel==0) $totelrip="0.00"; else $totelrip=number_format($tot_voti*100/$totel,2);
	if($totf==0) $totfrip="0.00"; else $totfrip=number_format($tot_d*100/$totf,2);
 	if($totm==0) $totmrip="0.00"; else $totmrip=number_format($tot_u*100/$totm,2);
	$righet .= "<td>"._VALIDI."</td><td>"._NULLI."</td><td>"._BIANCHI."</td><td>"._CONTESTATI."</td>"
    ."</tr>



	<tr class=\"td-vuotoc\"><td><b>"._TOT."</b></td><td><b>".number_format($tot_u,0,',','.')."</b><br /><i>(".$totmrip." %)</i></td><td><b>".number_format($tot_d,0,',','.')."</b><br /><i>(".$totfrip." %)</i></td><td><b>".number_format($tot_voti,0,',','.')."</b><br /><i>(".$totelrip." %)</i></td>";
	
	// se e' un referendum o una consultazione con raggruppamenti

	if($tot_validi){
	if ($genere==0 or ((($genere==5) or ($genere==3)) and $pag==1)){$righet .= "<td><b>".number_format($tot_si,0,',','.')."</b><br /><i>(".number_format($tot_si*100/$tot_validi,2)." %)</i></td><td><b>".number_format($tot_no,0,',','.')."</b><br /><i>(".number_format($tot_no*100/$tot_validi,2)." %)</i></td>";}
	$righet .= "<td><b>".number_format($tot_validi,0,',','.')."</b><br /><i>(".($tot_voti ? number_format($tot_validi*100/$tot_voti,2):'0.00')." %)</i></td><td><b>"
	.number_format($tot_nulli,0,',','.')."</b><br /><i>(".($tot_voti ? number_format($tot_nulli*100/$tot_voti,2):'0.00')." %)</i></td><td><b>".number_format($tot_bianchi,0,',','.')."</b><br /><i>(".($tot_voti ? number_format($tot_bianchi*100/$tot_voti,2):'0.00')." %)</i></td><td><b>".number_format($tot_contestati,0,',','.')."</b><br /><i>(".($tot_voti ? number_format($tot_contestati*100/$tot_voti,2):'0.00')." %)</i></td></tr>";
	}else{
	if ($genere==0 or ((($genere==5) or ($genere==3)) and $pag==1)){$righet .= "<td><b>".number_format($tot_si,0,',','.')."</b><br /><i>(0.00 %)</i></td><td><b>".number_format($tot_no,0,',','.')."</b><br /><i>(0.00 %)</i></td>";}
	$righet .= "<td><b>0</b><br /><i>(0.00 %)</i></td><td><b>"
	.number_format($tot_nulli,0,',','.')."</b><br /><i>(".($tot_voti ? number_format($tot_nulli*100/$tot_voti,2):'0,00')." %)</i></td><td><b>".number_format($tot_bianchi,0,',','.')."</b><br /><i>(".($tot_voti ? number_format($tot_bianchi*100/$tot_voti,2):'0,00')." %)</i></td><td><b>".number_format($tot_contestati,0,',','.')."</b><br /><i>(".($tot_voti ? number_format($tot_contestati*100/$tot_voti,2):'0,00')." %)</i></td></tr>";
	}
	}
	$righe .= "</table>";

	$html .= "$riga1";
	$html .= $riga2."";
	$html .= $righet;
	$html .= $riga3;
	$html .= $righe;
	

    $html .="<div>";
    if($genere==0){ //se e' referendum
        #'Pagina precedente' e 'Pagina Successiva'
	    $cur=$num_ref;
        if ($cur>1) {
              $num_ref--;
			  $html .= "<a href=\"modules.php?name=Elezioni&amp;op=come&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;info=votanti&amp;num_ref=$num_ref&amp;num_refs=$num_refs&amp;csv=$csv\">";
              $html .= "[ <b>"._PREV_MATCH."</b> ]</a>";
        }
        if ($cur<$num_refs) {
	        $cur++;        
			$html .= "<a href=\"modules.php?name=Elezioni&amp;op=come&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;info=votanti&amp;num_ref=$cur&amp;num_refs=$num_refs&amp;csv=$csv\">";
			
            $html .= "[ <b>"._NEXT_MATCH."</b> ]</a>";
        }
    }elseif((($genere==5) or ($genere==3))){ //se vi sono raggruppamenti
	      if($csv!=1){

		$pag=($pag==0 ? 1:0);
		$html .= "<a href=\"modules.php?name=Elezioni&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;op=come&amp;info=votanti&amp;pag=$pag&amp;csv=$csv\"><b>";
		if($pag) $html .=  _VOTIL;
	       //_CONTR_CONS;
		else $html .= _VOTIE; 
		//_CONTR_ESPR;
		$html .= "</b></a>";
	      }
	}
	

if($csv==1){
      $data=date("d-m-y G:i");
      $html .="<br/><div style=\"margin:0px auto;text-align:center;\"><i>Stampato: $data</i></div>";
      $html .="<br/><div style=\"text-align:center;\"><i>Eleonline by l. apolito & r. gigli - www.eleonline.it</i></div>";		
      //$html .= $html;	
      
}	
$html .= "</div>";


############### stampa
if ($xls!='1'){
      echo "$datipdf $html";
}else{
	$nomefile="export.xls";
	header ("Content-Type: application/vnd.ms-excel");
	header ("Content-Disposition: inline; filename=$nomefile");

	echo "$datipdf";
	echo "$html \n";
}


if($csv!=1 ) include ("footer.php");



?>
