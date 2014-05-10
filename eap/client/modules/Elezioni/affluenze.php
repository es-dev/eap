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



if (isset($param['id_cons_gen'])) $id_cons_gen=intval($param['id_cons_gen']); else $id_cons_gen='';
if (isset($param['num_ref'])) $num_ref=intval($param['num_ref']);
if (isset($param['num_refs'])) $num_refs=intval($param['num_refs']);
if (isset($param['id_comune'])) $id_comune=intval($param['id_comune']);
if (isset($param['xls'])) $xls=intval($param['xls']);
$res = mysql_query("SELECT t1.tipo_cons,t3.genere,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2, ".$prefix."_ele_tipo as t3 where t1.tipo_cons=t3.tipo_cons and t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$genere,$id_cons) = mysql_fetch_row($res);
global $lang,$circo,$id_circ;

if (isset($circo) and $circo) $circos="and t2.id_circ='$id_circ'";
else $circos=''; 

# testata
include_once("modules/Elezioni/language/lang-$lang.php");
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
	$datipdf .="	  <h2><b>"._DETTAGLIO."  "._AFFLUENZE."</b></h2></div>";

	$html = "<style type=\"text/css\">
	<!--

	.td-89 {
	width: 89%;	
	border: 1px;
	text-align: left; 
	}
	.td-vuoto {
		
	width: 100%;	
	border: 1px;
	text-align: left; 
	
}


	.td-5 {
	
	margin: 0px 0 0 0px;
	width: 5%;	
	/*border: none;*/
	padding: 0px;
        
	text-align: center; 
	}	



	.bggray 	{
		background: #ffffff; 
		FONT-SIZE: 13px; 
		FONT-FAMILY: Helvetica;
		border: 1px;
	}

	.bggray2 	{
		background: #EFEFEF; 
		FONT-SIZE: 13px; 
		FONT-FAMILY: Helvetica;
		border: 1px;
		}
	-->
	</style>";




}
	
      




    
	// referendum
	
	
	if (!IsSet($num_ref)) { 
		$num_ref=1;
		$resg = mysql_query("SELECT id_gruppo from ".$prefix."_ele_gruppo where id_cons='$id_cons'", $dbi);
		$num_refs= mysql_num_rows($resg); //quante pagine?
	}	
	if($genere=='0'){
		$resg = mysql_query("SELECT id_gruppo from ".$prefix."_ele_gruppo where id_cons='$id_cons' and num_gruppo='$num_ref'", $dbi);	
		list($id_gruppo)=mysql_fetch_array($resg);
	
	
	}
	// icone stampa e grafici
	
	if (!$csv){
	if(!isset($html)) $html='';
	$html .= "<div>
	<a href=\"modules.php?name=Elezioni&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;op=affluenze_graf\">
	"._VER_GRAF." <img class=\"image\" src=\"modules/Elezioni/images/grafici.png\" alt=\"\" /></a>
	<a href=\"modules.php?name=Elezioni&amp;op=come&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;info=affluenze_sez&amp;csv=1\">"._VER_STAMPA."
	<img class=\"image\" src=\"modules/Elezioni/images/printer.png\" alt=\"\" /></a>
	<a href=\"modules.php?name=Elezioni&amp;op=come&amp;file=index&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;info=affluenze_sez&amp;csv=1&amp;xls=1\">
	<img class=\"image\" src=\"modules/Elezioni/images/csv.gif\" alt=\"\" /></a>

	</div>

	<h2><b>"._DETTAGLIO."  "._AFFLUENZE."</b></h2>";
	  }  
	
	// descrizione
	 if ($genere==0){
	 $des = mysql_query("select descrizione from ".$prefix."_ele_gruppo where id_gruppo='$id_gruppo'", $dbi);
		list($descrizione)=mysql_fetch_array($des);
	        if(!isset($html)) $html='';
		$html .= "<div><h4>$descrizione</h4></div>";
	}
	
	
	$cond= $genere==0 ? "and t3.id_gruppo='$id_gruppo'" : "";
	$i=1;
	
	
	$res = mysql_query("SELECT num_sez,id_sez,t1.id_sede, t2.id_circ,maschi,femmine,(maschi+femmine) as elettori FROM ".$prefix."_ele_sezioni as t1, ".$prefix."_ele_sede as t2 where t1.id_cons='$id_cons' and t1.id_sede=t2.id_sede $circos order by num_sez", $dbi);
	while ($linka[$i++] = mysql_fetch_array($res));
