<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Controllo dei voti                                            */
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
$bgcolor1=$_SESSION['bgcolor1'];
$bgcolor2=$_SESSION['bgcolor2'];

$perms=ChiSei($id_cons_gen);
if ($perms<16 or !$id_cons_gen) die("$perms Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);
$res = mysql_query("SELECT genere,voto_g,voto_l FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons' " , $dbi);
	list($genere,$votog,$votol) = mysql_fetch_row($res);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
if (! get_magic_quotes_gpc()) $magic='addslashes'; else $magic='';
if (isset($param['ops'])) get_magic_quotes_gpc() ? $ops=$param['ops']:$ops=addslashes($param['ops']); else $ops='';
if (isset($param['pag'])) $pag=intval($param['pag']); else $pag=0;
if (isset($param['num_ref'])) $num_ref=intval($param['num_ref']);
if (isset($param['num_refs'])) $num_refs=intval($param['num_refs']);
ele();
//**************************************************************************
//        ELE
//**************************************************************************
 
    global $prefix, $dbi,$fascia,$limite;
	$res = mysql_query("SELECT sum(maschi),sum(femmine) FROM ".$prefix."_ele_sezioni where id_cons='$id_cons'", $dbi);
	list($totm,$totf) = mysql_fetch_row($res);
	$totel=$totm+$totf;
	if (!IsSet($pag)) {$pag=0;} //inizializza il numero di pagina 
	if (!IsSet($num_ref)) { 
		$num_ref=1;
		$resg = mysql_query("SELECT id_gruppo from ".$prefix."_ele_gruppo where id_cons=$id_cons", $dbi);
		$num_refs= mysql_num_rows($resg); //quante pagine?
	}
	if((($genere!=4) and $pag==0 and !$votog) or $genere==1 or $genere==2){ //diverso da liste a piu' candidati
		$ops=4;	//gestione gruppi (anche liste uninominali)
	}else{
		$ops=3; //gestione liste
	}
	OpenTable();
	$resg = mysql_query("SELECT id_gruppo,num_gruppo from ".$prefix."_ele_gruppo where id_cons=$id_cons and num_gruppo=$num_ref", $dbi);
	list($idg,$numg) = mysql_fetch_row($resg);
	$res = mysql_query("SELECT id_sez,num_sez,t1.id_sede as id_sede,t2.id_circ as id_circ FROM ".$prefix."_ele_sezioni as t1,".$prefix."_ele_sede as t2 where t1.id_cons='$id_cons' and t1.id_sede=t2.id_sede order by num_sez", $dbi);
	$num_sez = mysql_num_rows($res); //quante sezioni?
for ($i=1;$i<=$num_sez;$i++){
		$sezione[$i]=mysql_fetch_array($res, 3); //inizializza l'array delle sezioni
		$ar[$i]=0;
	}
	$tab3="_ele_voti_lista";
//	if ($genere==3) {$tab3="_ele_voti_candidati";} else {$tab3="_ele_voti_lista";} //i voti di lista per le uninominali sono memorizzati in ele_voti_candidati altrimenti in ele_voti_lista.
if ($genere==1 or $genere==2) $tab3="_ele_voti_gruppo";
	if ($genere>0) {  //se non e' un referendum
		if (!($genere==4) and $pag==0){  //se non e' una lista uninominale ed e' la prima pagina
			$tab="SELECT 0,t2.id_sez,t2.num_sez,t2.validi,'0',t2.validi,t2.nulli,t2.bianchi,t2.contestati, t4.id_circ,t2.id_sede,'0',t2.voti_nulli,t2.validi_lista,t2.voti_nulli_lista,t2.contestati_lista,t2.solo_gruppo FROM ".$prefix."_ele_sezioni as t2 left join ".$prefix."_ele_sede as t4 on (t2.id_sede=t4.id_sede) where t2.id_cons='$id_cons' and t2.validi+t2.nulli+t2.bianchi+t2.contestati>0 group by t2.id_sez order by t2.num_sez";

		}else{ // e' una lista uninominale o la seconda pagina
			$tab="SELECT '0',t1.id_sez,t1.num_sez,sum(t2.voti),t1.solo_gruppo,t1.validi,t1.nulli,t1.bianchi,t1.contestati, t4.id_circ,t1.id_sede,'0',t1.voti_nulli,t1.validi_lista,t1.voti_nulli_lista,t1.contestati_lista,t1.solo_gruppo
			FROM ".$prefix."_ele_sezioni as t1 left join ".$prefix.$tab3." as t2 on (t1.id_sez=t2.id_sez)
			left join ".$prefix."_ele_sede as t4 on (t1.id_sede=t4.id_sede)
			where t1.id_cons='$id_cons' and t1.id_cons=t2.id_cons group by t2.id_sez order by t1.num_sez";
		}
		$riga1="<tr><td>\n<table border=\"0\" width=\"100%\" bgcolor=\"$bgcolor1\" ><tr><td align=\"center\">"._SEZSCR." "._CONSULTAZIONE."</td></tr></table></td></tr>\n";
	}else{ // e' un referendum
		$tab="SELECT t1.id_gruppo,t1.id_sez,t2.num_sez,t1.si,t1.no,t1.validi,t1.nulli,t1.bianchi,t1.contestati, t4.id_circ,t2.id_sede,t3.num_gruppo,'0','0','0','0','0'
		FROM ".$prefix."_ele_voti_ref as t1 left join ".$prefix."_ele_sezioni as t2 on (t1.id_sez=t2.id_sez)
		left join  ".$prefix."_ele_gruppo as t3 on (t1.id_gruppo=t3.id_gruppo) left join ".$prefix."_ele_sede as t4 on (t2.id_sede=t4.id_sede)
		where t1.id_cons='$id_cons' and t1.id_gruppo='$idg' order by t2.num_sez";
		//$riga1= "<tr><td>\n<table border=\"0\" width=\"100%\" bgcolor=\"$bgcolor1\" ><tr><td align=\"center\">"._SEZSCR." "._CONSULTAZIONE." N. ".$numg."</td></tr></table></td></tr>\n";
		$riga1= "<tr><td>\n<table border=\"0\" width=\"100%\" bgcolor=\"$bgcolor1\" ><tr><td align=\"center\">"._SEZSCR." "._CONSULTAZIONE."</td></tr></table></td></tr>\n";
	}
	$res = mysql_query("$tab ", $dbi);
	$num_scr = mysql_num_rows($res);
	$riga2= "<tr><td>\n<table border=\"0\" width=\"100%\" bgcolor=\"$bgcolor1\" ><tr><td align=\"center\">"._SEZIONI." $num_scr "._SU." $num_sez</td></tr></table></td></tr>\n";//sezioni scrutinate
	$riga2 .= "<tr><td>\n<table border=\"0\" width=\"100%\"  align=\"center\">";
	$riga3 = "<tr bgcolor=\"$bgcolor2\" align=\"center\"><td width=\"5%\"><b>"._SEZIONI."</b></td>"
    ."<td><b>"._VOTIU."</b></td>"."<td><b>"._VOTID."</b></td>"."<td><b>"._VOTIE."</b></td>"; //testata con nomi dei campi
	if ($genere==0) {  //se e' un referendum
		$riga3 .= "<td><b>"._SI."</b></td><td><b>"._NO."</b></td>";
	} elseif ((($genere==5) or ($genere==3)) and $pag==1){
		$riga3 .= "<td><b>"._ASOLA_LISTA."</b></td>";
		if (!$votog) $riga3 .= "<td><b>"._ASOLO_GRUPPO."</b></td>";
	}
	$riga3 .= "<td><b>"._VALIDI."</b></td><td><b>"._NULLI."</b></td><td><b>"._BIANCHI."</b></td><td><b>"._CONTESTATI."</b></td>";
//	if (($genere==2 or $genere==3 or $genere==5) and !$votog)
//		$riga3 .= "<td><b>"._PREFGRU."</b></td>";
//	if ($genere>1 and !$votol)
//		$riga3 .= "<td><b>"._PREFLIS."</b></td>";
    	$riga3 .= "<td><b>"._STATO."</b></td></tr>\n";
	$res = mysql_query("$tab ", $dbi);//die($tab);
	$num_scr = mysql_num_rows($res);
	$righe= "";
	$scrutinate=1;
//	if ($genere>1 and $pag==1) $ops=3;
	$tot_u=0;$tot_d=0;$tot_voti=0; $tot_si=0;$tot_no=0;$tot_validi=0;$tot_nulli=0;$tot_bianchi=0;$tot_contestati=0;$tgrup_pref=0;$tot_voti_nulli=0;$tot_val_lista=0;$tot_vot_nul_lis=0;$tot_cont_lis=0;$tot_solog=0;$errors=0;
	while (list($id_gruppo,$id,$num,$si,$no,$validi,$nulli,$bianchi,$contestati,$id_circ,$id_sede,$gruppo,$voti_nulli,$val_lista,$vot_nul_lis,$cont_lis,$solog) = mysql_fetch_row($res)){
	// inserimento numeri di sez non scrutinate
		while ($scrutinate < $num) { 
			$righe.= "<tr align=\"center\"><td><a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_sez=".$sezione[$scrutinate]['id_sez']."&amp;id_circ=".$sezione[$scrutinate]['id_circ']."&amp;id_sede=".$sezione[$scrutinate]['id_sede']."&amp;do=spoglio&amp;ops=$ops\"><span style=\"color: rgb(255, 0, 0);\">$scrutinate</span></a></td></tr>\n";
			$scrutinate++;
		}
		$scrutinate++; 
	// fine inserimento	
		if (($genere==2 or $genere==3 or $genere==5) and !$votog) {
			$respref = mysql_query("select sum(voti) from ".$prefix."_ele_voti_gruppo where id_sez='$id'", $dbi);
			list ($gruppref) = mysql_fetch_row($respref); 
			$tgrup_pref += $gruppref;
		}
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
		$tot_voti_nulli+=$voti_nulli;
		$tot_val_lista+=$val_lista;
		$tot_vot_nul_lis+=$vot_nul_lis;
		$tot_cont_lis+=$cont_lis;
		$tot_solog+=$solog;
		$righe .= "<tr bgcolor=\"$bgcolor2\" align=\"center\"><td>$num</td><td>".number_format($votiu,0,',','.')."</td><td>".number_format($votid,0,',','.')."</td><td>".number_format($voti,0,',','.')."</td>";
		if ($genere==0 or ((($genere==5) or ($genere==3)) and $pag==1)){$righe .= "<td>".number_format($si,0,',','.')."</td>";}
		if ($genere==0 or ((($genere==5) or ($genere==3)) and $pag==1 and !$votog)){$righe .= "<td>".number_format($no,0,',','.')."</td>";}
		$righe .= "<td>".number_format($validi,0,',','.')."</td><td>$nulli</td><td>$bianchi</td><td>$contestati</td>";
		$g_err=0;
		if (($genere==2 or $genere==3 or $genere==5) and $pag==1 and !$votog) {
			if ($gruppref!=$validi) {
				$g_err=1;
				$ops=4;
			}
		}
		$controllo1=$validi+$nulli+$bianchi+$contestati+$voti_nulli; #prova
		$controllo2=$si+$no;
		if($genere==5) #$validi+$nulli+$bianchi+$vcont+$vn 
			if($pag==0 and !$votog or $fascia<=$limite) {$controllo1=$validi+$nulli+$bianchi+$contestati+$voti_nulli;} else { $controllo1=$val_lista+$nulli+$bianchi+$cont_lis+$vot_nul_lis+$solog;$controllo2=$si+$no-$voti_nulli-$contestati+$cont_lis+$vot_nul_lis;}
		if ($voti==$controllo1 and $validi==$controllo2 and !$g_err){
			$righe .= "<td>"._OK."</td></tr>\n";
		}else{
			$righe .= "<td><a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_sez=$id&amp;id_circ=$id_circ&amp;id_sede=$id_sede&amp;do=spoglio&amp;ops=$ops\"><span style=\"color: rgb(255, 0, 0);\">"._ERRORE."</span></a></td></tr>\n";$errors=1;
			if ($ops==4) $ops=3;
		}
	}
	if ($num<$num_sez) {
		for (;$scrutinate<=$num_sez;$scrutinate++) {
			$righe .= "<tr align=\"center\"><td><a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;id_sez=".$sezione[$scrutinate]['id_sez']."&amp;id_circ=".$sezione[$scrutinate]['id_circ']."&amp;id_sede=".$sezione[$scrutinate]['id_sede']."&amp;do=spoglio&amp;ops=$ops\"><span style=\"color: rgb(255, 0, 0);\">$scrutinate</span></td></tr>\n";
		}
	}
	if($num_scr){
	$righet = "<tr align=\"center\"><td><b>"._TOT."</b></td><td><b>".number_format($tot_u,0,',','.')."</b><br><i>(".number_format($tot_u*100/$totm,2)." %)</i></td><td><b>".number_format($tot_d,0,',','.')."</b><br><i>(".number_format($tot_d*100/$totf,2)." %)</i></td><td><b>".number_format($tot_voti,0,',','.')."</b><br><i>(".number_format($tot_voti*100/$totel,2)." %)</i></td>";
	// se e' un referendum o una consultazione con raggruppamenti
	if($tot_validi){
	if ($genere==0 or ((($genere==5) or ($genere==3)) and $pag==1)){$righet .= "<td><b>".number_format($tot_si,0,',','.')."</b><br><i>(".number_format($tot_si*100/$tot_validi,2)." %)</i></td>";}
	if ($genere==0 or ((($genere==5) or ($genere==3)) and $pag==1 and !$votog)){$righet .= "<td><b>".number_format($tot_no,0,',','.')."</b><br><i>(".number_format($tot_no*100/$tot_validi,2)." %)</i></td>";}
	$righet .= "<td><b>".number_format($tot_validi,0,',','.')."</b><br><i>(".number_format($tot_validi*100/$tot_voti,2)." %)</i></td><td><b>"
	.number_format($tot_nulli,0,',','.')."</b><br><i>(".number_format($tot_nulli*100/$tot_voti,2)." %)</i></td><td><b>".number_format($tot_bianchi,0,',','.')."</b><br><i>(".number_format($tot_bianchi*100/$tot_voti,2)." %)</i></td><td><b>".number_format($tot_contestati,0,',','.')."</b><br><i>(".number_format($tot_contestati*100/$tot_voti,2)." %)</i></td>";
	}else{
	if ($genere==0 or ((($genere==5) or ($genere==3)) and $pag==1)){$righet .= "<td><b>".number_format($tot_si,0,',','.')."</b><br><i>(0.00 %)</i></td>";}
	if ($genere==0 or ((($genere==5) or ($genere==3)) and $pag==1 and !$votog)){$righet .= "<td><b>".number_format($tot_no,0,',','.')."</b><br><i>(0.00 %)</i></td>";}
	$righet .= "<td><b>".number_format($tot_validi,0,',','.')."</b><br><i>(0.00 %)</i></td><td><b>"
	.number_format($tot_nulli,0,',','.')."</b><br><i>(".number_format($tot_nulli*100/$tot_voti,2)." %)</i></td><td><b>".number_format($tot_bianchi,0,',','.')."</b><br><i>(".number_format($tot_bianchi*100/$tot_voti,2)." %)</i></td><td><b>".number_format($tot_contestati,0,',','.')."</b><br><i>(".number_format($tot_contestati*100/$tot_voti,2)." %)</i></td>";
	}
	$g_err=0;
	if (($genere==2 or $genere==3 or $genere==5) and $pag==1 and !$votog) {
		if ($tgrup_pref!=$tot_validi) {
			$g_err=1;
		}
	}
#	if ($tot_voti==$tot_validi+$tot_nulli+$tot_bianchi+$tot_contestati and
#		$tot_validi==$tot_si+$tot_no and !$g_err) {
	if (! $errors) {
		$righet .= "<td>"._OK."</td></tr>\n";
	}else{
		$righet .= "<td><span style=\"color: rgb(255, 0, 0);\">"._ERRORE."</span></td></tr>\n";
	}
	}else $righet='';
	//$righe .= "</table></td></tr>\n";

	echo "$riga1";
	echo $riga2;
	echo $righet;
	echo $riga3;
	echo $righe;
	CloseTable();

    echo"<table align=\"center\" width=\"100%\" bgcolor=\"$bgcolor1\"><tr>\n";
    if($genere==0){ //se e' referendum
        #'Pagina precedente' e 'Pagina Successiva'
	    $cur=$num_ref;
        if ($cur>1) {
              $num_ref--;
			  echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=controllo_voti&amp;id_cons_gen=$id_cons_gen&amp;num_ref=$num_ref&amp;num_refs=$num_refs\">";
              echo "<b>"._PREV_MATCH."</b></a></td>";
        }
        if ($cur<$num_refs) {
	        $cur++;        
			echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=controllo_voti&amp;id_cons_gen=$id_cons_gen&amp;num_ref=$cur&amp;num_refs=$num_refs\">";
            echo "<b>"._NEXT_MATCH."</b></a></td>";
        }
    }elseif(($genere==5 and $fascia>=$limite) or ($genere==3) or ($genere==2) or $genere==1){ //se vi sono raggruppamenti
		$pag=($pag==0 ? 1:0);
		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=controllo_voti&amp;id_cons_gen=$id_cons_gen&amp;pag=$pag\"><b>";
        if($pag) echo _CONTR_PREF;
		else echo _CONTR_ESPR;
		echo "</b></a></td>";

	}/* elseif ($genere==1){
		$pag=($pag==0 ? 1:0);
		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=controllo_voti&amp;id_cons_gen=$id_cons_gen&amp;pag=$pag\"><b>";
        if($pag) echo _CONTR_GRUP;
		else echo _CONTR_ESPR;
		echo "</b></a></td>";
	}*/
	echo "</tr></table><br>\n";
echo "</table>\n</td></tr></table>\n";

   include ("footer.php");

?>
