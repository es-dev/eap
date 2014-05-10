<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo previsione seggi                                                       */
/* Amministrazione                                                     */
/************************************************************************/
if (!defined('MODULE_FILE')) {
    die ("You can't access this file directly...");
}
# controllo 
if ($hondt<=0){ Header("Location: index.php");
	die();
}

$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;

if (isset($param['gruppo'])) $gruppo=intval($param['gruppo']); else $gruppo='';
if (isset($param['numgruppo'])) $numgruppo=intval($param['numgruppo']); else $numgruppo='';
if (isset($param['listecol'])) $listecol=intval($param['listecol']); else $listecol=0;


$res = mysql_query("SELECT id_conf FROM ".$prefix."_ele_cons_comune where id_cons_gen='$id_cons_gen' and id_comune='$id_comune'" , $dbi);
list($id_conf) = mysql_fetch_row($res);
//test prima di modificare il db aggiungendo id_conf
//echo "$id_conf=2";
//

$res = mysql_query("SELECT limite,consin,infpremio,supsbarramento,suppremio,listinfsbar,listinfconta,listsupconta,supminpremio,infminpremio from ".$prefix."_ele_conf where id_conf='$id_conf'",$dbi);
list($limite,$consin,$infpremio,$supsbarramento,$suppremio,$listinfsbar,$listinfconta,$listsupconta,$supminpremio,$infminpremio) = mysql_fetch_row($res);


echo "<table><tr><td align=\"center\">"._PROIEZCONS."</td></tr></table>";