#	while (list($appo) = mysql_fetch_array($res)) {$i=$appo['num_sez']; $linka[$i] = $appo;echo "\nnum:$i:".$linka[$i]['num_sez'];}die();
	$num_sez = mysql_num_rows($res); //numero totale delle sezioni
	$sez_da=$linka[1]['num_sez'];
	$sez_a=$sez_da+$num_sez-1;
	$tot_compl=0;$tot_u=0;$tot_d=0;
//	$ar['riga1'][0]="<hr>";
	$tot= array();
	$ar[0][0]="<b>TOTALI</b>";
	$ar['perc'][0]="Perc.";
//	$ar['riga2'][0]="<hr>";
#	foreach($linka['num_sez'] as $i)
$y=1;
for ($i=$sez_da;$i<=$sez_a;$i++,$y++)	{	
#		$ar[$i]['numsez']=$i;
		
		$ar[$i]['numsez']=$linka[$y]['num_sez'];
		$ar[$i]['elettori']=number_format($linka[$y]['elettori'],0,',','.');
		$tot_compl+=$linka[$y]['elettori'];
		$tot_u+=$linka[$y]['maschi'];
		$tot_d+=$linka[$y]['femmine'];
		
	}
	$ar[0][1]="<b>".number_format($tot_compl,0,',','.')."</b>";

	$ar['perc'][1]=" ";

	$perc_u=0;$perc_d=0;$perc_c=0;
#	$resril = mysql_query("SELECT t1.data,t1.orario FROM ".$prefix."_ele_rilaff as t1 where t1.id_cons_gen='$id_cons_gen' and 0<(select count(0) from ".$prefix."_ele_voti_parziale as t2, ".$prefix."_ele_cons_comune as t3 where t3.id_cons_gen=t1.id_cons_gen and t3.id_cons=t2.id_cons and t2.data=t1.data and t2.orario=t1.orario) order by t1.data,t1.orario", $dbi);
	$resril = mysql_query("SELECT t1.data,t1.orario FROM ".$prefix."_ele_rilaff as t1 left join ".$prefix."_ele_voti_parziale as t2 on t2.data=t1.data and t2.orario=t1.orario left join ".$prefix."_ele_cons_comune as t3 on t3.id_cons_gen=t1.id_cons_gen where t1.id_cons_gen='$id_cons_gen' and t3.id_cons=t2.id_cons group by t1.data,t1.orario order by t1.data,t1.orario", $dbi);
	$num_ril= mysql_num_rows($resril);  //numero delle rilevazioni previste
        if(!isset($html)) $html='';
	$html .= "<table class=\"td-89\">";
	$html .= "<tr class=\"bggray\"><td class=\"\">"._SEZIONI."</td><td>"._ISCR_SEZ."</td>";
#	$ressomma = mysql_query("SELECT  data,orario,sum(voti_complessivi),sum(voti_uomini),sum(voti_donne) from ".$prefix."_ele_voti_parziale where id_cons=$id_cons $cond group by data,orario,id_gruppo", $dbi);

		$resuo = mysql_query("SELECT orario,data FROM ".$prefix."_ele_rilaff where id_cons_gen=$id_cons_gen order by data desc,orario desc limit 0,1", $dbi);
		list($ultora,$ultdata)=mysql_fetch_row($resuo);
		


  	$ressomma = mysql_query("select t3.data,t3.orario,sum(t3.voti_complessivi),sum(t3.voti_uomini),sum(t3.voti_donne)  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' $circos  group by t3.data,t3.orario,t3.id_gruppo order by t3.data,t3.orario",$dbi);
