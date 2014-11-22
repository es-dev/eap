<?php

/************************************************************************/
/* copia lista elezioni 1999 a elezioni 99 candidati, liste, gruppi     */
/* 2003                                                                 */
/************************************************************************/
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}


$perms=ChiSei($id_cons_gen);
if ($perms>128) {

	if (!IsSet($mainfile)) { include ("mainfile.php"); }
	$res = sql_query("SELECT tipo_cons FROM ".$prefix."_ele_consultazione where id_cons=$id_cons " , $dbi);
	list($tipo_cons) = sql_fetch_row($res, $dbi);

	include("modules/Elezioni/language/lang-$currentlang.php");
	include("includes/javascript.php");
	include("modules/Elezioni/funzionidata.php");
	include("modules/Elezioni/ele.php");

	global $admin, $bgcolor1, $bgcolor2,  $bgcolor6, $prefix, $dbi, $offset, $min, $id_cons;


/*
		$res=sql_query("select * from ".$prefix."_ele_lista where id_cons='12'", $dbi);
	while (list($id_cons2,$id_lista,$num_lista,$id_gruppo,$id_circ,$descrizione,$simbolo)=sql_fetch_row($res,$dbi)){
sql_query("insert into ".$prefix."_ele_lista values ('22','','$num_lista','$id_gruppo','$id_circ','$descrizione','nulla.jpg')", $dbi);
  //       echo "Lista= $descrizione  [$id_lista] [$id_cons2] <br>";
}
*/

	$res=sql_query("select * from ".$prefix."_ele_candidati where id_cons='12'", $dbi);
	while (list($id,$id_cons2,$id_lista,$cognome,$nome,$note,$simbolo,$num_cand)=sql_fetch_row($res,$dbi)){
sql_query("insert into ".$prefix."_ele_candidati values ('','22','','$cognome','$nome','$note','nulla.jpg','$num_cand')", $dbi);
//         echo "Candidato= $cognome $nome [$id] [$id_cons2] [$id_lista]<br>";
}


}
?>