function consiglio(){
global $param,$id_cons_gen, $dbi, $prefix, $id_comune, $gruppo, $numgruppo, $listecol, $id_comune, $limite;
//$limite=3; //fascia di separazione del maggioritario (15.000 abitanti)
$collegate= array();
$collperd= array();
$x=1;
$primoturno=0;
while (isset($param['num_lista'.$x])) {
	if ($param['num_lista'.$x]==$gruppo) array_push($collegate,$_SESSION['num_lista'.$x]);
	elseif ($param['num_lista'.$x]!=0) array_push($collperd,$_SESSION['num_lista'.$x]);
	$x++;
}
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
if (mysql_num_rows($res)){
	list($tipo_cons,$id_cons) = mysql_fetch_row($res);
	$result = mysql_query("select fascia, capoluogo from ".$prefix."_ele_comuni where id_comune='$id_comune'", $dbi);
	list($fascia,$capoluogo) = mysql_fetch_row($result);
/*switch ($fascia) {
        case 1: $numcons=12; break;
        case 2: $numcons=16; break;
        case 3: $numcons=20; break;
        case 4: $numcons=20; break;
        case 5: $numcons=30; break;
        case 6: $numcons=40; break;
        case 7: $numcons=46; break;
        case 8: $numcons=50; break;
        case 9: $numcons=60; break;
} */
		$result = mysql_query("SELECT seggi from ".$prefix."_ele_fasce where id_fascia=$fascia",$dbi);
		list($numcons) = mysql_fetch_row($result);

$res_val= mysql_query("SELECT id_cand, sum(voti) from ".$prefix."_ele_voti_candidati where id_cons='$id_cons' group by id_cand",$dbi);
$num_cons= mysql_num_rows($res_val);
if ($num_cons<$numcons){
	echo "Il numero di candidati al consiglio inseriti con preferenza ($num_cons) e' inferiore al numero di seggi previsti ($numcons). Non e' possibile procedere con il calcolo";
	include("footer.php");
	die();
}
	if (!$gruppo){
		$res_val = mysql_query("SELECT sum(validi) from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi);
		list($validi) = mysql_fetch_row($res_val);
		$res_lis = mysql_query("SELECT t1.num_gruppo,sum(t2.voti) as voti from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_voti_gruppo as t2 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo group by t1.num_gruppo order by voti desc limit 0,2",$dbi);
		$test=0;$flag=0;
		while (list($num_gruppo,$voti)= mysql_fetch_row($res_lis)){
			if ($voti>($validi/2)) {$gruppo=$num_gruppo;$primoturno=1;}
			if ($voti==$test) $flag=1; else $test=$voti;
		}
	}
	if ($fascia<=$limite){
		$res_lis = mysql_query("SELECT t1.num_gruppo,sum(t2.voti) as voti from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_voti_gruppo as t2 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo group by t1.num_gruppo order by voti desc limit 0,2",$dbi);
		list($num_gruppo1,$voti1)= mysql_fetch_row($res_lis);
		list($num_gruppo2,$voti2)= mysql_fetch_row($res_lis);
		if ($voti1>$voti2)
			$numgruppo=$num_gruppo1;
	}
	if($fascia<6 and $capoluogo) $fascia=6;
	if ($fascia<=$limite and $numgruppo) consmin($fascia,$numgruppo);
	elseif ($gruppo>0) conssup($fascia,$gruppo,$collegate,$collperd,$primoturno);
	elseif ($numgruppo>0){
		$res_lis = mysql_query("SELECT t1.id_lista,t1.num_lista,t1.descrizione,t1.id_gruppo from ".$prefix."_ele_lista as t1, ".$prefix."_ele_gruppo as t2 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.num_gruppo not in (".$_SESSION['ballo1'].",".$_SESSION['ballo2'].")",$dbi);
		$yy=mysql_num_rows($res_lis);
			$res_voti = mysql_query("select sum(voti) from ".$prefix."_ele_voti_lista where id_cons='$id_cons'",$dbi);
			list($validilista) = mysql_fetch_row($res_voti);
		if ($yy){
while(list($id_lista,$num_lista,$descr,$pgrup) = mysql_fetch_row($res_lis)) {
			$res_voti = mysql_query("select sum(voti) from ".$prefix."_ele_voti_lista where id_lista='$id_lista'",$dbi);
			list($votilista) = mysql_fetch_row($res_voti);
			if(!isset($voti[$pgrup])) $voti[$pgrup]=0;
			$voti[$pgrup]+=$votilista;
}
			foreach ($voti as $key=>$val){if($val<($validilista*3/100)) unset($voti[$key]);} ##################################################
			mysql_data_seek($res_lis,0);
			echo "<br/>";
			echo "<form id=\"gruppo\" action=\"modules.php\">";
			echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"1\"><tr class=\"bggray\"><td colspan=\"4\">"._COLLEGAMENTI."</td></tr><tr class=\"bggray\"><td>";
			echo "<input type=\"hidden\" name=\"op\" value=\"consiglieri\"/>";
			echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\"/>";
			echo "<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\"/></td>";

echo "<td><b>".$_SESSION['grp1']."</b></td>";
			echo "<td><b>".$_SESSION['grp2']."</b></td>";
			echo "<td><b>"._NONCOLLE."</b></td></tr>";
			
			$z=1;
			while(list($id_lista,$num_lista,$descr,$pgrup) = mysql_fetch_row($res_lis)) {
				if(!isset($voti[$pgrup])) continue;
 				$x=$_SESSION['ballo1'];
				echo "<tr><td>$descr</td><td><input type=\"radio\" name=\"num_lista$z\" value=\"$x\"/></td>";
				$x=$_SESSION['ballo2'];
				$_SESSION['num_lista'.$z]=$num_lista;
				echo "<td><input type=\"radio\" name=\"num_lista$z\" value=\"$x\"/></td>";
				echo "<td><input type=\"radio\" name=\"num_lista$z\" value=\"0\" checked=\"checked\"/></td></tr>";
				$z++;		
			}

			echo "<tr><td colspan=\"4\"><input type=\"hidden\" name=\"listecol\" value=\"$x\"/><input type=\"hidden\" name=\"gruppo\" value=\"$numgruppo\"/>";
			echo "<input type=\"submit\" name=\"invia\" value=\""._OK."\"/></td></tr></table></form>";
		}else conssup($fascia,$numgruppo,$collegate,$collperd,$primoturno);
	}else {
		echo "<br/>";
		echo "<form id=\"numgruppo\" action=\"modules.php\">";
		echo "<table><tr class=\"bggray\"><td>"._SCELTASIN.":</td><td align=\"left\">";
		echo "<input type=\"hidden\" name=\"op\" value=\"consiglieri\"/>";
		echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\"/>";
		echo "<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\"/>";
		$res = mysql_query("SELECT t1.id_gruppo,t1.num_gruppo,t1.descrizione, sum(t2.voti) as pref FROM ".$prefix."_ele_gruppo as t1, ".$prefix."_ele_voti_gruppo as t2 where t1.id_gruppo=t2.id_gruppo and t1.id_cons='$id_cons' group by t1.num_gruppo,t1.descrizione order by pref desc limit 0,2", $dbi);
		while(list($id_gruppo,$num_gruppo, $descr_gruppo,$pref) = mysql_fetch_row($res)) {
			if (!isset($_SESSION['ballo1'])) {
				$_SESSION['ballo1']=$num_gruppo;
				$_SESSION['grp1']=$descr_gruppo;
				$_SESSION['idgrp1']=$id_gruppo;
			}else{
				$_SESSION['ballo2']=$num_gruppo;
				$_SESSION['grp2']=$descr_gruppo;
				$_SESSION['idgrp2']=$id_gruppo;
			}
			echo "<input type=\"radio\" name=\"numgruppo\" value=\"$num_gruppo\"/>$descr_gruppo<br/>";
		}
		echo "</td>";
		echo "<td><input type=\"submit\" name=\"invia\" value=\""._OK."\"/></td></tr></table></form>";
	
		}
	}
}

function consmin($fascia,$grp) {
global $id_cons, $prefix,$dbi,$num_candlst,$quozienti,$PNE,$CSEC,$consin;
global $infpremio;
$PNE=_PRIMONON;
$CSEC=_SINDCONS;
$sorteggio=0;
$num_candlst=array();
#funzione di calcolo per comuni fino a 15.000 abitanti (pi� esattamente fino al valore di $limite)
#carica il numero di consiglieri per la minoranza
		$result = mysql_query("SELECT seggi from ".$prefix."_ele_fasce where id_fascia=$fascia",$dbi);
		list($numcons) = mysql_fetch_row($result);

$consel=array();
$conselcsne=array();
$conselmin=array();
//$consel[]=array("Lista","Voti","Seggi","Nominativo","Cifra Elettorale","Quoziente");
$consel[]=array(_LISTA,_VOTI,_SEGGI,_CANDIDATO,_CIFRAELE,_QUOZIENTI);
#carica numero di liste e voti, i voti sono quelli del gruppo perche' non c'e' voto di lista
$res_val = mysql_query("SELECT sum(validi) from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi);
list($validi) = mysql_fetch_row($res_val);
$res_per = mysql_query("SELECT t1.descrizione,t1.num_gruppo,t2.id_lista,t2.num_lista,t2.descrizione,sum(t3.voti) as voti from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_gruppo as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t1.id_gruppo=t3.id_gruppo group by t1.descrizione,t1.num_gruppo,t2.num_lista,t2.descrizione order by voti desc ",$dbi);
$groups=array();
$seggimag=array();
$premio=0;
$x=0;
#carica l'array dei gruppi e della cifra di gruppo
while (list($descr,$num_gruppo,$id_lista,$num_lista,$descr_lista,$voti)= mysql_fetch_row($res_per)){
    $desgruppi[$num_gruppo]=$descr;
    $desliste[$num_lista]=$num_lista.") ".$descr_lista;
    $idlst[$num_lista]=$id_lista;
    $listagruppo[$num_lista]=$num_gruppo;
    $lists[$num_lista]=$voti;
    if ($grp){
		if ($grp!=$num_gruppo) {$groups[($num_gruppo)]=$voti;$listemin[$num_lista]=$voti;}
		else {$gruppo[($num_gruppo)]=$voti;$listemag[$num_lista]=$voti;$lisvin=$num_lista;}
    }else{
    	if ($x) {$groups[($num_gruppo)]=$voti;$listemin[$num_lista]=$voti;}
    	else {$gruppo[($num_gruppo)]=$voti;$listemag[$num_lista]=$voti;$lisvin=$num_lista;}
    }
    $x++;
    }#controllo del premio di maggioranza
//    if ($gruppo[$listagruppo[$lisvin]]>($validi*2/3)) 
    if ($gruppo[$listagruppo[$lisvin]]>($validi*$infpremio/100)) 
    {
    	foreach ($groups as $key=>$val) $gruppo[$key]=$val;
    	$groups=$gruppo; 
    	$gruppo=array();
    	$num_cons=$numcons;
    } else {   
//    	$seggimag[$lisvin]=number_format($numcons*2/3);
//    	$num_cons=number_format($numcons/3);
    	$seggimag[$lisvin]=number_format($numcons*$infpremio/100);
    	$num_cons=number_format($numcons-$seggimag[$lisvin]);
    }
    foreach ($listagruppo as $lista=>$val){
    $id_lista=$idlst[$lista];
    $res_can = mysql_query("SELECT concat(substring(concat('0',t1.num_cand),-2),') ',t1.cognome,' ',substring(t1.nome from 1 for 1),'.') as descr,sum(t2.voti) as voti from ".$prefix."_ele_candidati as t1, ".$prefix."_ele_voti_candidati as t2 where t1.id_lista='$id_lista' and t1.id_cand=t2.id_cand GROUP BY descr order by voti desc,t1.num_cand",$dbi);
    
    $num_candlst[$lista]=mysql_num_rows($res_can);
    $pos=0;
    while(list($cand,$pre)=mysql_fetch_row($res_can)){
    	if(!isset($lists[$lista])) $lists[$lista]=0;
    	$cifra[$lista][$pos]=$lists[$lista]+$pre;
    	$arvin[$lista][$pos++]=$cand;
    }	    
    }
    if ($num_candlst[$lisvin]<$seggimag[$lisvin]) {
    	$num_cons+=$seggimag[$lisvin]-$num_candlst[$lisvin];
    	$seggimag[$lisvin]=$num_candlst[$lisvin];
    }
    if (isset($gruppo[$listagruppo[$lisvin]])) $seggimag=calcoloseggi($listemag,$seggimag[$lisvin],1);
   if(isset($mex)) 
    echo "$mex";
	foreach ($seggimag as $lista=>$val)
      	for ($z=0;$z<$val;$z++){
				if ($z) $consel[]=array("","","",$arvin[$lista][($z)],$cifra[$lista][($z)],number_format($quozienti[$lista][$z],2));
				else $consel[]=array($desliste[$lista],$lists[$lista],$val,$arvin[$lista][($z)],$cifra[$lista][($z)],number_format($quozienti[$lista][$z],2));
    		}
    		if($arvin[$lista][($z)]) $consel[]=array($desliste[$lista],"$PNE","",$arvin[$lista][($z)],$cifra[$lista][($z)],number_format($quozienti[$lista][$z],2));
    $seggimin=array();
    $seggimin=calcoloseggi($listemin,$num_cons,1);
    foreach ($seggimin as $lista=>$val){
    	if ($consin and $val>0){
    		$conselcsne[]=array("$CSEC","","",$desgruppi[$listagruppo[$lista]],"","");
    		$val--;
    	}
      for ($z=0;$z<$val;$z++){
        	if ($z) $conselmin[]=array("","","",$arvin[$lista][($z)],$cifra[$lista][($z)],number_format($quozienti[$lista][$z],2));
        	else $conselmin[]=array($desliste[$lista],$lists[$lista],$val,$arvin[$lista][($z)],$cifra[$lista][($z)],number_format($quozienti[$lista][$z],2));
		}
		if($arvin[$lista][($z)]) $conselmin[]=array($desliste[$lista],"$PNE","",$arvin[$lista][($z)],$cifra[$lista][($z)],number_format($quozienti[$lista][$z],2));
    }
	foreach($conselcsne as $key=>$val) 
	{
		$consel[]=array($val[0],$val[3]);
	}
	foreach($conselmin as $key=>$val) 
	{
		$consel[]=array($val[0],$val[1],$val[2],$val[3],$val[4],$val[5]);
	}
        
    
    
    echo "<table summary=\"Tabella dei consiglieri eletti\" class=\"table-docs\" cellspacing=\"0\" cellpadding=\"2\" border=\"1\" rules=\"all\">";
    echo "<tr class=\"bggray\"><td scope=\"row\">";
    echo _SINDACO.": ".$desgruppi[$listagruppo[$lisvin]]."</td></tr></table>";
    stampalista($consel);


}



function calcoloseggi($gruppi,$num_cons,$flag){
global $ultimo,$mex,$sorteggio,$quozienti,$num_cand,$num_candlst;

#carica le preferenze
$pref = array();
$ultimo=0;
$mex='';
$sorteggio=0;
$eletti = array();
$ele = array();
$quozienti = array();
$num_quoz= $num_cons;
#inizializza l'array degli eletti
foreach ($gruppi as $x=>$val){
 $eletti[$x]=0;
 }
#carica gli array dei quozienti
foreach($gruppi as $y=>$tmp){
	if($flag) $num_quoz= $num_cons<$num_candlst[$y] ? $num_cons:$num_candlst[$y];
	if(!isset($ele[$y][0])) $ele[$y][0]=0;
	for ($x=0;$x<=$num_quoz;$x++){
		$ele[$y][$x]= $tmp/($x+1);
		$quozienti[$y][$x]= $tmp/($x+1);
	}
}
#estrae i quozienti piu' alti
for ($y=0;$y<$num_cons;$y++){
 $temp=0;
 $cand=0;
 if(! isset($pref['0'])) $pref['0']='';
 if(! isset($pref['1'])) $pref['1']='';
 foreach($gruppi as $x=>$tmp){
	if(!isset($ele[$x][0])) $ele[$x][0]=0;
	if(!isset($pref[$x])) $pref[$x]=0;
   if ($ele[$x][0]==$temp and $pref[$x]==$pref[$cand] and ($y+1)==$num_cons) {$sorteggio=1; $mex="Per attribuire l'ultimo seggio � necessario un sorteggio tra la lista n. ".($x+1)." e la lista n. ".($cand+1);}
  if ($ele[$x][0]>$temp or ($ele[$x][0]==$temp and $pref[$x]>$pref[$cand])) {
   $temp=$ele[$x][0];
   $cand=$x;
   $sorteggio=0;$mex='';
  }
 }
 if (!$sorteggio){
 	$eletti[$cand]++;
 	$ultimo=$cand;
 	array_shift($ele[$cand]);
 }
}
return ($eletti);
}

function stampalista($ar) {
global $PNE,$CSEC;
$cmin=_SEGGIMIN;	
$csin="";	
	$bg='bgw';
	
	$tmpbg='bggray2'; 
	$tmpbg1='bgw';
	$tmpbg2='bggray';
	$tmpbg3='bggray2';
   $fmin=2;
	echo "<table summary=\"Tabella dei consiglieri eletti\" class=\"table-docs\" cellspacing=\"0\" cellpadding=\"2\" border=\"1\" rules=\"all\">";
		$y=1;$i='';$e=0;
		foreach ($ar as $riga) {
			$e++;
			if($riga[0]==$CSEC and $fmin==2)
			{
			{	$fmin=1;		
				echo "</table>";
				echo "<table summary=\"Tabella dei candidati sindaco eletti consigliere\" class=\"table-docs\" cellspacing=\"0\" cellpadding=\"2\" border=\"1\" rules=\"all\">";
				echo "<tr class=\"bggray\"><td scope=\"row\" colspan=\"3\"><b>";
				echo $csin;
				echo "</b></td></tr>";	
				echo "<tr class=\"bggray\"><td scope=\"row\"><b>"._CANDIDATO."</b></td><td scope=\"row\"><b>"._NOMINATIVO."</b></td></tr>";
			}
			}
			if($riga[0]!=$CSEC and $fmin==1)
			{	$fmin=0;		
				echo "</table>";
				echo "<table summary=\"Tabella dei consiglieri di minoranza\" class=\"table-docs\" cellspacing=\"0\" cellpadding=\"2\" border=\"1\" rules=\"all\">";
				echo "<tr class=\"bggray\"><td scope=\"row\" colspan=\"6\"><b>";
				echo $cmin;
				echo "</b></td></tr>";	
				echo "<tr class=\"bggray\"><td scope=\"row\"><b>"._LISTA."</b></td><td scope=\"row\"><b>"._VOTI."</b></td><td scope=\"row\"><b>"._SEGGI."</b></td><td scope=\"row\"><b>"._NOMINATIVO."</b></td><td scope=\"row\"><b>"._CIFRAELE."</b></td><td scope=\"row\"><b>"._QUOZIENTI."</b></td></tr>";
			}
			if($riga[1]==$PNE) echo "<tr class=\"red\">";
			else{
				$bg= ($riga[1]) ? $tmpbg3:$tmpbg1;
				if($y) {
					echo "<tr class=\"bggray\">";
				}else{
					echo "<tr class=\"$bg\">";
				}
			}
			foreach ($riga as $cella) {
			 if ($e==1){ 
				$t="<th scope=\"colgroup\"";$f="</th>";
			}else{ 
				$t="<td scope=\"row\"";$f="</td>";	
			}					
				echo "$t $i align=\"left\">$cella $f";
					$i='';
				
			}
			if ($y) $y=0;
			echo "</tr>";
		}
		echo "</table>";

}

function conssup($fascia,$gruppo,$collegate,$collperd,$primoturno) {
global $id_cons, $id_cons_gen, $id_comune, $prefix,$dbi;
global $groups,$lists,$eletti,$ultimo,$quozienti,$num_candlst,$mex,$PNE,$CSEC,$consin;
global $supsbarramento, $supminpremio, $suppremio;
global $listsupconta;
#funzione di calcolo per comuni oltre 15.000 abitanti
#carica il numero di consiglieri da eleggere$groups=array();
$PNE=_PRIMONON;
$CSEC=_SINDCONS;
$lists=array();
$eletti=array();
$num_candlst=array();
#$quozienti = array();
$oldlists=array();
$oldlstgrp=array();
$premio=0;
/* "Ai fini della determinazione nel secondo turno, della cifra elettorale complessiva delle liste collegate deve tenersi conto anche del collegamento intervenuto in vista del ballottaggio" (Cons. St. Sez. V 4 maggio 2001 n. 2519; 20 settembre 2000 n. 4894; 19 marzo 1996 n. 290)   




switch ($fascia) {
	case 1: $numcons=12; break; 
	case 2: $numcons=16; break; 
	case 3: $numcons=20; break; 
	case 4: $numcons=20; break; 
	case 5: $numcons=30; break; 
	case 6: $numcons=40; break; 
	case 7: $numcons=46; break; 
	case 8: $numcons=50; break; 
	case 9: $numcons=60; break; 
} */
		$result = mysql_query("SELECT seggi from ".$prefix."_ele_fasce where id_fascia=$fascia",$dbi);
		list($numcons) = mysql_fetch_row($result);

#verificare come gestire la situazione in cui il candidato sindaco supera lo sbarramento e il totale delle liste no.
if (!isset($_SESSION['ballo1'])) $_SESSION['ballo1']='';
if (!isset($_SESSION['ballo2'])) $_SESSION['ballo2']='';
$gruppoperd= ($gruppo==$_SESSION['ballo1']) ? $_SESSION['ballo2'] : $_SESSION['ballo1'];

#$res_val = mysql_query("SELECT sum(validi_lista) from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi); 
$res_val = mysql_query("SELECT sum(voti) from ".$prefix."_ele_voti_lista where id_cons='$id_cons'",$dbi); 
list($validi) = mysql_fetch_row($res_val);

$sbarra=($validi*$supsbarramento)/100; 
$res_per = mysql_query("SELECT t1.descrizione,t1.num_gruppo,t2.id_lista,t2.num_lista,t2.descrizione,sum(t3.voti) as voti from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista group by t1.descrizione,t1.num_gruppo,t2.num_lista,t2.descrizione order by voti desc",$dbi);
$groups=array();
$premio=0;
//10-05-2009 gestione differenziata delle norme elettorali
#carica l'array dei gruppi e della cifra di gruppo
while (list($descr,$num_gruppo,$id_lista,$num_lista,$descr_lista,$voti)= mysql_fetch_row($res_per)){
 if ($listsupconta or $voti>=$sbarra){
    if (! isset($groups[($num_gruppo)])) $groups[($num_gruppo)]=0;
    $desgruppi[$num_gruppo]=$descr;
    $desliste[$num_lista]=$num_lista.") ".$descr_lista;
    $idlst[$num_lista]=$id_lista;
    $listagruppo[$num_lista]=$num_gruppo;
    $lists[$num_lista]=$voti;
    $groups[($num_gruppo)]+=$voti;
  }else $validi-=$voti;
}    
$descrsind=$desgruppi[$gruppo];
foreach ($groups as $key=>$val){
       #controlla se un gruppo di liste, tra quelle perdenti, ha superato il 50%
    if ($key!=$gruppo and $val> $validi/2) $premio=2;
    #elimina gruppi che non hanno superato lo sbarramento
    if ($val<$sbarra){
    	foreach ($listagruppo as $lst=>$grp)
    		if ($grp==$key){
    			unset($listagruppo[$lst]);
    			unset($desliste[$lst]);
    			unset($lists[$lst]);
    		}    	
    	unset($groups[($key)]);
    	unset($desgruppi[($key)]);

    }
}

    foreach ($collegate as $lst) 
    	if (isset($lists[$lst])){
    		 if($premio){
    		 	$oldlstgrp[$lst]=$listagruppo[$lst];
    		 	$oldlists[$lst]=$lists[$lst];
    		 }
    		 $groups[$listagruppo[$lst]]-=$lists[$lst];
    		 $listagruppo[$lst]=$gruppo;
    		 $groups[$gruppo]+=$lists[$lst];
    	}
 ////da qui    	

    foreach ($collperd as $lst) 
    	if (isset($lists[$lst])){
    		$oldlstgrp[$lst]=$listagruppo[$lst];
    		 $listagruppo[$lst]=$gruppoperd;
    		 $oldlists[$lst]=$lists[$lst];
    		 $groups[$gruppoperd]+=$lists[$lst];
    		 $groups[$oldlstgrp[$lst]]-=$lists[$lst];
    	}   

////a qui va tolto se non vanno sommati i voti delle liste collegate al secondo turno con quelli del gruppo che perde il ballottaggio, se non si collegano viene favorita l'elezione del candidato sindaco con cui era collegata al primo turno mentre se si collegano viene favorito il principio di aggregazione. Per ora i perdenti sono considerati con la situazione al primo turno. Implementiamo cos�: il 50% deve essere superato dalla minoranza nel primo turno, quindo senza somma dei voti delle liste aggiunte nel secondo turno - la suddivisione dei seggi viene fatta considerando i collegamenti al secondo turno, le liste collegate partecipano alla suddivisione dei seggi con questo gruppo quindi si confronta con le liste del gruppo in cui era al primo turno e valutando i coefficienti si stabilisce quale lista cede il seggio al candidato sindaco non acceduto al ballottaggio.

#controlla se la percentuale del gruppo vincente e' tra il 40 e il 60% o il sindaco e' eletto al secondo turno
#e se nessun altro gruppo ha superato il 50% assegna il premio di maggioranza
#e se nessun altro gruppo ha superato il 50% e nessuno ha ottenuto piu' del 60% dei seggi, assegna il premio di maggioranza

$consmin=$numcons;
$gruppomin=calcoloseggi($groups,$consmin,0);
$nopremio=1;
foreach ($gruppomin as $key=>$val) {if (($numcons*60/100)<$val) $nopremio=0;}
#die("qui:".($numcons*60/100)."<$val");
if (($groups[$gruppo]>=(($validi*$supminpremio)/100) or ! $primoturno) and $groups[$gruppo]<(($validi*$suppremio)/100) and !$premio and $nopremio) $premio=1;
else $premio=0;
	$consel=array();
	$consel[]=array(_LISTA,_VOTI,_SEGGI,_CANDIDATO,_CIFRAELE,_QUOZIENTI);

$candidati=array();
if ($premio) {
    $sindaco[$gruppo]=$groups[$gruppo]; $groups[$gruppo]=0;
    $gruppomag=calcoloseggi($sindaco,number_format($numcons*$suppremio/100),0);
#######calcola i seggi per lista
foreach ($gruppomag as $key=>$val){
	foreach($listagruppo as $lst=>$grp){
		if($grp!=$key) continue;
		$id_lista=$idlst[$lst];
		$x=$lst;
		$y=$lists[$x];
		$pos=0;
		$z=0;
		$arvin[$x][$pos++]=$desliste[$lst]; 
		$res_can = mysql_query("SELECT concat(substring(concat('0',t1.num_cand),-2),') ',t1.cognome,' ',substring(t1.nome from 1 for 1),'.') as descr,sum(t2.voti) as voti from ".$prefix."_ele_candidati as t1, ".$prefix."_ele_voti_candidati as t2 where t1.id_lista='$id_lista' and t1.id_cand=t2.id_cand GROUP BY descr order by voti desc,num_cand",$dbi);
		$num_candlst[$x]=mysql_num_rows($res_can);
		while(list($cand,$pre)=mysql_fetch_row($res_can)){ 
			$cifra[$x][$pos]=$y+$pre;
			$arvin[$x][$pos++]=$cand;
		}	
		$listemag[$x]=$y;
		$desliste[$x]=$descr;
		$percliste[$x]="<br/>$y (".number_format($y*100/$validi,2)."%)";
		$z++;
	}
#foreach ($groups as $key=>$val)echo "           key: $key : val : $val<br/>";
	$seggimag=array();
	$seggimag=calcoloseggi($listemag,$val,1);
	$x=0;
	foreach ($seggimag as $key=>$val){
		for ($z=0;$z<$val;$z++){
			if ($z) $consel[]=array("","","",$arvin[$key][($z+1)],$cifra[$key][($z+1)],number_format($quozienti[$key][$z],2));
			else
			{
			$consel[]=array($arvin[$key][0],$percliste[$key],$val,$arvin[$key][($z+1)],$cifra[$key][($z+1)],number_format($quozienti[$key][$z],2));
			$arlisdesv[]=$arvin[$key][0];$arlissegv[]=$val;$arlisnumv[]=$key;
			}
		}
	$x++;
	if($val)
	$consel[]=array($arvin[$key][0],"$PNE","",$arvin[$key][($z+1)],$cifra[$key][($z+1)],number_format($quozienti[$key][$z],2));
	}
}
}
if ($premio) $consmin=number_format($numcons*(100-$suppremio)/100);
else $consmin=$numcons;
#foreach($groups as $keyb=>$valb) echo "keyb:$keyb -- valb:$valb<br/>";

#####calcolo per la minoranza o in caso non ci sia premio di maggioranza   
$gruppomin=calcoloseggi($groups,$consmin,0);
$ordinati[$gruppo]=$gruppomin[$gruppo];
foreach ($gruppomin as $key=>$val){
	if($key!=$gruppo) $ordinati[$key]=$val;
}
$gruppomin=$ordinati;
foreach ($gruppomin as $key=>$val){
		if($premio and $key==$gruppo) continue;
	$listemin=array();
	$cifra=array();
	foreach($listagruppo as $lst=>$grp){
		if($grp!=$key) continue;
		
		$id_lista=$idlst[$lst];
		$x=$lst;
		$y=$lists[$x];
		$pos=0;
		$z=0;
		$pos=0;$z=0;
		if(!$premio and $key==$gruppo) $arvin[$x][$pos++]=$desliste[$lst];
		else $arper[$x][$pos++]=$desliste[$lst]; 
		$res_can = mysql_query("SELECT concat(substring(concat('0',t1.num_cand),-2),') ',t1.cognome,' ',substring(t1.nome from 1 for 1),'.') as descr,sum(t2.voti) as voti from ".$prefix."_ele_candidati as t1, ".$prefix."_ele_voti_candidati as t2 where t1.id_lista='$id_lista' and t1.id_cand=t2.id_cand GROUP BY descr order by voti desc,num_cand",$dbi);
		$num_candlst[$x]=mysql_num_rows($res_can);
		while(list($cand,$pre)=mysql_fetch_row($res_can)) {
			$cifra[$x][$pos]=$y+$pre;
			if(!$premio and $key==$gruppo)
			$arvin[$x][$pos++]=$cand;
			else
			$arper[$x][$pos++]=$cand;
		}
		$listemin[$x]=$y;
		$desliste[$x]=$descr;
		$percliste[$x]="<br/>$y (".number_format($y*100/$validi,2)."%)";
	}
	$seggimin=array();
	echo "$mex";
	$ultimo='';
	$seggimin=calcoloseggi($listemin,$val,1);
	echo "$mex";#foreach ($seggimin as $lista=>$valc) echo $seggimin[$lista]." key:$lista -val:$valc<br/>";
	if(!$premio and $key==$gruppo)
		foreach ($seggimin as $lista=>$valc) $arper[$lista]=$arvin[$lista];
/*		for ($z=0;$z<$valc;$z++){
			if ($z) $consel[]=array("","","",$arvin[$lista][($z+1)],$cifra[$lista][($z+1)],$quozienti[$lista][$z]);
			else $consel[]=array($arvin[$lista][0],$percliste[$lista],$valc,$arvin[$lista][($z+1)],$cifra[$lista][($z+1)],$quozienti[$lista][$z]);
		}
	}
		$consel[]=array($arvin[$lista][0],"$PNE","",$arvin[$lista][($z+1)],$cifra[$lista][($z+1)],$quozienti[$lista][$z]);
	}//else{ 
*/

	if ($val and $key!=$gruppo and $consin) {$conselsin[]=array("$CSEC",$desgruppi[$key]); $arcansin[]=$desgruppi[$key];}
foreach ($seggimin as $lista=>$val)
	if(isset($oldlstgrp[$lista]) and !isset($oldseggi[$lista])) {$oldseggi[$lista]=$val;}
		if($val==0){
		if($ultimo==''){
			foreach($oldlists as $lst=>$vot)
			{		
				if ($oldlstgrp[$lst]!= $key or $oldseggi[$lst]==0) continue;
				if($ultimo=='') $ultimo=$lst;	
				if($quozienti[$ultimo][($val-1)]==$last[$lst]) 
				{
						if($lists[$ultimo]==$lists[$lst]) $mex="Per attribuire l'ultimo seggio � necessario un sorteggio tra la lista n. $ultimo e la lista n. $lst";
	 					elseif($lists[$ultimo]>$lists[$lst]) {$ultimo=$lst;$mex="";}
	 			}
	 			if ($quozienti[$lista][($val-1)]> $last[$lst]) {$ultimo=$lst;$mex="";}
			}$lst=$ultimo;
		if($ultimo and $consin){
#			if($conselb[$ttl[($lst-1)]][2]>1) $conselb[$ttl[($lst-1)]][2]--;else $conselb[$ttl[($lst-1)]][2]='';
#			$daunset[]=$tt[($lst-1)];
			if($conselb[$ttl[($lst)]][2]>1) $conselb[$ttl[($lst)]][2]--;else $conselb[$ttl[($lst)]][2]='';
			$daunset[]=$tt[($lst)];
			$conselsin[]=array("$CSEC",$desgruppi[$key]);
			$arcansin[]=$desgruppi[$key];
			}
		}
	}
#if($key!=$gruppo){
	foreach ($seggimin as $lista=>$val){
		if($ultimo==$lista and $key!=$gruppo and $consin) $val--; 


		for ($z=0;$z<$val;$z++){
			if ($z) $conselb[]=array("","","",$arper[$lista][($z+1)],$cifra[$lista][($z+1)],number_format($quozienti[$lista][$z],2));
			else{
			if(!isset($arper[$lista][($z+1)])) $arper[$lista][($z+1)]=0;
			if(!isset($cifra[$lista][($z+1)])) $cifra[$lista][($z+1)]=0;
			$conselb[]=array($arper[$lista][0],$percliste[$lista],$val,$arper[$lista][($z+1)],$cifra[$lista][($z+1)],number_format($quozienti[$lista][$z],2));
			$ttl[$lista]=(count($conselb)-1);
			}
		}
	if (isset($oldlists[$lista]))
	{
		$tt[$lista]=(count($conselb)-1);
		$last[$lista]=$quozienti[$lista][($z-1)];
		
	} 
	if($val){
		if(!isset($arper[$lista][($z+1)])) $arper[$lista][($z+1)]=0;
		if(!isset($cifra[$lista][($z+1)])) $cifra[$lista][($z+1)]=0;
		if(!isset($quozienti[$lista][$z])) $quozienti[$lista][$z]=0;
		$conselb[]=array($arper[$lista][0],"$PNE","",$arper[$lista][($z+1)],$cifra[$lista][($z+1)],number_format($quozienti[$lista][$z],2)); 
		}
	}
#	}//chiude if $key 
	}//chiude foreach gruppomin
#	}
	echo "<table summary=\"Tabella dei consiglieri eletti\" class=\"table-docs\" cellspacing=\"0\" cellpadding=\"2\" border=\"1\" rules=\"all\">";
	echo "<tr class=\"bggray\"><td scope=\"row\"><b>";
	echo _SINDACO.": ".$desgruppi[$gruppo]."</b></td></tr></table>";
	if(isset($daunset)){
	if ((sort($daunset,SORT_NUMERIC))==false) echo "Errore di programma!";
	ELSE { 
		$tmpda=array_reverse($daunset); 
		foreach($tmpda as $key=>$val) {
			$conselb[$val][0]=$conselb[($val+1)][0];$conselb[$val][1]=$conselb[($val+1)][1];
			unset($conselb[($val+1)]);
			}
		}
	}#foreach($conselb as $key=>$val) if($val[2]) echo "$x) ".$val[0]."--".$val[2]."<br/>"; else echo "passa".$x++;
	if (!$premio)
	{
		foreach($conselb as $key=>$val) 
		{
			if ($val[2]){
				$nlst=intval($val[0]);
				$arlisdesv[]=$val[0];
				$arlissegv[]=$val[2];
			}
			if($listagruppo[$nlst]!=$gruppo) continue;
			$consel[]=array($val[0],$val[1],$val[2],$val[3],$val[4],$val[5]);
		}
	}
	
	if (isset($conselsin)) foreach($conselsin as $key=>$val) 
	{
		$consel[]=array($val[0],$val[1]);
	}
	foreach($conselb as $key=>$val) 
	{
		if ($val[2]){
			$nlst=intval($val[0]);
			$arlisdesp[]=$val[0];
			$arlissegp[]=$val[2];
		}
		if($listagruppo[$nlst]==$gruppo) continue;
		$consel[]=array($val[0],$val[1],$val[2],$val[3],$val[4],$val[5]);
	}
//	plotgraf($descrsind,$arlisdesv,$arlissegv,$arlisdesp,$arlissegp,$arcansin); // per grafico
	stampalista($consel);
	unset($_SESSION['ballo1']);unset($_SESSION['ballo2']);unset($_SESSION['grp1']);unset($_SESSION['grp2']);
}
// Grafico
function plotgraf($descrsind,$arlisdes,$arlisseg,$arlisdesp,$arlissegp,$arcansin){
	//echo "sindaco: $descrsind<br/>";
/*	foreach($arlisdes as $key=>$val){
		echo "key:$key -- val:$val seggi:".$arlisseg[$key]."<br/>";
	}	
	echo "<br/><br/>";
	foreach($arlisdesp as $key=>$val){
		echo "key:$key -- val:$val seggi:".$arlissegp[$key]."<br/>";
	}	*/
	foreach($arlisdes as $key=>$val){
		if($arlisseg[$key]=='1') $vocale="o"; else $vocale='';

	$lista[]="$val \n [  ".$arlisseg[$key]." seggi".$vocale."  ]";  
	$seggin[]=$arlisseg[$key]." seggi".$vocale."";
	//echo "La lista $val ottiene ".$arlisseg[$key]." seggi.<br/>";
	}
	foreach($arcansin as $val) {
	$seggin[]="1 seggio";
	$arlisseg[]=1;
	$lista[]=$val ."\n [ 1 seggio ]" ;
    //echo "Il candidato sindaco $val e' eletto consigliere.<br/>";
}
$sindaco=urlencode($descrsind);

$seggi=serialize($arlisseg);
$seggi=urlencode($seggi);
$seggin=serialize($seggin);
$seggin=urlencode($seggin);
$lista=serialize($lista);
$lista=urlencode($lista);
$title="Proiezione Composizione Consiglio Comunale";
echo "<table><tr><td>
		<img src='modules/Elezioni/grafici/consiglio.php?title=$title&amp;seggi=$seggi&amp;seggin=$seggin&amp;lista=$lista&amp;sindaco=$sindaco'  alt=\"Grafico\" /></td></tr></table>";



}
?>
