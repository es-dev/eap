<?php
$res_comune = mysql_query("select id_cons from ".$prefix."_ele_cons_comune where id_cons_gen='$id_cons_gen' and id_comune='$id_comune'" ,$dbi);
list($id_cons)=mysql_fetch_row($res_comune);
$res_comune = mysql_query("select * from ".$prefix."_ele_cons_comune where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_cons_comune");
$res_comune = mysql_query("select * from ".$prefix."_ele_gruppo where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_gruppo");
$res_comune = mysql_query("select * from ".$prefix."_ele_lista where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_lista");
$res_comune = mysql_query("select * from ".$prefix."_ele_candidati where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_candidati");
$res_comune = mysql_query("select * from ".$prefix."_ele_circoscrizione where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_circoscrizione");
$res_comune = mysql_query("select * from ".$prefix."_ele_sede where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_sede");
$res_comune = mysql_query("select * from ".$prefix."_ele_sezioni where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_sezioni");
$res_comune = mysql_query("select * from ".$prefix."_ele_link where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_link");
$res_comune = mysql_query("select * from ".$prefix."_ele_come where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_come");
$res_comune = mysql_query("select * from ".$prefix."_ele_numeri where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_numeri");
$res_comune = mysql_query("select * from ".$prefix."_ele_servizi where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_servizi");
$res_comune = mysql_query("select * from ".$prefix."_ele_voti_candidati where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_voti_candidati");
$res_comune = mysql_query("select * from ".$prefix."_ele_voti_gruppo where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_voti_gruppo");
$res_comune = mysql_query("select * from ".$prefix."_ele_voti_lista where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_voti_lista");
$res_comune = mysql_query("select * from ".$prefix."_ele_voti_parziale where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_voti_parziale");
$res_comune = mysql_query("select * from ".$prefix."_ele_voti_ref where id_cons='$id_cons'" ,$dbi);
scarica_array($res_comune,$prefix."_ele_voti_ref");


function scarica_array($res_comune,$tab){
echo "[$tab]\n";
if ($res_comune)
while ($lista = mysql_fetch_array($res_comune, MYSQL_ASSOC)) {
	$x=0;
	foreach ($lista as $key=>$val) {$lista[$key]=base64_encode($val);
		if ($x++) echo ":";
		
		echo "'".$lista[$key]."'";
	}
	echo "\n";
}
}
?>
