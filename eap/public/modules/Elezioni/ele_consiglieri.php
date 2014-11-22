<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo eletti                                                       */
/* Amministrazione                                                     */
/************************************************************************/
if (!defined('MODULE_FILE')) {
    die ("You can't access this file directly...");
}
//$limite=5; //fascia di separazione del maggioritario
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=intval($param['id_cons_gen']);
$perms=ChiSei($id_cons_gen);
if ($perms<32 or !$id_cons_gen) die("$id_cons_gen -Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
include("modules/Elezioni/ele.php");
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
if (isset($param['gruppo'])) $gruppo=intval($param['gruppo']); else $gruppo='';
if (isset($param['numgruppo'])) $numgruppo=intval($param['numgruppo']); else $numgruppo='';
if (isset($param['listecol'])) $listecol=intval($param['listecol']); else $listecol=0;
ele();
$collegate= array();
for ($x=1;$x<=$listecol;$x++)
    if ($param[$x]=='on') array_push($collegate,$x);
$collperd= array();
for ($x=1;$x<=$listecolper;$x++)
    if ($param[$x]=='on') array_push($collperd,$x);
if (mysql_num_rows($res)){
list($tipo_cons,$id_cons) = mysql_fetch_row($res);
$result = mysql_query("select fascia, capoluogo from ".$prefix."_ele_comuni where id_comune='$id_comune'", $dbi);
list($fascia,$capoluogo) = mysql_fetch_row($result);
if (!$gruppo){
	$res_val = mysql_query("SELECT sum(validi) from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi);
	list($validi) = mysql_fetch_row($res_val);
	$res_lis = mysql_query("SELECT t1.num_gruppo,sum(t2.voti) from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_voti_gruppo as t2 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo group by t1.num_gruppo order by t1.num_gruppo",$dbi);
	while (list($num_gruppo,$voti)= mysql_fetch_row($res_lis)){
		if ($voti>($validi/2)) {$gruppo=$num_gruppo;break;}
	}
}
if($fascia<6 and $capoluogo) $fascia=6;
if ($fascia<$limite) consmin($fascia);
elseif ($gruppo>0) conssup($fascia,$gruppo,$collegate,$collperd);
elseif ($numgruppo>0){
	echo "<form name=\"gruppo\" action=\"admin.php\">"
	."<input type=\"hidden\" name=\"op\" value=\"consiglieri\">";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<br>";
	echo "<table><tr><td bgcolor=\"$bgcolor1\"><b>"._GRUVIN."</b></td>";
	$res = mysql_query("SELECT id_gruppo,descrizione FROM ".$prefix."_ele_gruppo where id_cons='$id_cons' and num_gruppo=$numgruppo", $dbi);
	list($idgruppo, $descr_gruppo) = mysql_fetch_row($res);
        echo "<td bgcolor=\"$bgcolor1\"><b>$descr_gruppo</b></td></tr></table>";
        $res_lis = mysql_query("SELECT num_lista,descrizione from ".$prefix."_ele_lista where id_cons='$id_cons' and id_gruppo!=$idgruppo",$dbi);
        echo "Selezionare le liste collegate al secondo turno <table>";
        $x=0;
        while(list($num_lista,$descr) = mysql_fetch_row($res_lis)) {
            echo "<tr><td>$num_lista</td><td>$descr</td><td><input type=\"checkbox\" name=\"$num_lista\" ></td></tr>";
            if ($num_lista>$x) $x=$num_lista;
        }
        echo "<tr><td><input type=\"hidden\" name=\"listecol\" value=\"$x\"><input type=\"hidden\" name=\"gruppo\" value=\"$numgruppo\">";
	echo "<input type=\"submit\" name=\"invia\" value=\""._OK."\"></td></tr></table></form>";
}else {
	echo "<form name=\"numgruppo\" action=\"admin.php\">"
	."<input type=\"hidden\" name=\"op\" value=\"consiglieri\">";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<br>";
	echo "<table><tr><td bgcolor=\"$bgcolor1\"><b>"._GRUVIN."</b></td><td>";
	$res = mysql_query("SELECT t1.num_gruppo,t1.descrizione, sum(t2.voti) as pref FROM ".$prefix."_ele_gruppo as t1, ".$prefix."_ele_voti_gruppo as t2 where t1.id_gruppo=t2.id_gruppo and t1.id_cons='$id_cons' group by t1.num_gruppo,t1.descrizione order by pref desc limit 0,2", $dbi);
	while(list($num_gruppo, $descr_gruppo,$pref) = mysql_fetch_row($res)) {
#		echo "<option value=\"$num_gruppo\">$descr_gruppo";
		echo "<input type=\"radio\" name=\"numgruppo\" value=\"$num_gruppo\">$descr_gruppo<br>";
	}
	echo "</td></tr>";
	echo "<tr><td><input type=\"submit\" name=\"invia\" value=\""._OK."\"></td></tr></table></form>";

}
}


function consmin($fascia) {
global $id_cons, $prefix,$dbi;
$sorteggio=0;
#funzione di calcolo per comuni fino a 15.000 abitanti
#carica numero di liste e voti, i voti sono quelli del gruppo perche' non c'e' voto di lista
$res_lis = mysql_query("SELECT t1.num_gruppo,sum(t2.voti) from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_voti_gruppo as t2 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo group by t1.num_gruppo order by t1.num_gruppo",$dbi);
$num_liste = mysql_num_rows($res_lis);
#carica le preferenze
$pref = array();
$test = 0;
$lisvin=0;
while (list($num_lista,$voti)= mysql_fetch_row($res_lis)){
	array_push($pref,$voti);
	if ($voti>$test) {$lisvin=$num_lista; $test=$voti;}
}
#setta a zero la lista vincente
$pref[($lisvin-1)]=0;
#carica il numero di consiglieri per la minoranza
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
}
$num_cons=number_format($numcons/3);
#carica gli array dei quozienti
for ($y=0;$y<$num_cons;$y++){
	for ($x=0;$x<10;$x++)
		$ele[$y][$x]= $pref[$y]/($x+1);
}
#inizializza l'array degli eletti
for ($x=0;$x<$num_liste;$x++)
	$eletti[$x]=0;

#for ($x=0;$x<$num_liste;$x++)
#echo $ele[$x][0]." <br>";
#estrae i quozienti piu' alti
$sorteggio=0;
for ($y=0;$y<$num_cons;$y++){
	$temp=0;
	$cand=0;
	for ($x=0;$x<$num_liste;$x++){
		if ($ele[$x][0]==$temp and $pref[$x]==$pref[$cand] and ($y+1)==$num_cons) {$sorteggio=1; $mex="Per attribuire l'ultimo seggio è necessario un sorteggio tra la lista n. ".($x+1)." e la lista n. ".($cand+1);}
		if ($ele[$x][0]>$temp or ($ele[$x][0]==$temp and $pref[$x]>$pref[$cand])) {
			$temp=$ele[$x][0];
			$cand=$x;
			$sorteggio=0;
		}
	}
	if (!$sorteggio){
 	$eletti[$cand]++;
 	array_shift($ele[$cand]);echo "<br>";
 	}
}
for ($x=0;$x<$num_liste;$x++)
 	echo "lista n. ".intval($x+1)." ".$eletti[$x]." eletti <br>";
echo "sorteggio: $sorteggio <br>";
echo "lista vincente ".$lisvin." ".number_format(($numcons*2)/3)." eletti"; 
}





function calcoloseggi($gruppi,$num_cons){
global $ultimo,$mex,$sorteggio;

include ("crea_pagina.php");
#carica le preferenze
$pref = array();
$ultimo=0;
$mex='';
$sorteggio=0;
unset($eletti);
#inizializza l'array degli eletti
#for ($x=1;$x<=$num_liste;$x++)
foreach ($gruppi as $x=>$val){
 $eletti[$x]=0;
 }
#carica gli array dei quozienti
#for ($y=0;$y<$num_liste;$y++)
foreach($gruppi as $y=>$tmp){
	for ($x=0;$x<$num_cons;$x++)
		$ele[$y][$x]= $tmp/($x+1);
}
#estrae i quozienti piu' alti
for ($y=0;$y<$num_cons;$y++){
 $temp=0;
 $cand=0;
# for ($x=0;$x<$num_liste;$x++){

foreach($gruppi as $x=>$tmp){  
  if ($ele[$x][0]==$temp and $pref[$x]==$pref[$cand] and ($y+1)==$num_cons) {$sorteggio=1; $mex="Per attribuire l'ultimo seggio è necessario un sorteggio tra la lista n. ".($x+1)." e la lista n. ".($cand+1);}
  if ($ele[$x][0]>$temp or ($ele[$x][0]==$temp and $pref[$x]>$pref[$cand])) {
   $temp=$ele[$x][0];
   $cand=$x;
   $sorteggio=0;
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

function stampalista($arvin,$arper) {
//echo "<table><tr><td>";
$x=0;
while (isset($arvin[$x][0])) {
echo "--------------vince key:$key - val:$val<br>";
   $y=0;
   while (isset($arvin[$x][$y])){
   	echo "-----chiave:$lista val:$y<br>";
   	$y++;
   }
$x++;
}
foreach ($arper as $key=>$val) {
   foreach($val as $x=>$y) echo "-----chiave:$x val:$y<br>";
echo "perde key:$key - val:$val<br>";
}

}

function conssup($fascia,$gruppo,$collegate,$collperd) {
global $id_cons, $prefix,$dbi;
global $groups,$lists,$eletti,$ultimo;
$groups=array();
$lists=array();
$eletti=array();

#$sorteggio=0;
#funzione di calcolo per comuni oltre 15.000 abitanti
#carica il numero di consiglieri da eleggere
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
}











/////////////////////test 
$varper="<table><tr><td>SEGGI ASSEGNATI ALLA MINORANZA</TD></TR></TABLE><table><tr> ";
$varvin="<table><tr><td>SEGGI ASSEGNATI ALLA MAGGIORANZA</TD></TR></TABLE><table><tr> ";
$res_val = mysql_query("SELECT sum(validi) from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi);
list($validi) = mysql_fetch_row($res_val);
$res_per = mysql_query("SELECT t1.descrizione,t1.num_gruppo,sum(t3.voti) as voti from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista group by t1.descrizione,t1.num_gruppo order by t1.num_gruppo",$dbi);
$groups=array();
$premio=0;
#carica l'array deui gruppi e della cifra di gruppo
while (list($descr,$num_gruppo,$voti)= mysql_fetch_row($res_per)){
    $desgruppi[$num_gruppo]=$descr;
    #controlla se un gruppo di liste, tra quelle perdenti, ha superato il 50%
    if ($num_gruppo!=$gruppo and $voti>= $validi/2) $premio=2;
    $groups[($num_gruppo)]=$voti;
    #elimina gruppi che non hanno superato lo sbarramento
    if ($voti< ($validi*3)/100) unset($groups[($num_gruppo)]);
}
#controlla se la percentuale del gruppo vincente e' tra il 40 e il 60%
#e se nessun altro gruppo ha superato il 50% assegna il premio di maggioranza
if ($groups[$gruppo]>number_format(($validi*4)/10) and $groups[$gruppo]<number_format(($validi*6)/10) and !$premio) $premio=1;
else $premio=0;

$candidati=array();
if ($premio) {
    $sindaco[$gruppo]=$groups[$gruppo];
    unset($groups[$gruppo]);
    $gruppomag=calcoloseggi($sindaco,($numcons*6/10));
#######calcola i seggi per lista
$arvin[0][0]=$desgruppi[$gruppo];
foreach ($gruppomag as $key=>$val){
    echo " gruppo n. : $key : val : $val<br>";
echo "ultimo assegnato al gruppo: $ultimo<br>";
$res_lis = mysql_query("SELECT t2.id_lista,t2.descrizione,t2.num_lista,sum(t3.voti) as voti from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista and t1.num_gruppo='$key' group by t2.id_lista,t2.descrizione,t2.num_lista order by t2.num_lista",$dbi);
while (list($id_lista,$descr,$x,$y)=mysql_fetch_row($res_lis)){
    $pos=1;
    $arvin[$x][$pos++]=$descr." - Voti: $y (".number_format($y*100/$validi,2)."%)"; 
    $res_can = mysql_query("SELECT concat(t1.cognome,' ',t1.nome) as descr,sum(t2.voti) as voti from ".$prefix."_ele_candidati as t1, ".$prefix."_ele_voti_candidati as t2 where t1.id_lista='$id_lista' and t1.id_cand=t2.id_cand GROUP BY descr order by voti desc,num_cand",$dbi);
    while(list($cand,$pre)=mysql_fetch_row($res_can)) $arvin[$x][$pos++]=$descr." - $y ";
    $listemag[$x]=$y;
    $desliste[$x]=$descr;
}
#foreach ($groups as $key=>$val)echo "           key: $key : val : $val<br>";
    $seggimag=array();
    $seggimag=calcoloseggi($listemag,$val);
    foreach ($seggimag as $key=>$val){
    	$arvin[$key][0]=$val;
        echo "lista n. $key seggi spettanti:$val<br>";
#        $consiglio
    }
}
$numcons=($numcons*4/10);
}

#####calcolo per la minoranza o in caso non ci sia premio di maggioranza   
$gruppomin=calcoloseggi($groups,$numcons);
foreach ($gruppomin as $key=>$val){
	if(!$premio and $key==$gruppo) $arvin[0][0]=$desgruppi[$gruppo];
	else $arper[0][0]=$desgruppi[$key];
    echo " gruppo n. : $key : val : $val<br>";
echo "ultimo assegnato al gruppo: $ultimo<br>";
$res_lis = mysql_query("SELECT t2.id_lista,t2.descrizione,t2.num_lista,sum(t3.voti) as voti from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista and t1.num_gruppo='$key' group by t2.id_lista,t2.descrizione,t2.num_lista order by t2.num_lista",$dbi);
$x=0;
while (list($id_lista,$descr,$x,$y)=mysql_fetch_row($res_lis)){
    unset($listemin);
    $pos=1;
    if(!$premio and $key==$gruppo) $arvin[$x][$pos++]=$descr." - Voti: $y (".number_format($y*100/$validi,2)."%)";
    else $arper[$x][$pos++]=$descr." - Voti: $y (".number_format($y*100/$validi,2)."%)"; 
    $res_can = mysql_query("SELECT concat(t1.cognome,' ',t1.nome) as descr,sum(t2.voti) as voti from ".$prefix."_ele_candidati as t1, ".$prefix."_ele_voti_candidati as t2 where t1.id_lista='$id_lista' and t1.id_cand=t2.id_cand GROUP BY descr order by voti desc,num_cand",$dbi);
    while(list($cand,$pre)=mysql_fetch_row($res_can)) 
    if(!$premio and $key==$gruppo) $arvin[$x][$pos++]=$descr." - $y ";
    else $arper[$x][$pos++]=$descr." - $y ";
    $listemin[$x]=$y;
    $desliste[$x]=$descr;
}
#foreach ($groups as $key=>$val)echo "           key: $key : val : $val<br>";
    $seggimin=array();
    $seggimin=calcoloseggi($listemin,$val);
    foreach ($seggimin as $key=>$val){
    	if(!$premio and $key==$gruppo) $arvin[$key][0]=$val;
    	else $arper[$key][0]=$val;
        echo "lista n. $key seggi spettanti:$val<br>";
#        $consiglio
    }
}
crea_tabella($arvin);
crea_tabella($arper);

/*if(isset($listemin)) unset($listemin);
echo "<br><br><br> gruppo n. : $key : val : $val<br>";
echo "ultimo assegnato al gruppo: $ultimo<br>";
$res_lis = mysql_query("SELECT t2.num_lista,sum(t3.voti) from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista and t1.num_gruppo='$key' group by t2.num_lista order by t2.num_lista",$dbi);
$x=0;
while (list($x,$y)=mysql_fetch_row($res_lis)) $listemin[$x]=$y;
#foreach ($groups as $key=>$val)echo "           key: $key : val : $val<br>";
    $seggimin=array();
    $seggimin=calcoloseggi($listemin,$val);
    foreach ($seggimin as $key=>$val){
        if ($key==$ultimo) $val--;
        echo "lista n. $key seggi spettanti:$val<br>";
    }
}
/*$seggi = array();
$seggi=calcoloseggi($groups,$numcons);
foreach ($seggi as $key=>$val){
unset($groups);
 echo " gruppo n. : $key : val : $val<br>";
echo "ultimo assegnato al gruppo: $ultimo<br>";
$res_lis = mysql_query("SELECT t2.num_lista,sum(t3.voti) from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista and t1.num_gruppo='$key' group by t2.num_lista order by t2.num_lista",$dbi);
$x=0;
while (list($x,$y)=mysql_fetch_row($res_lis)) $groups[$x]=$y;
#foreach ($groups as $key=>$val)echo "           key: $key : val : $val<br>";
    $seggilista=array();
    $seggilista=calcoloseggi($groups,$val);
    foreach ($seggilista as $key=>$val){
        if ($key==$ultimo) $val--;
        echo "lista n. $key seggi spettanti:$val<br>";
    }
}
/*while (list($num_gruppo,$num_lista,$voti)= mysql_fetch_row($res_lis)){
    //array_push($groups[($num_gruppo)],($num_lista));
    $groups[($num_gruppo)][($num_lista)]=array();
    array_push($groups[($num_gruppo)][($num_lista)],$voti);
}
foreach ($groups as $key=>$val){
echo "gruppo: $key -- voti: ".$val[0]."<br>";
    foreach($val[1] as $lis=>$vot)
        foreach ($vot as $des=>$che)
            echo " lista $des voti $che<br>";
}*/
//////////////////////////





#controlla che la lista vincente abbia ottenuto almeno il 40% dei voti validi e meno del 60
$res_vin = mysql_query("SELECT sum(t3.voti) from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista and t1.num_gruppo='$gruppo'",$dbi);
list($voti)= mysql_fetch_row($res_vin);
$res_val = mysql_query("SELECT sum(validi) from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi);
list($validi) = mysql_fetch_row($res_val);
#ma nessun altro gruppo di liste deve aver raggiunto il 50% dei voti validi
$res_per = mysql_query("SELECT t1.num_gruppo,sum(t3.voti) from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista and t1.num_gruppo!='$gruppo' group by t1.num_gruppo order by t1.num_gruppo",$dbi);
$premio=0;
$gruppi=0;
$quorum=array();
if ($voti>number_format(($validi*4)/10) and $voti<number_format(($validi*6)/10)) $premio=1;
while (list($gruppoper,$voti)= mysql_fetch_row($res_per))
{
	if ($voti>= $validi/2) $premio=0;
	if ($voti>= ($validi*3)/100) {array_push($quorum,$gruppoper);}
	$gruppi++;
}
if (!$premio)array_push($quorum,$gruppo);
#carica numero di liste e voti, se c'e' il premio si effettuano due calcoli separati uno per le liste vincenti e uno per le altre
if ($premio){ 
	$res_lisper = mysql_query("SELECT t1.num_gruppo,t2.num_lista,sum(t3.voti) from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista and t1.num_gruppo != '$gruppo' group by t1.num_gruppo,t2.num_lista order by t2.num_lista",$dbi);
	$num_liste = mysql_num_rows($res_lisper);
	$num_cons=number_format(($numcons*4)/10);
	$res_lisvin = mysql_query("SELECT t2.num_lista,sum(t3.voti) from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista and t1.num_gruppo = '$gruppo' group by t2.num_lista order by t2.num_lista",$dbi);
	$num_listevin = mysql_num_rows($res_lisvin);
	$num_consvin=number_format(($numcons*6)/10);
}else{
	$res_lisper = mysql_query("SELECT t1.num_gruppo,t2.num_lista,sum(t3.voti) from ".$prefix."_ele_gruppo as t1,  ".$prefix."_ele_lista as t2, ".$prefix."_ele_voti_lista as t3 where t1.id_cons='$id_cons' and t1.id_gruppo=t2.id_gruppo and t2.id_lista=t3.id_lista group by t1.num_gruppo,t2.num_lista order by t2.num_lista",$dbi);
	$num_liste = mysql_num_rows($res_lisper);
	$num_cons=$numcons;
}
#carica le preferenze
$pref = array();
$liste = array();
$digruppo = array();
$ultimo = array();
$groups = array();
#inizializza l'array degli eletti
for ($x=0;$x<=$num_liste;$x++){
 $eletti[$x]=0;
 }
 $x=0;
while (list($num_gruppo,$num_lista,$voti)= mysql_fetch_row($res_lisper)){
	if (!in_array($num_gruppo,$quorum)) {$voti=0;}
	array_push($pref,$voti);
	array_push($liste,$num_lista);
	$digruppo[$x]=$num_gruppo;
	if (!isset($groups[$num_gruppo])) $groups[$num_gruppo]=array(); 
	array_push($groups[$num_gruppo],$num_lista);
	$x++;
}
#carica gli array dei quozienti
for ($y=0;$y<$num_liste;$y++){
	for ($x=0;$x<$num_cons;$x++)
		$ele[$y][$x]= $pref[$y]/($x+1);
}
#estrae i quozienti piu' alti
$sorteggio=0;
for ($y=0;$y<$num_cons;$y++){
 $temp=0;
 $cand=0;
 $mex='';
 for ($x=0;$x<$num_liste;$x++){
  if ($ele[$x][0]==$temp and $pref[$x]==$pref[$cand] and ($y+1)==$num_cons) {$sorteggio=1; $mex="Per attribuire l'ultimo seggio è necessario un sorteggio tra la lista n. ".($x+1)." e la lista n. ".($cand+1);}
  if ($ele[$x][0]>$temp or ($ele[$x][0]==$temp and $pref[$x]>$pref[$cand])) {
   $temp=$ele[$x][0];
   $cand=$x;
   $sorteggio=0;
  }
 }
 if (!$sorteggio){
 	$eletti[$cand]++;
 	$ultimo[$digruppo[($cand)]]=$cand;
 	array_shift($ele[$cand]);
 }
}

foreach ($ultimo as $key=>$sind) { //echo "lista: $sind - gruppo: $key eletti: ".$eletti[($val-1)]."<br>";
 if($key!=$gruppo) $eletti[$sind]--;
}
#
#foreach($groups as $key=>$val1) foreach ($val1 as $val) echo "gruppo: $key - lista: $val eletti: ".$eletti[($val-1)]."<br>";
#for ($x=0;$x<$num_liste;$x++) //caricare in una variabile il testo da visualizzare, e' necessario controllare: if (!$premio) vanno separate le liste vincenti dalle altre 
# echo "lista n. ".$liste[$x]." ".$eletti[$x]." eletti<br>";
#echo "sorteggio: $sorteggio <br>";
$varper="<table><tr><td>SEGGI ASSEGNATI ALLA MINORANZA</TD></TR></TABLE><table><tr> ";
$varvin="<table><tr><td>SEGGI ASSEGNATI ALLA MAGGIORANZA</TD></TR></TABLE><table><tr> ";

#for ($y=0;$y<$gruppi;$y++) 
foreach($groups as $key=>$val1) {
    if (isset($ultimo[$key])) {
    $res_gru = mysql_query("SELECT descrizione from ".$prefix."_ele_gruppo where id_cons='$id_cons' and num_gruppo='".$key."'",$dbi);
    list($descr) = mysql_fetch_row($res_gru);
    if ($key==$gruppo){
        $varvin.= "<td valign=\"top\">\n<table><tr><td> Seggi spettanti al gruppo n. ".$key."</td></tr>";
        $varvin.="<tr><td bgcolor=\"".$_SESSION['bgcolor2']."\">SINDACO ELETTO: $descr</td></tr><tr></table>\n";
        $varvin.="<table><tr>";
    }else{
        $varper.= "<td valign=\"top\">\n<table><tr><td> Seggi spettanti al gruppo n. ".$key."</td></tr>";
        $varper.="<tr><td bgcolor=\"".$_SESSION['bgcolor2']."\">$descr</td></tr><tr></table>\n";
        $varper.="<table><tr>";
    }
    foreach($val1 as $val) { 
        if ($eletti[($val-1)]){ 
            $res_lis = mysql_query("SELECT id_lista,descrizione from ".$prefix."_ele_lista where id_cons='$id_cons' and num_lista='".$val."'",$dbi);
            list($id_lista,$descr) = mysql_fetch_row($res_lis);
            $res_lis = mysql_query("SELECT concat(t1.cognome,' ',t1.nome) as descr,sum(t2.voti) as voti from ".$prefix."_ele_candidati as t1, ".$prefix."_ele_voti_candidati as t2 where t1.id_lista='$id_lista' and t1.id_cand=t2.id_cand GROUP BY descr order by voti desc,num_cand",$dbi);
            if ($key==$gruppo) $varvin.="<td valign=\"top\">\n<table><tr><td>Lista n. $val: $descr <b>seggi ".$eletti[($val-1)]."</b></td><td></td></tr>";
            else $varper.="<td valign=\"top\">\n<table><tr><td>Lista n. $val: $descr <b>seggi ".$eletti[($val-1)]."</b></td><td></td></tr>";
            $x=0;
            while (list($descr,$voti) = mysql_fetch_row($res_lis)) {
                $bgcolor1= (($x++)<$eletti[($val-1)]) ? $_SESSION['bgcolor2'] : $_SESSION['bgcolor1'] ;
                if ($key==$gruppo) $varvin.="<tr><td bgcolor=\"$bgcolor1\">$descr</td><td bgcolor=\"$bgcolor1\">$voti</td></tr>";
                else $varper.="<tr><td bgcolor=\"$bgcolor1\">$descr</td><td bgcolor=\"$bgcolor1\">$voti</td></tr>";
            }
            if ($key==$gruppo) $varvin.= "</table>\n</td>";
            else $varper.= "</table>\n</td>";
        }
    }
            if ($key==$gruppo) $varvin.="</tr></table>\n</td>";
            else $varper.="</tr></table>\n</td>";
    } 
  }
    $varper.="</tr><tr><td>$mex</td></tr></table>\n";

unset ($eletti);
unset($ele);
if($premio){
$num_cons=$num_consvin;
$num_liste=$num_listevin;
#carica le preferenze
$pref = array();
$liste = array();
while (list($num_lista,$voti)= mysql_fetch_row($res_lisvin)){
	array_push($pref,$voti);
	array_push($liste,$num_lista);
}
#carica gli array dei quozienti
for ($y=0;$y<$num_liste;$y++){
	for ($x=0;$x<$num_cons;$x++)
		$ele[$y][$x]= $pref[$y]/($x+1);
}
#inizializza l'array degli eletti
for ($x=0;$x<$num_liste;$x++)
 $eletti[$x]=0;
#estrae i quozienti piu' alti
$sorteggio=0;
for ($y=0;$y<$num_cons;$y++){
 $temp=0;
 $cand=0;
 for ($x=0;$x<$num_liste;$x++){
	if ($ele[$x][0]==$temp and $pref[$x]==$pref[$cand] and ($y+1)==$num_cons) {$sorteggio=1; $mex="Per attribuire l'ultimo seggio è necessario un sorteggio tra la lista n. ".($x+1)." e la lista n. ".($cand+1);}
  if ($ele[$x][0]>$temp or ($ele[$x][0]==$temp and $pref[$x]>$pref[$cand])) {
   $temp=$ele[$x][0];
   $cand=$x;
   $sorteggio=0;
  }
 }
 if (!$sorteggio){
	$eletti[$cand]++;
	array_shift($ele[$cand]);
 }
}
#visualizza il gruppo, il candidato a sindaco eletto consigliere, le liste e i consiglieri
#for ($x=0;$x<$num_liste;$x++)
# echo "lista n. ".$liste[$x]." ".$eletti[$x]." eletti <br>";
#echo "sorteggio: $sorteggio <br>";
#foreach($eletti as $key=>$val) echo "lista: ".$liste[$key]." - eletti: $val <br>";
///////////////
//foreach($groups as $key=>$val1) {echo "lista: $val - gruppo: $key eletti: ".$eletti[($val-1)]."<br>";
    $key=$gruppo;
    $res_gru = mysql_query("SELECT descrizione from ".$prefix."_ele_gruppo where id_cons='$id_cons' and num_gruppo='".$key."'",$dbi);
    list($descr) = mysql_fetch_row($res_gru);
        $varvin.= "<td valign=\"top\">\n<table><tr><td> Seggi spettanti al gruppo n. ".$key."</td></tr>";
        $varvin.="<tr><td bgcolor=\"".$_SESSION['bgcolor2']."\">SINDACO ELETTO: $descr</td></tr><tr></table>\n";
        $varvin.="<table><tr>";
    foreach($eletti as $lis=>$val) { //echo "lista: ".$liste[$lis]." - gruppo: $key eletti: ".$val."<br>";
//        if ($eletti[($val-1)]){ 
            $res_lis = mysql_query("SELECT id_lista,descrizione from ".$prefix."_ele_lista where id_cons='$id_cons' and num_lista='".$liste[$lis]."'",$dbi);
            list($id_lista,$descr) = mysql_fetch_row($res_lis);
            $res_lis = mysql_query("SELECT concat(t1.cognome,' ',t1.nome) as descr,sum(t2.voti) as voti from ".$prefix."_ele_candidati as t1, ".$prefix."_ele_voti_candidati as t2 where t1.id_lista='$id_lista' and t1.id_cand=t2.id_cand GROUP BY descr order by voti desc,num_cand",$dbi);
            $varvin.="<td valign=\"top\">\n<table><tr><td>Lista n. ".$liste[$lis].": $descr <b>seggi ".$val."</b></td><td></td></tr>";
            $x=0;
            while (list($descr,$voti) = mysql_fetch_row($res_lis)) {
                $bgcolor1= (($x++)<$val) ? $_SESSION['bgcolor2'] : $_SESSION['bgcolor1'] ;
                $varvin.="<tr><td bgcolor=\"$bgcolor1\">$descr</td><td bgcolor=\"$bgcolor1\">$voti</td></tr>";
            }
            $varvin.= "</table>\n</td>";
//        }
    }
            $varvin.="</tr></table>\n</td>";
     
  
///////////////
}
$varvin.="</tr><tr><td>$mex</td></tr></table>\n";
    echo $varvin;
    echo $varper;

}




?>
