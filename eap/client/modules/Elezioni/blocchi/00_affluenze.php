<?php 
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

global $circo,$prefix,$dbi,$id_cons,$genere,$id_circ;

if (isset($circo) and $circo) $circos="and t2.id_circ='$id_circ'";
else $circos=''; 
// numero sezioni scrutinate
//		$res2 = mysql_query("select *  from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi);
		$res2 = mysql_query("select t1.*  from ".$prefix."_ele_sezioni as t1 left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t1.id_cons='$id_cons' $circos",$dbi);
		$sezioni=mysql_num_rows($res2);
		
//echo "select *  from ".$prefix."_ele_sezioni where id_cons='$id_cons' $circos";	
	
		
	
// barre
    $l_size = getimagesize("modules/Elezioni/images/barre/leftbar.gif");
    $m_size = getimagesize("modules/Elezioni/images/barre/mainbar.gif");
    $r_size = getimagesize("modules/Elezioni/images/barre/rightbar.gif");
    $l_size2 = getimagesize("modules/Elezioni/images/barre/leftbar2.gif");
    $m_size2 = getimagesize("modules/Elezioni/images/barre/mainbar2.gif");
    $r_size2 = getimagesize("modules/Elezioni/images/barre/rightbar2.gif");
                                                                                                                           
#    $res = mysql_query("select orario,data  from ".$prefix."_ele_rilaff where id_cons_gen='$id_cons_gen' order  by data desc,orario DESC limit 1", $dbi);
#x Luciano: quella sopra diventa quella sotto. in rilaff ci sono tutte le date e orari di affluenza mentre in vot_parziale solo quelli inseriri
# inoltre va messo il desc anche alla data altrimenti il risultato ha la data piu' bassa e l'ora piu' alta
    $res = mysql_query("select orario,data  from ".$prefix."_ele_voti_parziale where id_cons='$id_cons' order  by data desc,orario desc limit 1", $dbi);
    if($res){

        while(list($orario,$data) = mysql_fetch_row($res)) {
        	list ($ore,$minuti,$secondi)=explode(':',$orario);
        	list ($anno,$mese,$giorno)=explode('-',$data);
        	$tot_v_m=0;$tot_v_d=0;$tot_t=0;
	
  		$res1 = mysql_query("select t3.*  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' and t3.data='$data' and t3.orario='$orario' $circos  group by t3.id_sez ",$dbi);

		$numero=mysql_num_rows($res1);
	
		echo "<br /><div><h5>Ultime Affluenze</h5></div>";
               echo "<div style=\"text-align:center;color:#ff0000\"><b>"._ORE." $ore,$minuti "._DEL."  $giorno/$mese/$anno</b></div>";
                                                                                                                             

                
                
		
#modifica del 26giugno 09 per gestione circoscrizionali
if($genere==0)		$res1 = mysql_query("select sum(t1.voti_complessivi), t2.num_gruppo , t2.id_gruppo from ".$prefix."_ele_voti_parziale as t1 left join ".$prefix."_ele_gruppo as t2 on (t1.id_gruppo=t2.id_gruppo) where t1.id_cons='$id_cons' and t1.orario='$orario' and t1.data='$data' group by t2.num_gruppo,t2.id_gruppo order by t2.num_gruppo " , $dbi);
else
  		$res1 = mysql_query("select sum(t3.voti_complessivi),0,0  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' and t3.data='$data' and t3.orario='$orario' $circos",$dbi);
#fine modifica
                                                                                                                                       

		
                                                                                                                             
                while(list($voti_t, $num_gruppo,$id_gruppo) = mysql_fetch_row($res1)) {
//  		$res1 = mysql_query(,$dbi);
//                	$query="select sum(voti_complessivi) from ".$prefix."_ele_voti_parziale where orario='$orario' and data='$data' and id_cons='$id_cons'";
$query="select sum(t3.voti_complessivi)  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' and t3.data='$data' and t3.orario='$orario' $circos";		
                	if ($genere==0){$query.=" and t3.id_gruppo=$id_gruppo";}
                	$res_aff=mysql_query($query, $dbi);
			$voti_numero=mysql_num_rows($res_aff);
 //               	$query="select sum(maschi+femmine) from ".$prefix."_ele_voti_parziale as t1 , ".$prefix."_ele_sezioni as t2 where t1.id_cons=$id_cons and t1.id_sez=t2.id_sez and orario='$orario' and data='$data'";
			$query="select sum(t1.maschi+t1.femmine)  from ".$prefix."_ele_voti_parziale as t3 left join ".$prefix."_ele_sezioni as t1 on t3.id_sez=t1.id_sez left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t3.id_cons='$id_cons' and t3.data='$data' and t3.orario='$orario' $circos";		
			
			if ($genere==0){$query.=" and id_gruppo=$id_gruppo";}
                	$res1234=mysql_query($query, $dbi);
                	list($tot)=mysql_fetch_row($res1234);
                	if ($tot)
                	$perc=number_format($voti_t*100/$tot,2);
			else {$tot=0;$perc="0.00";}																	echo "<table class=\"td-80\"><tr class=\"bggray\">";
			if ($genere==0){echo "<td>N.</td>";}
                	echo "<td><b>"._VOTANTI."</b></td><td><b>"._PERCE."</b></td>";
                	echo "<td><b>"._SEZIONI."</b></td>";
			echo "</tr>";
        		echo "<tr class=\"bggray2\">";
        		if ($genere==0){echo "<td>$num_gruppo</td>";}
//        		echo "<td>$voti_t</td><td>$perc %</td><td>$numero</td>
        		echo "<td>$voti_t</td><td>$perc %</td><td>$numero</td>
			</tr></table>";
	

        // barre
                                                                                                                             
        	echo "<table><tr><td><table><tr><td>&nbsp;</td><td>
<img src=\"modules/Elezioni/images/barre/leftbar2.gif\" height=\"$l_size2[1]\" width=\"$l_size2[0]\" alt=\"\" /><img src=\"modules/Elezioni/images/barre/mainbar2.gif\" alt=\"\" height=\"$m_size2[1]\" width=\"". ($perc * 1)."\" /><img src=\"modules/Elezioni/images/barre/rightbar2.gif\" height=\"$r_size2[1]\" width=\"$r_size2[0]\" alt=\"\" /><span class=\"red\"> $perc</span> % <br /></td></tr>\n";
		
		$tot_gen=$tot;


		echo  "<tr><td></td><td><img src=\"modules/Elezioni/images/barre/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" alt=\"\" /><img src=\"modules/Elezioni/images/barre/mainbar.gif\" alt=\"\" height=\"$m_size[1]\" width=\"".(100 * 1)."\" /><img src=\"modules/Elezioni/images/barre/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" alt=\"\" /> 100 % </td></tr></table>";
		 echo "</td></tr></table>";
		 
	}	

        }
}
?>