#die("select t3.data,t3.orario,sum(t3.voti_complessivi),sum(t3.voti_uomini),sum(t3.voti_donne)  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' $circos  group by t3.data,t3.orario,t3.id_gruppo ");
$perc_u=array(); $perc_d=array(); $perc_c=array();
	while (list($data,$ora,$somma,$votiu,$votid) = mysql_fetch_row($ressomma)) {
		$perc_u[$data.$ora]=0;
		$perc_d[$data.$ora]=0;
		$perc_c[$data.$ora]=0;
		if($votiu or $votid)
#		if(($data==$ultdata) and ($ora==$ultora))
		{
			$tot[$data.$ora]="<table class=\"td-89\" width=\"100%\"><tr class=\"bggray2\"><td class=\"td-30\">
			<b>".number_format($votiu,0,',','.')."</b></td><td class=\"td-30\">
			<b>".number_format($votid,0,',','.')."</b></td><td>
			<b>".number_format($somma,0,',','.')."</b></td>
			</tr></table>";
			$perc_u[$data.$ora]=number_format($votiu*100/$tot_u,2);
			$perc_d[$data.$ora]=number_format($votid*100/$tot_d,2);
			$perc_c[$data.$ora]=number_format($somma*100/$tot_compl,2);
		}
		else
			$tot[$data.$ora]=$somma;
	}
	$ud=0;$ora_rif="";
	while (list($data1,$ora1) = mysql_fetch_row($resril)) 
	{
		$ud++;	
		list($hour, $minute, $second) = explode(":", $ora1);
		$ora_ril=$hour.":".$minute;
		$html .= "<td"; 
		if ($ud==$num_ril and ($perc_u[$data1.$ora1] or $perc_d[$data1.$ora1])) {$ora_rif="$data1.$ora1";}
		$html .= ">";
		$data_a=form_data($data1);
		$html .= "".$data_a."<br />"._ORE." ".$ora_ril;
		$resaff = mysql_query("SELECT count(data) FROM ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t1.id_cons='$id_cons' and data='$data1' and orario='$ora_ril' $circos group by t3.id_gruppo", $dbi);
		list($num_scr) = mysql_fetch_row($resaff);  //numero delle sezioni inserite
		$html .= "<br />"._SEZIONI." $num_scr "._SU." $num_sez";
##		if ($ud==$num_ril and ($perc_u or $perc_d)) $html .= "<br />
		if (($perc_u[$data1.$ora1] or $perc_d[$data1.$ora1])) $html .= "<br />
		
		<table class=\"td-vuoto\"  width=\"100%\"><tr class=\"bggray\">
		<th class=\"td-30\">"._UOMINI."</th>
		<th class=\"td-30\">"._DONNE."</th>
		<th>"._COMPLESSIVI."</th>
		</tr></table>";
		
		$html .= "</td>";

	if (isset($tot[$data1.$ora1])){
##		if ($ora_rif=="$data1.$ora1")
if (($perc_u[$data1.$ora1] or $perc_d[$data1.$ora1]))		{
			$ar['perc'][$data1.$ora1]="<table class=\"td-vuoto\"  width=\"100%\"><tr class=\"bggray2\">
			<td class=\"td-30\"><b><i><span class=\"red\">".$perc_u[$data1.$ora1]."%</span></i></b></td>
			<td class=\"td-30\"><b><i><span class=\"red\">".$perc_d[$data1.$ora1]."%</span></i></b></td>
			<td ><span class=\"red\"><b><i>".$perc_c[$data1.$ora1]."%</i></b></span></td>
			</tr></table>";
			$ar[0][$data1.$ora1]=$tot[$data1.$ora1];
		}
		else
		{
			$ar['perc'][$data1.$ora1]="<b><span class=\"red\"><i>
			".number_format($tot[$data1.$ora1]*100/$tot_compl,2)."%</i></span></b>";
			$ar[0][$data1.$ora1]="<b>".(number_format($tot[$data1.$ora1],0,',','.'))."</b>";
		}

		if (intval(preg_match('/[1-9]/',$tot[$data1.$ora1]))>0) {
#foreach($ar[['num_sez'] as $i)
		for ($i=$sez_da;$i<=$sez_a;$i++)
			{
				$ar[$i][$data1.$ora1]="<span style=\"color: rgb(255, 0, 0);\">non rilevata</span>";
			}
		}
	}
	}
  	$resvoti = mysql_query("select t3.data,t3.orario,t1.num_sez,voti_uomini, voti_donne, voti_complessivi  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' $circos $cond order by data,orario,t1.num_sez ",$dbi);
