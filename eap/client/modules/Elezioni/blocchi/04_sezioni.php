<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

if (!defined('MODULE_FILE')) {
    die ("You can't access this file dirrectly...");
}
global  $prefix, $dbi,$id_cons_gen;
$sql = mysql_query("select chiusa  from ".$prefix."_ele_cons_comune where id_cons_gen='$id_cons_gen'",$dbi);
		list($chiusa) = mysql_fetch_row($sql);
		if($chiusa!='1') numeri_sezione();
		//echo $chiusa;



function numeri_sezione() {
global  $prefix, $dbi, $circo, $genere,$id_cons_gen,$id_cons,$id_circ,$tipo_cons,$votog;


if (isset($circo) and $circo) $circos="and t2.id_circ='$id_circ'";
else $circos=''; 

		if ($genere==0) $tab="ref";elseif($genere=='4' || $votog) $tab="lista";
		 else $tab="gruppo";
		 
		# numero sezioni
		$res = mysql_query("select t1.id_sez,t1.num_sez  from ".$prefix."_ele_sezioni as t1 left join ".$prefix."_ele_sede as t2 on t1.id_sede=t2.id_sede where t1.id_cons='$id_cons' $circos order by t1.num_sez",$dbi);
		$max = mysql_num_rows($res);
		if(!isset($html)) $html='';
		$html = "\n<table  style=\"margin:0px auto;border=0px; width:90%\"><tr>";
		
		$i=0;$id_circ_old=0;$e=0;
		while(list($sez_id, $sez_num) = mysql_fetch_row($res)) {
			$i++;
			/****************************************************************/     
			/* suddivisione in circoscrizione - attivare se è il caso

			 $result = mysql_query("SELECT id_circ FROM ".$prefix."_ele_sede where id_cons='$id_cons' and id_sede='$sede_id' ", $dbi);
			list($circ_id) = mysql_fetch_row($result);
			if($circ_id!=$id_circ_old){ 
			      $id_circ_old=$circ_id;
			      $result2 = mysql_query("SELECT descrizione FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons' and id_circ='$circ_id' ", $dbi);
			      list($descrizione) = mysql_fetch_row($result2);
			      echo "</tr></table><table><tr><td>$descrizione</td></tr></table>";
			      echo "\n<table align=\"left\" border=\"0\" width=\"90%\"><tr bgcolor=\"$bgcolor1\">";
			}
			*/
			
			#colora la sezione
			# verifica se la sezione è scrutinata
			 $res2 = mysql_query("select *  from ".$prefix."_ele_voti_".$tab." where   id_sez='$sez_id'",$dbi);
			 $numero=mysql_num_rows($res2); 
			 if ($numero!=0){$e++;$bgsez="#FFFF00";}else{$bgsez="";}
			

			
			
			$html .="<td style=\"margin:0px auto; text-align:center; width:5%;\" bgcolor=\"$bgsez\"><b>$sez_num</b></td>";

			if (($i%8) ==0) $html .="</tr>\n<tr>";
		}
		
		$html .="</tr></table>\n";
    // stampa
    if($e!='0'){
	  echo "<div><h5>"._SEZSCRU."</h5></div>";
	  echo "<center> <img  alt=\"Grafico\" src=\"modules/Elezioni/grafici/ledex2.php?sez=$e&max=$max\" /></center>";
	   
    echo $html;	}	
}


?>
