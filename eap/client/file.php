<?php

include("config.php");
if(!$dbi = mysql_connect($dbhost, $dbuname, $dbpass)){
die("<center><img src=\"images/logo.gif\" target=\"Logo Avviso Errore\"><br><br><b>Ci sono dei problemi di connessione al Server $dbtype, chiediamo scusa per l'inconveniente.<br><br>Provate piu' tardi, Grazie.</b><br><font color=\"#ff0000\">". mysql_error()."</font></center>");
}
$fase=intval($_GET['fase']);

if(!mysql_select_db($dbname)){
die("<center><img src=src=\"images/logo.gif\" target=\"Logo Avviso Errore\"><br><br><b>Ci sono dei problemi di connessione al DataBase $dbtype, chiediamo scusa per l'inconveniente.<br><br>Provate piu' tardi, Grazie.</b><br><font color=\"#ff0000\">". mysql_error()."</font></center>");
}
mysql_query("SET NAMES 'utf8'", $dbi);
if ($fase=='1'){
	$res = mysql_query("SELECT id_cons_gen,descrizione from ".$prefix."_ele_consultazione order by descrizione",$dbi);
Header("content-type: application/x-javascript");
echo "document.write(\"<b><select name=\'id_cons_gen2\'>";

while(list($id_cons_gen2,$descr) = mysql_fetch_row($res)) {
			echo "<option value=\'$id_cons_gen2\'>$descr";
		}
		echo "</select>";
mysql_data_seek($res,0);
while(list($id_cons_gen2,$descr) = mysql_fetch_row($res)) {
			echo "<input type=\'hidden\' name=\'$id_cons_gen2\' value=\'$descr\'>";
		}
echo "</b>\")";

}elseif ($fase=='2'){
	$id_cons_gen2=intval($_GET['id_cons_gen2']);
	$rescons = mysql_query("SELECT descrizione from ".$prefix."_ele_consultazione where id_cons_gen='$id_cons_gen2'",$dbi);
	list($descr_cons) = mysql_fetch_row($rescons);
	$res = mysql_query("SELECT t2.id_comune,t2.descrizione from ".$prefix."_ele_cons_comune as t1 left join ".$prefix."_ele_comuni as t2 on t1.id_comune=t2.id_comune where t1.id_cons_gen=$id_cons_gen2 order by t2.descrizione ",$dbi);
Header("content-type: application/x-javascript");
echo "document.write(\"<b><input type=\'hidden\' name=\'id_cons_gen2\' value=\'$id_cons_gen2\'><select name=\'id_comune2\'>";

while(list($id_comune2,$descr) = mysql_fetch_row($res)) {
			echo "<option value=\'$id_comune2\'>$descr";
		}
		echo "</select>";
echo "</b>\")";
}


?>