#	$resvoti = mysql_query("SELECT  data,orario,t2.num_sez,voti_uomini, voti_donne, voti_complessivi from ".$prefix."_ele_voti_parziale as t1, ".$prefix."_ele_sezioni as t2 where t1.id_cons=$id_cons and t1.id_sez=t2.id_sez $cond order by data,orario,t2.num_sez", $dbi);
	$ud=0;
#die("select t3.data,t3.orario,t1.num_sez,voti_uomini, voti_donne, voti_complessivi  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' $circos $cond order by data,orario,t2.num_sez ");
	while (list($data,$ora,$numsez,$uomini,$donne,$complessivi) = mysql_fetch_row($resvoti)) {
#		if ($ora_rif=="$data.$ora")
		if(($uomini+$donne)>0)
			$ar[$numsez][$data.$ora]="<table class=\"td-vuoto\"  width=\"100%\"><tr class=\"bggray2\">
			<td class=\"td-30\" width=\"33%\">$uomini</td>
			<td class=\"td-30\" width=\"33%\">$donne</td>
			<td >$complessivi</td>
			</tr></table>";
		else
			$ar[$numsez][$data.$ora]=$complessivi;
	}
    $html .= "</tr>";

	foreach ($ar as $i => $arr) {
		$html .= "<tr class=\"bggray2\">";
		foreach ($arr as $valore)
		{
		
			$html .= "<td class=\"bggray2\">$valore</td>";
		}
		$html .= "</tr>";
	}

	
	     
	     $html .= "</table>";
		
	     if($genere==0){ //se e' referendum
        #'Pagina precedente' e 'Pagina Successiva'
	$html .= "<div class=\"modulo\">";
	    $cur=$num_ref;
        if ($cur>1) {
		
              	$num_ref--;
			  $html .= "<a href=\"modules.php?name=Elezioni&amp;op=come&amp;info=affluenze_sez&amp;id_cons_gen=$id_cons_gen&amp;num_ref=$num_ref&amp;num_refs=$num_refs&amp;id_comune=$id_comune\">";
              	$html .= "[ <b>"._PREV_MATCH."</b> ] </a>";
        }
        if ($cur<$num_refs) {
	        $cur++;        
			$html .= "<a href=\"modules.php?name=Elezioni&amp;op=come&amp;info=affluenze_sez&amp;id_cons_gen=$id_cons_gen&amp;num_ref=$cur&amp;num_refs=$num_refs&amp;id_comune=$id_comune\">";
            $html .= "[ <b>"._NEXT_MATCH."</b> ] </a>";
        }
	$html .= "</div>";
	}

	
if(!isset($style)) $style='';	
if($csv==1){
      $data=date("d-m-y G:i");
      $style .="\t\t\n<br/><br/><br/><div style=\"margin:0px auto;text-align:center;\"><i>Stampato: $data</i></div>";
      $style .="<br/><div style=\"text-align:center;\"><i>Eleonline by l. apolito & r. gigli - www.eleonline.it</i></div>";		
      $style .= "<br/>  ";	
      
}	
$html .= "</div>";


############### stampa
if ($xls!='1'){
      echo "$datipdf $html $style";
}else{
	$nomefile="export.xls";
	header ("Content-Type: application/vnd.ms-excel");
	header ("Content-Disposition: inline; filename=$nomefile");

	echo "$datipdf";
	echo "$html \t\n $style";
}


if($csv!=1 ) include ("footer.php");
  
?>
