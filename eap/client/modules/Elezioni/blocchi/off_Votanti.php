<?php 
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

if (!defined('MODULE_FILE')) {
    die ("You can't access this file dirrectly...");
}

global $op, $prefix, $dbi, $offset, $min,$descr_cons,$genere,$votog,$votol,$votoc,$circo, $id_cons,$tipo_cons,$id_comune,$id_cons_gen,$id_circ,$csv,$w,$l,$siteistat,$flash,$tour;

if ($genere==0) $tab="ref";elseif($genere=='4' || $votog) $tab="lista";
		 else $tab="gruppo";

if (isset($circo) and $circo) $circos="and t2.id_circ='$id_circ'";
else $circos=''; 

#$res = mysql_query("select *  from ".$prefix."_ele_voti_".$tab." where id_cons='$id_cons'  group by id_sez ",$dbi);
#	$numero=mysql_num_rows($res);
#	$res = mysql_query("select *  from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi);
  	$res = mysql_query("select t3.*  from ".$prefix."_ele_voti_".$tab." as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' $circos  group by t3.id_sez ",$dbi);
	$numero=mysql_num_rows($res);
	$res = mysql_query("select t1.*  from ".$prefix."_ele_sezioni as t1 left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t1.id_cons='$id_cons' $circos",$dbi);
	$sezioni=mysql_num_rows($res);
	
	if ($numero!=0){

	
	echo "<h5><b>"._DETTAGLIO." "._VOTIE."</b> - </h5>";
	echo "<div style=\"text-align:center;\"><i> "._SEZSCRU." $numero "._SU." $sezioni </i></div>";
	



	$res1 = mysql_query("SELECT sum(t1.maschi+t1.femmine) FROM ".$prefix."_ele_sezioni as t1 left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t1.id_cons='$id_cons' $circos",$dbi);
	list($tot_aventi)  = mysql_fetch_row($res1);
	if ($genere!=0) {

		$res1 = mysql_query("SELECT sum(t1.validi+t1.nulli+t1.bianchi+t1.contestati) as tot,
		sum(t1.validi),sum(t1.nulli),sum(t1.bianchi),sum(t1.contestati), '0'
		from ".$prefix."_ele_sezioni as t1 left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t1.id_cons=$id_cons $circos having tot>0",$dbi);
	}else{
		$res1 = mysql_query("SELECT sum(validi+nulli+bianchi+contestati) as tot,
		sum(validi),sum(nulli),sum(bianchi),sum(contestati), id_gruppo
		from ".$prefix."_ele_voti_ref  where id_cons=$id_cons group by id_gruppo having tot>0",$dbi);
	}

	while  (list($tot_votanti,$validi,$nulli,$bianchi,$contestati,$id)  = mysql_fetch_row($res1)){
		$tot_votanti=$validi+$bianchi+$nulli+$contestati;
		$perc_validi=number_format($validi*100/$tot_votanti,2);
		$perc_nulli=number_format($nulli*100/$tot_votanti,2);
		$perc_bianchi=number_format($bianchi*100/$tot_votanti,2);
		$perc_conte=number_format($contestati*100/$tot_votanti,2);
		$perc_votanti=number_format($tot_votanti*100/$tot_aventi,2);
		$non_votanti=($tot_aventi - $tot_votanti);
		$perc_non=100-$perc_votanti;

		if ($genere==0) {
			$res = mysql_query("SELECT num_gruppo,descrizione from ".$prefix."_ele_gruppo where id_gruppo=$id",$dbi);
			list($num_gruppo,$descr_gruppo)  = mysql_fetch_row($res);
		}
		  

		    
		
		echo "<table bgcolor=\"gray\" class=\"modulo\" width=\"100%\" cellspacing=\"1\">";
		if ($genere==0) {echo "<br/>Referendum n. <b>[$num_gruppo]</b><br/>";}
		echo "
		<tr bgcolor=\"#ffffff\"><td ><b>"._AVENTI."</b></td><td>$tot_aventi</td><td><span class=\"red\">100%</span></td></tr>

		<tr bgcolor=\"#ffffff\"><td><b>"._VOTANTI."</b></td><td>$tot_votanti</td><td><span class=\"red\">$perc_votanti%</span></td></tr>
		
		<tr bgcolor=\"#ffffff\"><td>"._VALIDI."</td><td>$validi</td><td><span class=\"red\">$perc_validi%</span></td></tr>
		
		<tr bgcolor=\"#ffffff\"><td>"._NULLI."</td><td>$nulli</td><td><span class=\"red\">$perc_nulli%</span></td></tr>
		
		<tr bgcolor=\"#ffffff\"><td>"._BIANCHI."</td><td>$bianchi</td><td><span class=\"red\">$perc_bianchi%</span></td></tr>
		
		<tr bgcolor=\"#ffffff\"><td>"._CONTESTATI."</td><td>$contestati</td><td><span class=\"red\">$perc_conte%</span></td></tr>

		</table>";

    }
}







?>
