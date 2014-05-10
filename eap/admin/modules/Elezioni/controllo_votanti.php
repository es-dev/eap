<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Controllo dei votanti                                         */
/* Amministrazione                                                      */
/************************************************************************/

if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$currentlang=$_SESSION['lang'];
$id_comune=$_SESSION['id_comune'];
$id_cons_gen=$_GET['id_cons_gen'];
$bgcolor0=$_SESSION['bgcolor1'];
$perms=ChiSei($id_cons_gen);
if ($perms<16 or !$id_cons_gen) die("$perms ".$_SESSION['id_comune'].$_SESSION['aid'].";Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);
$res = mysql_query("SELECT genere FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons' " , $dbi);
	list($genere) = mysql_fetch_row($res);
if (isset($param['ops'])) get_magic_quotes_gpc() ? $ops=$param['ops']:$ops=addslashes($param['ops']); else $ops='';
if (isset($param['pag'])) $pag=intval($param['pag']); else $pag=0;
if (isset($param['num_ref'])) $num_ref=intval($param['num_ref']);
if (isset($param['num_refs'])) $num_refs=intval($param['num_refs']);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
//	echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n"
//	."//-->\n";
//	echo "function com_pref(testo) {\n";
//	echo "window2=open(testo,\"test di apertura\")\n";
//	echo "}\n";
//	echo "</script>\n";

ele();
//**************************************************************************
//        ELE
//**************************************************************************
 
    global $admin, $bgcolor1, $bgcolor2, $prefix, $dbi, $genere, $id_gruppo;
	
	$cond='';
	if ($genere==0) {
		if (!IsSet($pag)) {$pag=0;} //inizializza il numero di pagina 
		if (!IsSet($num_ref)) { 
			$num_ref=1;
			$resg = mysql_query("SELECT id_gruppo from ".$prefix."_ele_gruppo where id_cons=$id_cons", $dbi);
			$num_refs= mysql_num_rows($resg); //quante pagine?
		}
		$resg = mysql_query("SELECT id_gruppo,num_gruppo from ".$prefix."_ele_gruppo where id_cons=$id_cons and num_gruppo=$num_ref", $dbi);
		list($idg,$numg) = mysql_fetch_row($resg);
		$id_gruppo=$idg;
		$cond= "and id_gruppo=$id_gruppo";
		//echo "\n<table border=\"0\" width=\"100%\" bgcolor=\"$bgcolor1\" ><tr><td align=\"center\">"._CONSULTAZIONE." N. ".$numg."</td></tr></table>\n<hr>";
		echo "\n<table border=\"0\" width=\"100%\" bgcolor=\"$bgcolor1\" ><tr><td align=\"center\">"._CONSULTAZIONE."</td></tr></table>\n<hr>";
	}
	$i=1;
	$res = mysql_query("SELECT num_sez,id_sez,t1.id_sede, t2.id_circ,maschi,femmine,(maschi+femmine) as elettori FROM ".$prefix."_ele_sezioni as t1, ".$prefix."_ele_sede as t2 where t1.id_cons='$id_cons' and t1.id_sede=t2.id_sede order by num_sez", $dbi);
	while ($linka[$i++] = mysql_fetch_array($res));
	$num_sez = mysql_num_rows($res); //numero totale delle sezioni
	$tot_compl=0;$tot_u=0;$tot_d=0;
//	$ar['riga1'][0]="<hr>";
	$ar[0][0]="<b>"._TOTS."</b>";
	$ar['perc'][0]=_PERC;
//	$ar['riga2'][0]="<hr>";
	for ($i=1;$i<=$num_sez;$i++)
	{	
		$ar[$i]['numsez']=$i;
		$ar[$i]['elettori']=number_format($linka[$i]['elettori'],0,',','.');
		$tot_compl+=$linka[$i]['elettori'];
		$tot_u+=$linka[$i]['maschi'];
		$tot_d+=$linka[$i]['femmine'];
		
	}
	$ar[0][1]="<b>".number_format($tot_compl,0,',','.')."</b>";
//	$ar['riga1'][1]="<hr>";
	$ar['perc'][1]=" ";
//	$ar['riga2'][1]="<hr>";
		$resuo = mysql_query("SELECT orario,data FROM ".$prefix."_ele_rilaff where id_cons_gen=$id_cons_gen order by data desc,orario desc limit 0,1", $dbi);
		list($ultora,$ultdata)=mysql_fetch_row($resuo);

	$resril = mysql_query("SELECT data,orario FROM ".$prefix."_ele_rilaff where id_cons_gen='$id_cons_gen' order by data,orario", $dbi);
	$num_ril= mysql_num_rows($resril);  //numero delle rilevazioni previste
	echo "\n<table border=\"0\" width=\"100%\"  align=\"center\">";
	echo "<tr bgcolor=\"$bgcolor1\" align=\"center\"><td width=\"5%\"><b>"._SEZIONI."</b></td><td><b>"._ISCRITTI."<br>"._INSEZ."</b></td>";
	$ressomma = mysql_query("SELECT  data,orario,sum(voti_complessivi),sum(voti_uomini),sum(voti_donne) from ".$prefix."_ele_voti_parziale where id_cons=$id_cons $cond group by data,orario", $dbi);
	while (list($data,$ora,$somma,$votiu,$votid) = mysql_fetch_row($ressomma)) {
		$perc_u='';$perc_d='';$perc_c='';
#		if($votiu or $votid)
		if(($data==$ultdata) and ($ora==$ultora))
		{
			$tot[$data.$ora]="\n<table width=\"100%\"><tr align=\"center\"><td width=\"30%\"><b>".number_format($votiu,0,',','.')."</b></td><td width=\"30%\"><b>".number_format($votid,0,',','.')."</b></td><td><b>".number_format($somma,0,',','.')."</b></td></tr></table>\n";
			if($tot_u) $perc_u=number_format($votiu*100/$tot_u,2);
			if($tot_d) $perc_d=number_format($votid*100/$tot_d,2);
			$perc_c=number_format($somma*100/$tot_compl,2);
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
		echo "<td";
		if ($ud==$num_ril) {$ora_rif="$data1.$ora1";}
		echo ">".form_data($data1)."<br>"._ORE." ".$ora_ril;
		$resaff = mysql_query("SELECT count(data) FROM ".$prefix."_ele_voti_parziale where id_cons='$id_cons' and data='$data1' and orario='$ora_ril' $cond", $dbi);
		list($num_scr) = mysql_fetch_row($resaff);  //numero delle sezioni inserite
		echo "<br>"._SEZIONI." $num_scr "._SU." $num_sez";
		if ($ud==$num_ril) echo "<br>\n<table width=\"100%\"><tr align=\"center\"><td width=\"30%\">"._UOMINI."</td><td width=\"30%\">"._DONNE."</td><td>"._COMPLESSIVI."</td></tr></table>\n";
		
		echo "</td>";
//	$ar['riga1'][$data1.$ora1]="<hr>";
	if (isset($tot[$data1.$ora1])){
		if ($ora_rif=="$data1.$ora1")
		{
			$ar['perc'][$data1.$ora1]="\n<table width=\"100%\"><tr align=\"center\"><td width=\"30%\"><i>$perc_u%</i></td><td width=\"30%\"><i>$perc_d%</i></td><td><i>$perc_c%</i></td></tr></table>\n";
			$ar[0][$data1.$ora1]=$tot[$data1.$ora1];
		}
		else
		{
			$ar['perc'][$data1.$ora1]="<i>".number_format($tot[$data1.$ora1]*100/$tot_compl,2)."%</i>";
			$ar[0][$data1.$ora1]="<b>".(number_format($tot[$data1.$ora1],0,',','.'))."</b>";
		}
//	$ar['riga2'][$data1.$ora1]="<hr>";
		if (intval(preg_match("/[1-9]/",$tot[$data1.$ora1]))>0) {
			for ($i=1;$i<=$num_sez;$i++)
			{
				$ar[$i][$data1.$ora1]="<a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_sez=".$linka[$i]['id_sez']."&amp;id_circ=".$linka[$i]['id_circ']."&amp;id_sede=".$linka[$i]['id_sede']."&amp;do=spoglio&amp;ops=1\"><span style=\"color: rgb(255, 0, 0);\">non rilevata</span>";
			}
		}
	}
	}
	$resvoti = mysql_query("SELECT  data,orario,t2.num_sez,voti_uomini, voti_donne, voti_complessivi from ".$prefix."_ele_voti_parziale as t1, ".$prefix."_ele_sezioni as t2 where t1.id_cons=$id_cons and t1.id_sez=t2.id_sez $cond order by data,orario,t2.num_sez", $dbi);
	$ud=0;
	while (list($data,$ora,$numsez,$uomini,$donne,$complessivi) = mysql_fetch_row($resvoti)) {
		if ($ora_rif=="$data.$ora")
			$ar[$numsez][$data.$ora]="\n<table width=\"100%\"><tr align=\"center\"><td width=\"30%\">$uomini</td><td width=\"30%\">$donne</td><td>$complessivi</td></tr></table>\n";
		else
			$ar[$numsez][$data.$ora]=$complessivi;
		if ($uomini+$donne>0) {
			if ($uomini+$donne!=$complessivi) {
				$ar[$numsez]['controllo']= "<a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_sez=".$linka[$numsez]['id_sez']."&amp;id_circ=".$linka[$numsez]['id_circ']."&amp;id_sede=".$linka[$numsez]['id_sede']."&amp;do=spoglio&amp;ops=1\"><span style=\"color: rgb(255, 0, 0);\">ERRORE</span></a>";
			} else {
				$ar[$numsez]['controllo']= "OK";
			}
		}
	}
    echo "<td><b>"._STATO."</b></td></tr>\n";

	foreach ($ar as $i => $arr) {
		echo "<tr bgcolor=\"$bgcolor2\" align=\"center\">";
		foreach ($arr as $valore)
		{
		
			echo "<td >$valore</td>";
		}
		echo "</tr>\n";
	}

	
	

     if($genere==0){ //se e' referendum
        #'Pagina precedente' e 'Pagina Successiva'
      echo "\n<table width=\"100%\"><tr align=middle>";
	    $cur=$num_ref;
        if ($cur>1) {
              $num_ref--;
			  echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=controllo_votanti&amp;id_cons_gen=$id_cons_gen&amp;num_ref=$num_ref&amp;num_refs=$num_refs\">";
              echo "<b>"._PREV_MATCH."</b></a></td>";
        }
        if ($cur<$num_refs) {
	        $cur++;        
			echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=controllo_votanti&amp;id_cons_gen=$id_cons_gen&amp;num_ref=$cur&amp;num_refs=$num_refs\">";
            echo "<b>"._NEXT_MATCH."</b></a></td>";
        }
        echo "</tr></table>\n";
	}

	echo "</table>\n<br>\n";

  echo "</table>\n";
  include ("footer.php");

?>
