<?php 
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* widget pie google affluenze 
  by luc 25 giugno 2009 */

if (!defined('MODULE_FILE')) {
    die ("You can't access this file dirrectly...");
}



global $circo,$prefix,$dbi,$id_cons,$genere,$id_circ,$id_comune,$id_cons_gen;

if (isset($circo) and $circo) $circos="and t2.id_circ='$id_circ'";
else $circos=''; 
// numero sezioni scrutinate

		$res2 = mysql_query("select t1.*  from ".$prefix."_ele_sezioni as t1 left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t1.id_cons='$id_cons' $circos",$dbi);
		$sezioni=mysql_num_rows($res2);

    $res = mysql_query("select orario,data  from ".$prefix."_ele_voti_parziale where id_cons='$id_cons' order  by data desc,orario desc limit 1", $dbi);
    if($res){

        while(list($orario,$data) = mysql_fetch_row($res)) {
        	list ($ore,$minuti,$secondi)=explode(':',$orario);
        	list ($anno,$mese,$giorno)=explode('-',$data);
        	$tot_v_m=0;$tot_v_d=0;$tot_t=0;
	

  		$res1 = mysql_query("select t3.*  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' and t3.data='$data' and t3.orario='$orario' $circos  group by t3.id_sez ",$dbi);
		$numero=mysql_num_rows($res1);
	
		echo "<h5>Ultime Affluenze</h5>";
               echo "<div style=\"text-align:center;color:#ff0000\"><b>"._ORE." $ore,$minuti "._DEL."  $giorno/$mese/$anno</b></div>";
                                                                                                                             

                
 
#		$res1 = mysql_query("select sum(t1.voti_complessivi), t2.num_gruppo , t2.id_gruppo from ".$prefix."_ele_voti_parziale as t1 left join ".$prefix."_ele_gruppo as t2 on (t1.id_gruppo=t2.id_gruppo) where t1.id_cons='$id_cons' and t1.orario='$orario' and t1.data='$data' group by t2.num_gruppo,t2.id_gruppo order by t2.num_gruppo " , $dbi);
#modifica del 26giugno 09 per gestione circoscrizionali
if($genere==0)		$res1 = mysql_query("select sum(t1.voti_complessivi), t2.num_gruppo , t2.id_gruppo from ".$prefix."_ele_voti_parziale as t1 left join ".$prefix."_ele_gruppo as t2 on (t1.id_gruppo=t2.id_gruppo) where t1.id_cons='$id_cons' and t1.orario='$orario' and t1.data='$data' group by t2.num_gruppo,t2.id_gruppo order by t2.num_gruppo " , $dbi);
else
  		$res1 = mysql_query("select sum(t3.voti_complessivi),0,0  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' and t3.data='$data' and t3.orario='$orario' $circos",$dbi);
#fine modifica
                                                                                                                                      
		
		
		
                                                                                                                             
                while(list($voti_t, $num_gruppo,$id_gruppo) = mysql_fetch_row($res1)) {

			$query="select sum(t3.voti_complessivi)  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' and t3.data='$data' and t3.orario='$orario' $circos";		
                	if ($genere==0){$query.=" and t3.id_gruppo=$id_gruppo";}
                	$res_aff=mysql_query($query, $dbi);
			$voti_numero=mysql_num_rows($res_aff);
              	
			$query="select sum(t1.maschi+t1.femmine)  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' and t3.data='$data' and t3.orario='$orario' $circos";		
			
			if ($genere==0){$query.=" and id_gruppo=$id_gruppo";}
                	$res1234=mysql_query($query, $dbi);
                	list($tot)=mysql_fetch_row($res1234);
                	if ($tot)
			    $perc=number_format($voti_t*100/$tot,2);
			else {$tot=0;$perc="0.00";}
	  
			$resto=100-$perc;
			if ($genere==0){echo "<div style=\"text-align:center\">referendum n. $num_gruppo</div";}

			echo "<center><img src=\"http://chart.apis.google.com/chart?
			chs=200x70
			&chd=t:$resto,$perc
			&cht=p3
			&chl=|$perc%
			&chco=ff0000,ffff00 \"
			alt=\"Sample chart\" />
			 <a href=\"modules.php?id_cons_gen=$id_cons_gen&name=Elezioni&id_comune=$id_comune&file=index&op=affluenze_graf\">Tutte le affluenze</a>
			</center>";



	}	

        }
}
?>
